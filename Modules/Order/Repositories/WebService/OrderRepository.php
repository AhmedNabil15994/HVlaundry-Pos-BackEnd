<?php

namespace Modules\Order\Repositories\WebService;

use Carbon\Carbon;
use Modules\Apps\Repositories\Frontend\WorkingTimeRepository;
use Modules\Order\Traits\OrderCalculationTrait;
use Modules\Variation\Entities\ProductVariant;
use Modules\User\Repositories\WebService\AddressRepository;
use Modules\Order\Entities\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Order\Entities\OrderStatusesHistory;
use Illuminate\Support\Str;
use Modules\Order\Entities\PaymentStatus;

class OrderRepository
{
    use OrderCalculationTrait;

    protected $variantPrd;
    protected $order;
    protected $address;

    function __construct(Order $order, ProductVariant $variantPrd, AddressRepository $address,WorkingTimeRepository $workingTime)
    {
        $this->variantPrd = $variantPrd;
        $this->order = $order;
        $this->workingTime = $workingTime;
        $this->address = $address;
    }

    public function getAllByUser($userId, $userColumn = 'user_id', $order = 'id', $sort = 'desc')
    {
        $orders = $this->order->with(['orderStatus'])/*->successOrders()*/->where($userColumn, $userId)->orderBy($order, $sort)->get();
        return $orders;
    }

    public function findById($id)
    {
        $order = $this->order->with('orderProducts')->find($id);
        return $order;
    }

    public function findByIdWithUserId($id)
    {
        $order = $this->order->where('user_id', auth()->id())->find($id);
        return $order;
    }

    public function create($request, $userToken = null)
    {
        $cart = \Cart::session($userToken);
        $check = $cart->getCondition('company_delivery_fees');
        $cartAttributes = $check->getAttributes();
        $orderData = $this->calculateTheOrder($userToken,$cartAttributes['is_fast_delivery']);

        DB::beginTransaction();

        $pickUpDetails = $this->workingTime->getPickUpDayDetails($cartAttributes['pickup_working_times_id']);
        $deliveryDetails = $this->workingTime->getDeliveryDayDetails($cartAttributes['delivery_working_times_id']);

        try {

            $orderStatus = 7; // new_order
            $userId = $userToken;

            $orderCreated = $this->order->create([
                'original_subtotal' => $orderData['original_subtotal'],
                'subtotal' => $orderData['subtotal'],
                'off' => $orderData['off'],
                'shipping' => $orderData['shipping'],
                'total' => $orderData['total'],
                'total_profit' => $orderData['profit'],
                'user_id' => $userToken,
                'order_status_id' => $orderStatus,
                'payment_status_id' => null,
                'order_type' => $cartAttributes['order_type'] ?? 'direct_with_pieces',
                'order_notes' => $cartAttributes['order_notes'] ?? null,
                'is_fast_delivery' => $cartAttributes['is_fast_delivery'],
                'order_added_by' => 'mobile',
            ]);

            $receivingData = [
                'receiving_date' => $cartAttributes['receiving_date'],
                'receiving_time' => [
                    $pickUpDetails->pickupWorkingTimes[0]->from,
                    $pickUpDetails->pickupWorkingTimes[0]->to,
                ],
                'time_id'       => $cartAttributes['pickup_working_times_id'] ?? '',
                'receiving_time_format_type' => date('a',strtotime($pickUpDetails->pickupWorkingTimes[0]->to)),
            ];
            $deliveryData = [
                'delivery_date' =>  $cartAttributes['delivery_date'],
                'delivery_time' => [
                    $deliveryDetails->deliveryWorkingTimes[0]->from,
                    $deliveryDetails->deliveryWorkingTimes[0]->to,
                ],
                'time_id'       => $cartAttributes['delivery_working_times_id'] ?? '',
                'delivery_time_format_type' => date('a',strtotime($deliveryDetails->deliveryWorkingTimes[0]->to)),
            ];


            $orderCreated->orderTimes()->create([
                'receiving_data' => $receivingData,
                'delivery_data' => $deliveryData,
            ]);

            if (!is_null($orderStatus)) {
                $orderCreated->orderStatusesHistory()->sync([$orderStatus => ['user_id' => $userId]]);
            }

            $this->createOrderProducts($orderCreated, $orderData);

            $address = $this->address->findById($cartAttributes['address_id']);
            if ($address) {
                $this->createOrderAddress($orderCreated, $address, 'selected_address',$cartAttributes['address_id']);
                $orderCreated->update(['state_id' => $address->state_id]);
            }


            if (!is_null($orderData['coupon'])) {
                $orderCreated->orderCoupons()->create([
                    'coupon_id' => $orderData['coupon']['id'],
                    'code' => $orderData['coupon']['code'],
                    'discount_type' => $orderData['coupon']['type'],
                    'discount_percentage' => $orderData['coupon']['discount_percentage'],
                    'discount_value' => $orderData['coupon']['discount_value'],
                ]);
            }

            DB::commit();
            return $orderCreated;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function createOrderProducts($orderCreated, $orderData)
    {
        foreach ($orderData['products'] as $product) {

            $orderProduct = $orderCreated->orderProducts()->create([
                'product_id' => $product['product_id'],
                'off' => $product['off'],
                'qty' => $product['quantity'],
                'starch' => isset($product['starch'])? $product['starch'] : null,
                'price' => $product['original_price'],
                'sale_price' => $product['sale_price'],
                'original_total' => $product['original_total'],
                'total' => $product['total'],
                'total_profit' => $product['total_profit'],
                'notes' => $product['notes'] ?? null,
            ]);

            foreach ($product['qty_details'] as $item) {
                $orderCreated->orderCustomAddons()->create([
                    'order_product_id' => $orderProduct->id,
                    'addon_id' => $item['addon_id'],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'total' => floatval($item['price']) * intval($item['qty']),
                ]);
            }

        }
    }

    public function createOrderVendors($orderCreated, $vendors)
    {
        foreach ($vendors as $k => $vendor) {
            $orderCreated->vendors()->attach($vendor['id'], [
                'total_comission' => $vendor['commission'],
                'total_profit_comission' => $vendor['totalProfitCommission'],
                'original_subtotal' => $vendor['original_subtotal'],
                'subtotal' => $vendor['subtotal'],
                'qty' => $vendor['qty'],
            ]);
        }
    }

    public function createOrderAddress($orderCreated, $address, $type = '',$address_id=null)
    {
        $data = [];
        if ($type == 'guest_address') {
            $data = [
                'username' => $address['username'] ?? null,
                'email' => $address['email'] ?? null,
                'mobile' => $address['mobile'] ?? null,
                'address' => $address['address'] ?? null,
                'block' => $address['block'] ?? null,
                'street' => $address['street'] ?? null,
                'building' => $address['building'] ?? null,
                'state_id' => $address['state_id'] ?? null,
                'avenue' => $address['avenue'] ?? null,
                'floor' => $address['floor'] ?? null,
                'flat' => $address['flat'] ?? null,
                'automated_number' => $address['automated_number'] ?? null,
                'latitude' => $address['latitude'] ?? null,
                'longitude' => $address['longitude'] ?? null
            ];
        } elseif ($type == 'selected_address') {
            $data = [
                'username' => $address['username'] ?? auth('api')->user()->name,
                'email' => $address['email'] ?? (auth('api')->user()->email ?? null),
                'mobile' => $address['mobile'] ?? (auth('api')->user()->mobile ?? null),
                'address' => $address['address'] ?? null,
                'block' => $address['block'] ?? null,
                'street' => $address['street'] ?? null,
                'building' => $address['building'] ?? null,
                'state_id' => $address['state_id'] ?? null,
                'address_id' => $address_id,
                'avenue' => $address['avenue'] ?? null,
                'floor' => $address['floor'] ?? null,
                'flat' => $address['flat'] ?? null,
                'automated_number' => $address['automated_number'] ?? null,
                'latitude' => $address['latitude'] ?? null,
                'longitude' => $address['longitude'] ?? null
            ];
        }
        $orderCreated->orderAddress()->create($data);
    }

    public function createOrderCompanies($orderCreated, $request)
    {
        $price = getOrderShipping(auth('api')->check() ? auth('api')->id() : $request->user_id) ?? 0;

        $data = [
            'company_id' => config('setting.other.shipping_company') ?? null,
            'delivery' => floatval($price) ?? null,
        ];

        if (isset($request->shipping_company['availabilities']['day_code']) && !empty($request->shipping_company['availabilities']['day_code'])) {
            $dayCode = $request->shipping_company['availabilities']['day_code'] ?? '';
            $availabilities = [
                'day_code' => $dayCode,
                'day' => getDayByDayCode($dayCode)['day'],
                'full_date' => getDayByDayCode($dayCode)['full_date'],
            ];

            $data['availabilities'] = \GuzzleHttp\json_encode($availabilities);
        }

        if (config('setting.other.shipping_company')) {
            $orderCreated->companies()->attach(config('setting.other.shipping_company'), $data);
        }
    }

    public function createOrderDirectWithoutPieces($request, $address, $deliveryPrice)
    {
        DB::beginTransaction();
        try {

            $userId = auth('api')->id();
            $orderStatus = 7; // new_order
            $orderCreated = $this->order->create([
                'order_type' => 'direct_without_pieces',
                'is_fast_delivery' => $request->is_fast_delivery == '1',
                'shipping' => $deliveryPrice,
                'user_id' => $userId,
                'state_id' => $address->state_id,
                'order_status_id' => $orderStatus,
                'notes' => $request->notes,
                'order_added_by'    => 'mobile',
            ]);
            $receivingData = [
                'receiving_date' => $request->receiving_date,
                'receiving_time' => $request->receiving_time,
            ];
            $deliveryData = [
                'delivery_date' => $request->delivery_date,
                'delivery_time' => $request->delivery_time,
            ];
            $orderCreated->orderTimes()->create([
                'receiving_data' => $receivingData,
                'delivery_data' => $deliveryData,
            ]);

            $this->createOrderAddress($orderCreated, $address , $userId ? 'selected_address' : 'guest_address' , $request->address_id);

            DB::commit();
            return $orderCreated;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function createOrderData($request, $allProductAddons, $deliveryChargePrice, $subtotal, $user)
    {
        DB::beginTransaction();

        try {

            $orderStatus = 7; // new_order
            $userId = $user->id;

            $orderCreated = $this->order->create([
                'original_subtotal' => $subtotal,
                'subtotal' => $subtotal,
                'off' => 0,
                'shipping' => $deliveryChargePrice,
                'total' => $subtotal + $deliveryChargePrice,
                'total_profit' => 0,
                'user_id' => $userId,
                'order_status_id' => $orderStatus,
                'payment_status_id' => null,
                'order_type' => $request->order_type,
                'is_fast_delivery' => $request->is_fast_delivery == '1',
                'order_added_by' => 'dashboard',
            ]);

            $receivingData = [
                'receiving_date' => $request->receiving_date,
                'receiving_time' => $request->receiving_time,
                'receiving_time_format_type' => $request->receiving_time_format_type,
            ];
            $deliveryData = [
                'delivery_date' => $request->delivery_date,
                'delivery_time' => $request->delivery_time,
                'delivery_time_format_type' => $request->delivery_time_format_type,
            ];
            $orderCreated->orderTimes()->create([
                'receiving_data' => $receivingData,
                'delivery_data' => $deliveryData,
            ]);

            if (!is_null($orderStatus)) {
                $orderCreated->orderStatusesHistory()->sync([$orderStatus => ['user_id' => auth()->id()]]);
            }

            $this->createOrderProducts($allProductAddons, $orderCreated);

            $address = $this->address->findById($request->address_id);
            if ($address) {
                $this->createOrderAddress($orderCreated, $address, $user);
                $orderCreated->update(['state_id' => $address->state_id]);
            }

            DB::commit();

            return $orderCreated;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateOrder($request,$method = null)
    {
        $order = $this->findById($request['OrderID']);
        if (!$order)
            return false;


        if ($request['Result'] == 'CAPTURED') {
            $newOrderStatus = 7; // new_order
            $newPaymentStatus = optional(PaymentStatus::where('flag', 'success')->first())->id ?? $order->payment_status_id;
            $paymentConfirmedAt = date('Y-m-d H:i:s');
        } else {
            $newOrderStatus = 1; // failed
            $newPaymentStatus = optional(PaymentStatus::where('flag', 'failed')->first())->id ?? $order->payment_status_id;
            $paymentConfirmedAt = null;
        }

        $order->update([
            'order_status_id' => $newOrderStatus,
            'payment_status_id' => $newPaymentStatus,
            'payment_confirmed_at' => $paymentConfirmedAt,
            'increment_qty' => true,
        ]);

        // Add new order history
        $order->orderStatusesHistory()->attach([$newOrderStatus => ['user_id' => $order->user_id ?? null]]);

        $order->transactions()->updateOrCreate(
            [
                'transaction_id' => $request['OrderID']
            ],
            [
//                'method'    => $method,
                'auth' => $request['Auth'],
                'tran_id' => $request['TranID'],
                'result' => $request['Result'],
                'post_date' => $request['PostDate'],
                'ref' => $request['Ref'],
                'track_id' => $request['TrackID'],
                'payment_id' => $request['PaymentID'],
            ]
        );

        return $request['Result'] == 'CAPTURED' ? true : false;
    }
}
