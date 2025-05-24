<?php

namespace Modules\Pos\Repositories\Dashboard;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Catalog\Traits\ShoppingCartTrait;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderStatus;
use Modules\Order\Entities\PaymentStatus;
use Modules\Order\Traits\OrderCalculationTrait;
use Modules\User\Repositories\Dashboard\AddressRepository as AddressRepo;

class OrderRepository
{
    use OrderCalculationTrait, ShoppingCartTrait;

    protected $order;
    protected $address;

    public function __construct(Order $order, AddressRepo $address)
    {
        $this->order = $order;
        $this->address = $address;
    }

    public function findById($id)
    {
        $order = $this->order
            ->with([
                'orderProducts.product',
                'orderProducts.orderProductCustomAddons',
                'orderCoupons',
                'orderCustomAddons',
                'orderAddress',
                'driver'
            ])->withDeleted()->find($id);

        return $order;
    }

    public function customQueryTable($request, $flags = [])
    {
        $query = $this->order->with('orderAddress.state');
        if (!empty($flags)) {
            $query = $query->whereHas('orderStatus', function ($query) use ($flags) {
                $query->whereIn('flag', $flags);
            });
        }

        $query = $query->where(function ($query) use ($request) {
            $query->where('id', 'like', '%' . $request->input('search.value') . '%');
            $query->orWhere(function ($query) use ($request) {
                $query->whereHas('orderAddress', function ($query) use ($request) {
                    $query->where('username', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhere('mobile', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhere('email', 'like', '%' . $request->input('search.value') . '%');
                    $query->orWhereHas('state', function ($query) use ($request) {
                        $query->where('title', '%' . $request->input('search.value') . '%');
                    });
                });
            });
        });

        if(isset($request->user_id) && !empty($request->user_id)){
            $query = $query->where('user_id',$request->user_id);
        }

        return $this->filterDataTable($query, $request);
    }

    public function filterDataTable($query, $request)
    {
        if (isset($request['order_status_ids']) && !empty($request['order_status_ids']) && $request['order_status_ids'][0] != null) {
            $query->whereHas('orderStatus', function ($q) use ($request) {
                $q->whereIn('id', $request['order_status_ids']);
            });
        }

        if (isset($request['state_ids']) && !empty($request['state_ids']) && $request['state_ids'][0] != null) {
            $query->whereHas('orderAddress.state', function ($q) use ($request) {
                $q->whereIn('id', $request['state_ids']);
            });
        }

        if (isset($request['driver_ids']) && !empty($request['driver_ids']) && $request['driver_ids'][0] != null) {
            $query->whereHas('driver', function ($q) use ($request) {
                $q->whereIn('user_id', $request['driver_ids']);
            });
        }

        if (isset($request['payment_methods']) && !empty($request['payment_methods']) && $request['payment_methods'][0] != null) {
            $query->whereHas('transactions', function ($q) use ($request) {
                $q->whereIn('method', $request['payment_methods']);

            })->orWhereHas('paymentStatus', function ($q) use ($request) {
                $q->whereIn('flag',  $request['payment_methods']);
            });
        }

        if (isset($request['payment_status_ids']) && !empty($request['payment_status_ids']) && $request['payment_status_ids'][0] != null) {
           $query->whereIn('payment_status_id', $request['payment_status_ids']);
        }

        if (isset($request['user_id']) && !empty($request['user_id'])) {
            $query->where('user_id', $request['user_id']);
        }

        if (isset($request['types']) && !empty($request['types']) && $request['types'][0] != null) {
            if(in_array('pickup_delivery',$request['types'])){
                $query->whereHas('orderTimes',function ($q) {
                    $q->where('receiving_data->receiving_date','!=',null)->where('delivery_data->delivery_date','!=',null);
                });
            }else if(in_array('pickup',$request['types'])){
                $query->whereHas('orderTimes',function ($q) {
                    $q->where('receiving_data->receiving_date','!=',null)->whereNull('delivery_data->delivery_date');
                });
            }else if(in_array('delivery',$request['types'])){
                $query->whereHas('orderTimes',function ($q) {
                    $q->where('delivery_data->delivery_date','!=',null)->whereNull('receiving_data->receiving_date');
                });
            }
        }

        if (isset($request['date_type']) && !empty($request['date_type'])  && $request['date_type'][0] != null &&
            isset($request['date_range']) && !empty($request['date_range'])) {
            $arr = explode(' - ', $request['date_range']);
            $arr[0] = date('Y-m-d 00:00:00', strtotime($arr[0]));
            $arr[1] = date('Y-m-d 23:59:59', strtotime($arr[1]));
            if($request['date_type'] == 'placed'){
                $query->whereBetween('created_at',$arr);
            }else if($request['date_type'] == 'payment'){
                $query->whereBetween('payment_confirmed_at',$arr);
            }else if($request['date_type'] == 'pickup'){
                $query->whereHas('orderTimes',function ($q) use ($arr) {
                    $arr[0] = date('Y-m-d', strtotime($arr[0]));
                    $arr[1] = date('Y-m-d', strtotime($arr[1]));
                    $q->whereBetween('receiving_data->receiving_date',$arr);
                });
            }else if($request['date_type'] == 'delivery'){
                $query->whereHas('orderTimes',function ($q) use ($arr) {
                    $arr[0] = date('Y-m-d', strtotime($arr[0]));
                    $arr[1] = date('Y-m-d', strtotime($arr[1]));
                    $q->whereBetween('delivery_data->delivery_date',$arr);
                });
            }
        }

        return $query;
    }

    public function confirmPayment($order)
    {
        DB::beginTransaction();

        try {

            // if (in_array(optional($order->paymentStatus)->flag, ['pending', 'cash'])) {
            if (is_null($order->payment_confirmed_at)) {
                $order->payment_status_id = optional(PaymentStatus::where('flag', 'cash')->first())->id ?? $order->payment_status_id;
                $order->payment_confirmed_at = date('Y-m-d H:i:s');
                $order->save();
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function createOrderAddress($orderCreated, $address, $user)
    {
        $orderCreated->orderAddress()->create([
            'username' => $address['username'] ?? $user->name,
            'email' => $address['email'] ?? ($user->email ?? null),
            'mobile' => $address['mobile'] ?? ($user->mobile ?? null),
            'address' => $address['address'] ?? null,
            'block' => $address['block'] ?? null,
            'street' => $address['street'] ?? null,
            'building' => $address['building'] ?? null,
            'state_id' => $address['state_id'] ?? null,
            'avenue' => $address['avenue'] ?? null,
            'floor' => $address['floor'] ?? null,
            'flat' => $address['flat'] ?? null,
            'automated_number' => $address['automated_number'] ?? null,
            'address_id' => $address['id'] ?? null,
        ]);
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

    public function createPosOrder($request)
    {
        $userId = $request->customer_id ?? config('setting.order_default_customer_id');
        $orderData = $this->calculateTheOrder($userId , $request->is_fast_delivery);
        $receivingData = [];
        $deliveryData = [];

        DB::beginTransaction();

        try {

            $orderStatus = $request->order_status_id ?? 7; // new_order
            $paymentStatus = $request->payment_status_id ?? null;

            $orderCreated = $this->order->create([
                'original_subtotal' => $orderData['original_subtotal'],
                'subtotal' => $orderData['subtotal'],
                'off' => $orderData['off'],
                'shipping' => $orderData['shipping'],
                'total' => $orderData['total'],
                'total_profit' => $orderData['profit'],
                'user_id' => $userId,
                'order_status_id' => $orderStatus,
                'payment_status_id' => $paymentStatus,
                'order_type' => 'direct_with_pieces',
                'is_fast_delivery' => $request->is_fast_delivery == '1',
                'payment_confirmed_at' => $request->payment_confirmed_at ?? null,
                'notes' => $request->notes,
                'order_added_by'    => 'pos',
                'order_notes' => $request->order_notes ?? null,
            ]);

            if($request->has_pick_up){
                $receivingData = [
                    'receiving_date' => $request->pickup_date,
                    'receiving_time' => $request->receiving_time,
                    'time_id'       => $request->pickup_working_times_id ?? '',
                ];
            }

            if($request->has_delivery){
                $deliveryData = [
                    'delivery_date' => $request->delivery_date,
                    'delivery_time' => $request->delivery_time,
                    'time_id'       => $request->delivery_working_times_id ?? '',
                ];
            }

            $orderCreated->orderTimes()->create([
                'receiving_data' => $receivingData,
                'delivery_data' => $deliveryData,
            ]);

            if (!is_null($orderStatus)) {
                $orderCreated->orderStatusesHistory()->sync([$orderStatus => ['user_id' => ($request->customer_id ?? auth()->id())]]);
            }

            $this->createOrderProducts($orderCreated, $orderData);

            if (!is_null($orderData['coupon'])) {
                $orderCreated->orderCoupons()->create([
                    'coupon_id' => $orderData['coupon']['id'],
                    'code' => $orderData['coupon']['code'],
                    'discount_type' => $orderData['coupon']['type'],
                    'discount_percentage' => $orderData['coupon']['discount_percentage'],
                    'discount_value' => $orderData['coupon']['discount_value'],
                ]);
            }

            $address = $this->address->findById($request->address_id);
            if ($address) {
                $this->createOrderAddress($orderCreated, $address,$orderCreated->user);
                $orderCreated->update(['state_id' => $address->state_id]);
            }

            if($paymentStatus == 2 && $request->payment_confirmed_at){
                $orderCreated->transactions()->updateOrCreate(
                    [
                        'transaction_id' => $orderCreated->id,
                    ],
                    [
                        'auth' => '',
                        'method'    => $request->payment_type,
                        'tran_id' => '',
                        'result' => 'CAPTURED',
                        'post_date' => $request->payment_confirmed_at,
                        'ref' => '',
                        'track_id' => '',
                        'payment_id' => '',
                    ]
                );
            }

            DB::commit();
            return $orderCreated;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
