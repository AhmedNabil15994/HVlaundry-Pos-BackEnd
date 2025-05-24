<?php

namespace Modules\Order\Http\Controllers\WebService;

use Darryldecode\Cart\CartCondition;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;
use Modules\Apps\Repositories\Frontend\WorkingTimeRepository as WorkingTimeRepo;
use Modules\Catalog\Repositories\FrontEnd\ProductRepository as Product;
use Modules\Catalog\Repositories\WebService\CatalogRepository as Catalog;
use Modules\Catalog\Traits\ShoppingCartTrait;
use Modules\Company\Repositories\FrontEnd\DeliveryChargeRepository as DeliveryCharge;
use Modules\Company\Repositories\WebService\CompanyRepository as Company;
use Modules\Order\Events\ActivityLog;
use Modules\Order\Http\Requests\WebService\StartOrderValidationRequest;
use Modules\Order\Http\Requests\WebService\CreateOrderRequest;
use Modules\Order\Http\Requests\WebService\RateOrderRequest;
use Modules\Order\Jobs\SendOrderToMultipleJob;
use Modules\Order\Traits\OrderTrait;
use Modules\Order\Transformers\WebService\OrderProductResource;
use Modules\Order\Transformers\WebService\OrderResource;
use Modules\Transaction\Services\MyFatoorahPaymentService;
use Modules\Transaction\Services\UPaymentService;
use Modules\User\Entities\User;
use Modules\User\Repositories\WebService\AddressRepository as Address;
use Cart;

class OrderController extends WebServiceController
{
    use OrderTrait;

    protected $payment;
    protected $myFatoorahPayment;
    protected $order;
    protected $company;
    protected $catalog;
    protected $address;

    public function __construct(
        \Modules\Order\Repositories\WebService\OrderRepository $order,
        Product                                              $product,
        Address                                              $address,
        DeliveryCharge                                       $deliveryCharge,
        WorkingTimeRepo                                      $workingTime,
        UPaymentService $payment,
        MyFatoorahPaymentService $myFatoorahPayment,
        Company $company,
        Catalog $catalog
    ) {
        $this->order = $order;
        $this->product = $product;
        $this->address = $address;
        $this->deliveryCharge = $deliveryCharge;
        $this->workingTime = $workingTime;
        $this->payment = $payment;
        $this->myFatoorahPayment = $myFatoorahPayment;
        $this->company = $company;
        $this->catalog = $catalog;
    }

    public function companyDeliveryChargeCondition($data, $userToken, $delivery_time = null,$request)
    {
        $deliveryFees = new CartCondition([
            'name' => 'company_delivery_fees',
            'type' => 'company_delivery_fees',
            'target' => 'total',
            'value' => $data['price'],
            'attributes' => [
                'state_id' => $data['state_id'],
                'address_id' => $data['address_id'],
                'delivery_time_note' => $delivery_time,
                'is_fast_delivery'  => $request->is_fast_delivery,
                'order_type'        => $request->order_type,
                'pickup_working_times_id'   => $request->pickup_working_times_id,
                'delivery_working_times_id'   => $request->delivery_working_times_id,
                'receiving_date'   => $request->receiving_date,
                'delivery_date'   => $request->delivery_date,
                'order_notes'       => $data['order_notes'] ?? '',
            ],
        ]);

        return Cart::session($userToken)->condition([$deliveryFees]);
    }

    public function createOrder(CreateOrderRequest $request)
    {
        if (auth('api')->check()) {
            $userToken = auth('api')->id();
        } else {
            $userToken = $request->user_id;
        }

        foreach (getCartContent($userToken) as $key => $item) {

            if ($item->attributes->product->product_type == 'product') {
                $cartProduct = $item->attributes->product;
                $product = $this->catalog->findOneProduct($cartProduct->id);
                if (!$product) {
                    return $this->error(__('cart::api.cart.product.not_found') . $cartProduct->id, [], 422);
                }

                $product->product_type = 'product';
            }

            $checkPrdFound = $this->productCartFound($product, $item);
            if ($checkPrdFound) {
                return $this->error($checkPrdFound, [], 422);
            }

            // $checkPrdStatus = $this->checkProductActiveStatus($product, $request);
            $checkPrdStatus = $this->checkCartProductStatus($product);
            if ($checkPrdStatus) {
                return $this->error($checkPrdStatus, [], 422);
            }
        }

        $order = $this->order->create($request, $userToken);
        if (!$order) {
            return $this->error('error', [], 422);
        }

        if ($request['payment'] == 'upayment' && getCartTotal($userToken) > 0) {

            $extraData = [];
            $payment = $this->payment->send($order, 'knet', 'api-order', $extraData);
            if (is_null($payment)) {
                return $this->error(__('order::frontend.orders.index.alerts.order_failed'), [], 422);
            } else {
                return $this->response(['paymentUrl' => $payment,'order_id' => $order->id]);
            }

        } elseif ($request['payment'] == 'myfatourah' && getCartTotal($userToken) > 0) {
            $payment = $this->myFatoorahPayment->send($order, "knet", "api-order");
            if ($payment) {
                return $this->response(['paymentUrl' => $payment,'order_id' => $order->id]);
            } else {
                return $this->error(__('order::frontend.orders.index.alerts.order_failed'), [], 422);
            }
        }

        $newOrder = $this->order->findById($order->id);

        $this->fireLog($newOrder);
        $this->clearCart($userToken);

        return $this->response(new OrderResource($newOrder));
    }

    public function webhooks(Request $request)
    {
        $this->order->updateOrder($request);
    }

    public function success(Request $request)
    {
        $order = $this->order->updateOrder($request,'upayment');
        if ($order) {
            $orderDetails = $this->order->findById($request['OrderID']);
            if ($orderDetails) {
                $this->fireLog($orderDetails);
                $this->assignDriverToOrder([
                    'address_id' => $orderDetails->orderAddress->id,
                    'state_id'  => $orderDetails->state_id,
                    'receiving_date' => $orderDetails->orderTimes->receiving_data['receiving_date'],
                    'pickup_working_times_id'   => $orderDetails->orderTimes->receiving_data['time_id'],
                    'delivery_date' => $orderDetails->orderTimes->delivery_data['delivery_date'],
                    'delivery_working_times_id'  => $orderDetails->orderTimes->delivery_data['time_id'],
                ],$orderDetails->id);
                $this->sendNotificationToDrivers($order);
                $this->clearCart($orderDetails->user_id);
                return $this->response(new OrderResource($orderDetails));
            } else {
                return $this->error(__('order::frontend.orders.index.alerts.order_failed'), [], 422);
            }

        }
    }

    public function failed(Request $request)
    {
        $this->order->updateOrder($request,'upayment');
        return $this->error(__('order::frontend.orders.index.alerts.order_failed'), [], 422);
    }

    public function userOrdersList(Request $request)
    {
        $orders = $this->order->getAllByUser(auth('api')->id());
        return $this->response(OrderResource::collection($orders));
    }

    public function getOrderDetails(Request $request, $id)
    {
        $order = $this->order->findById($id);

        if (!$order) {
            return $this->error(__('order::api.orders.validations.order_not_found'), [], 422);
        }

        return $this->response(new OrderResource($order));
    }

    public function clearCart($userToken)
    {
        $cart = Cart::session($userToken);
        $cart->clear();
        $cart->clearCartConditions();

        return true;
    }

    public function fireLog($order)
    {
        $dashboardUrl = LaravelLocalization::localizeUrl(url(route('dashboard.orders.show', [$order->id, 'current_orders'])));
        $data = [
            'id' => $order->id,
            'type' => 'orders',
            'url' => $dashboardUrl,
            'description_en' => 'New Order',
            'description_ar' => 'طلب جديد ',
        ];

        event(new ActivityLog($data));
        $this->sendNotifications($order);
    }

    public function sendNotifications($order)
    {
        $email = optional($order->orderAddress)->email ?? (optional($order->user)->email ?? null);
        if (!is_null($email)) {
            $emails[] = $email;
            dispatch(new SendOrderToMultipleJob($order, $emails, 'user_email'));
        }

        if (config('setting.contact_us.email')) {
            $emails = [];
            $emails[] = config('setting.contact_us.email');
            $adminsEmails = $this->getAllAdminsEmails();
            $emails = array_merge($emails, $adminsEmails);
            dispatch(new SendOrderToMultipleJob($order, $emails, 'admin_email'));
        }
    }

    public function rateOrder(RateOrderRequest $request, $id)
    {
        $order = $this->order->findByIdWithUserId($id);
        if (!$order) {
            return $this->error(__('order::api.orders.validations.order_not_found'), [], 422);
        }

        $ratingOrder = $this->order->checkRatingOrder($id);
        if (!is_null($ratingOrder)) {
            return $this->error(__('order::api.orders.validations.order_rated'), [], 422);
        }

        $rate = $this->order->rateOrder($request, $order->id);
        return $this->response($rate);
    }

    ############## Start: MyFatoorah Functions ############
    public function myfatoorahSuccess(Request $request)
    {
        logger('MyFatoorah::success');
        logger($request->all());
        $response = $this->getMyFatoorahTransactionDetails($request);
        $orderCheck = $this->order->updateMyFatoorahOrder($request, $response['status'], $response['transactionsData'], $response['orderId']);
        $orderDetails = $this->order->findById($response['orderId']);
        if ($orderCheck && $orderDetails) {
            $this->fireLog($orderDetails);
            $userToken = $orderDetails->user_id ?? ($orderDetails->user_token ?? null);
            if ($userToken) {
                $this->clearCart($userToken);
                $this->sendNotificationToDrivers($orderDetails);
            }
            return $this->response(new OrderResource($orderDetails));
        } else {
            return $this->error(__('order::frontend.orders.index.alerts.order_failed'), [], 422);
        }

    }

    public function myfatoorahFailed(Request $request)
    {
        logger('MyFatoorah::failed');
        logger($request->all());
        $response = $this->getMyFatoorahTransactionDetails($request);
        $orderCheck = $this->order->updateMyFatoorahOrder($request, $response['status'], $response['transactionsData'], $response['orderId']);
        return $this->error(__('order::frontend.orders.index.alerts.order_failed'), [], 422);
    }

    private function getMyFatoorahTransactionDetails($request)
    {
        // Get transaction details
        $response = $this->myFatoorahPayment->getTransactionDetails($request->paymentId);
        logger('Get transaction details');
        logger($response);
        $status = strtoupper($response['InvoiceStatus']);
        $orderId = $response['UserDefinedField'];
        $transactionsData = $response['InvoiceTransactions'][0] ?? [];
        return [
            'status' => $status,
            'orderId' => $orderId,
            'transactionsData' => $transactionsData,
        ];
    }
    ############## End: MyFatoorah Functions ############

    private function getAllAdminsEmails()
    {
        return User::whereHas('roles.perms', function ($query) {
            $query->where('name', 'dashboard_access');
        })
            ->pluck('email')
            ->toArray();
    }
}
