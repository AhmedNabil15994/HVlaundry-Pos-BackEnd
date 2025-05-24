<?php

namespace Modules\Pos\Http\Controllers\Dashboard;

use Carbon\Carbon;
use Darryldecode\Cart\CartCondition;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Apps\Repositories\Dashboard\WorkingTimeRepository as WorkingTimeRepo;
use Modules\Authorization\Repositories\Dashboard\RoleRepository as Role;
use Modules\Baqat\Repositories\Dashboard\BaqatSubscriptionRepository;
use Modules\Catalog\Entities\ProductCustomAddon;
use Modules\Catalog\Http\Requests\FrontEnd\CartRequest;
use Modules\Pos\Repositories\Dashboard\CategoryRepository as CategoryRepo;
use Modules\Catalog\Repositories\Dashboard\CustomAddonRepository;
use Modules\Catalog\Repositories\Dashboard\ProductRepository as Product;
use Modules\Catalog\Traits\ShoppingCartTrait;
use Modules\Company\Repositories\Dashboard\DeliveryChargeRepository as DeliveryCharge;
use Modules\Core\Traits\DataTable;
use Modules\Coupon\Entities\Coupon;
use Modules\Notification\Repositories\Dashboard\NotificationRepository as Notification;
use Modules\Notification\Traits\SendNotificationTrait as SendNotification;
use Modules\Order\Constant\OrderStatus as ConstantOrderStatus;
use Modules\Order\Entities\OrderCoupon;
use Modules\Order\Entities\PaymentStatus;
use Modules\Order\Events\ActivityLog;
use Modules\Pos\Repositories\Dashboard\OrderRepository as Order;
use Modules\Order\Repositories\Dashboard\OrderStatusRepository as OrderStatus;
use Modules\Order\Traits\OrderTrait;
use Modules\Order\Transformers\Dashboard\OrderResource;
use Modules\Page\Entities\Page;
use Modules\Transaction\Services\UPaymentService;
use Modules\User\Entities\LoyaltyPointBalanceLog;
use Modules\User\Entities\SubscriptionBalanceLog;
use Modules\User\Repositories\Dashboard\AddressRepository as Address;
use Modules\User\Repositories\Dashboard\AddressRepository as AddressRepo;
use Modules\User\Repositories\Dashboard\DriverRepository;
use Modules\User\Repositories\Dashboard\UserRepository as User;
use Modules\User\Repositories\Dashboard\UserRepository as UserRepo;
use Modules\User\Transformers\Dashboard\UserResource;
use Cart;


class OrderController extends Controller
{

    use SendNotification, OrderTrait;
    use ShoppingCartTrait;

    protected $order;
    protected $status;
    protected $notification;
    protected $product;
    protected $address;
    protected $deliveryCharge;
    protected $user;
    protected $category;
    protected $payment;
    protected $workingTime;

    public function __construct(
        Order $order,
        OrderStatus $status,
        Notification $notification,
        Product $product,
        Address $address,
        DeliveryCharge $deliveryCharge,
        UserRepo $user,
        CategoryRepo $category,
        BaqatSubscriptionRepository $baqatSubscription,
        UPaymentService $payment,
        WorkingTimeRepo $workingTime,
        CustomAddonRepository $customRepo,
        DriverRepository $driver
    ) {
        $this->status = $status;
        $this->order = $order;
        $this->notification = $notification;
        $this->product = $product;
        $this->baqatSubscription = $baqatSubscription;
        $this->address = $address;
        $this->deliveryCharge = $deliveryCharge;
        $this->user = $user;
        $this->category = $category;
        $this->workingTime = $workingTime;
        $this->payment = $payment;
        $this->customRepo = $customRepo;
        $this->driver = $driver;
    }

    public function index()
    {
        $statuses = $this->status->getAll();
        $paymentStatuses = PaymentStatus::orderBy('id','asc')->get();
        $drivers = $this->driver->getAllDrivers();
        return view('pos::dashboard.orders.index',compact('statuses','paymentStatuses','drivers'));
    }

    public function datatable(Request $request)
    {
        return $this->basicDatatable($request,['new_order', 'received', 'processing', 'is_ready', 'on_the_way']);
    }

    public function allOrdersDatatable(Request $request)
    {
        return $this->basicDatatable($request);
    }
    private function basicDatatable($request, $flags = [])
    {
        $datatable = DataTable::drawTable($request, $this->order->customQueryTable($request, $flags), 'orders');
        $datatable['data'] = OrderResource::collection($datatable['data']);
        return Response()->json($datatable);
    }

    public function show($id)
    {
        $order = $this->order->findById($id);
        if (!$order /*|| ($flag != $order->order_flag && $flag != 'all_orders')*/) {
            abort(404);
        }

        $statuses = $this->status->getAll()->whereNotIn('flag', ConstantOrderStatus::BLOCK_CHANGE_STATUS_FLAGS);
        $orderProducts = $order->orderCustomAddons->groupBy('addon_id');
        $termsPage = Page::find(2);

        return view('pos::dashboard.orders.invoice', compact('order','statuses','orderProducts','termsPage'));
    }

    public function refreshCart($userToken,$refresh = false)
    {
        $data = [];
        $userToken = $userToken ? $userToken :  config('setting.order_default_customer_id');
        $items = getCartContent($userToken, true);
        $condition = Cart::session($userToken)->getCondition('company_delivery_fees') ?? null;
        $is_fast_delivery = 0;
        if($condition){
            $attrs =  $condition->getAttributes();
            $is_fast_delivery = isset($attrs['is_fast_delivery']) ? (int)$attrs['is_fast_delivery'] : 0;
        }

        $data=  [
            'items' => $items,
            'is_fast_delivery' => $is_fast_delivery,
        ];

        if($refresh){
            $customer_id = $userToken;
            $data['cartItems'] = view('pos::dashboard.orders.partials.cartItems',compact('items'))->render();
            $data['cartTotals'] = view('pos::dashboard.orders.partials.cartTotals',compact('customer_id','is_fast_delivery'))->render();
        }

        return $data;
    }
    public function create(Request $request)
    {
        $request->merge(['with_addons' => 1]);
        $categories = $this->category->getAllActive('sort','asc');
        $products = $this->product->QueryTable($request)->get();
        $refresh = $this->refreshCart(null,false);
        $statuses = $this->status->getAll('sort','asc');
        $paymentStatuses = PaymentStatus::orderBy('id','asc')->get();
        $items = $refresh['items'];
        $is_fast_delivery = $refresh['is_fast_delivery'];
        return view('pos::dashboard.orders.create',compact('categories','products','items','is_fast_delivery','statuses','paymentStatuses'));
    }

    public function searchProducts(Request $request)
    {
        $request->merge(['with_addons' => 1]);
        $products = $this->product->QueryTable($request)->get();
        return response()->json(["message" => '', "data" => [
            'productsHtml' => view('pos::dashboard.orders.partials.products',compact('products'))->render(),
        ]], 200);
    }
    public function subscription($id)
    {
        $subscription = $this->baqatSubscription->findById($id, ['baqa', 'user']);
        if (!$subscription) {
            return Response()->json([false, __('apps::dashboard.general.not_found')]);
        }

        return view('pos::dashboard.orders.subscription',compact('subscription'));
    }

    public function getProductAddons(Request $request)
    {
        $addons = $this->product->findById($request->product_id);

        return response()->json([
            'has_starch'    => $addons->has_starch,
            'addons'    => $addons->customAddons,
            'addons_id' => $addons->customAddons()->pluck('custom_addons.id')->toArray(),
        ]);
    }

    public function addToCart(CartRequest $request)
    {
        $data = [];
        $userToken = $request->customer_id ?? config('setting.order_default_customer_id');
        $request['customer_id'] = $userToken;
        $id = $request->product_id;
        $is_fast_delivery = $this->getFastDelivery($userToken);

        $product = $this->product->findById($id);
        if (!$product) {
            return response()->json(["errors" => __('cart::api.cart.product.not_found')], 422);
        }

        $product->product_type = 'product';
        $data['productDetailsRoute'] = route('frontend.products.index', [$product->slug]);
        $data['productTitle'] = $product->title;
        $productCartId = $product->id;

        $checkProduct = is_null(getCartItemById($productCartId));
        $allQty = $this->getTotalOfQtyAndPrices($product, [
            [
                'qty' => $request->qty,
                'addon_id'  => $request->addon_id,
            ]
        ], $is_fast_delivery,$userToken);

        if (gettype($allQty) == 'string') {
            return response()->json(["errors" => $allQty], 422);
        }

        if (!isset($allQty['qty_details'])) {
            $cartItem = Cart::session($userToken)->remove($productCartId);
            $data["total"] = number_format(getCartTotal($userToken), 3);
            $data["subTotal"] = number_format(getCartSubTotal($userToken), 3);
            $data["cartCount"] = count(getCartContent(null, true));
            return response()->json(["message" => __('catalog::frontend.cart.deleted_successfully'), "data" => $data], 200);
        }

        $request->request->add(['all_qty' => $allQty]);
        $request->request->remove('qty');
        $errors = $this->addOrUpdateCart($product, $request);
        if ($errors) {
            return response()->json(["errors" => $errors], 422);
        }

        $couponDiscount = Cart::session($userToken)->getCondition('coupon_discount');
        if (!is_null($couponDiscount)) {
            $couponCode = $couponDiscount->getAttributes()['coupon']->code ?? null;
            $request['code'] = $couponCode;
            $this->applyCoupon($request);
        }

        $data["total"] = number_format(getCartTotal($userToken), 3);
        $data["subTotal"] = number_format(getCartSubTotal($userToken), 3);
        $data["cartCount"] = count(getCartContent($userToken, true));

        $refresh = $this->refreshCart($userToken,true);
        $data['cartItems'] = $refresh['cartItems'];
        $data['cartTotals'] = $refresh['cartTotals'];

        if ($checkProduct) {
            return response()->json(["message" => __('catalog::frontend.cart.add_successfully'), "data" => $data], 200);
        } else {
            return response()->json(["message" => __('catalog::frontend.cart.updated_successfully'), "data" => $data], 200);
        }
    }

    private function getTotalOfQtyAndPrices($product, $qty, $isFastDelivery,$userToken=null)
    {
        $productId = $product->id;
        $item = $this->findItemById($product->product_type == 'product' ? $product->id : 'var-' . $product->id,$userToken);
        $oldQty = [];
        if($item && $userToken){
            $oldQty = $item->attributes->qty_details;

            $found = 0;
            foreach ($oldQty as $key => $addon){{
                if($qty[0]['addon_id'] == $addon['addon_id']){
                    $oldQty[$key]['qty'] = $qty[0]['qty'];
                    $qty = $oldQty;
                    $found=1;
                }
            }}
            if(!$found){
                $qty = array_values(array_merge($qty,$oldQty));
            }
        }

        $result = [];
        $totalQty = 0;
        $totalPrice = 0;
        foreach ($qty as $key => $value) {
            $requestQty = intval($value['qty']);

            if ($requestQty > 0) {
                $totalQty += $requestQty;
                $addonObject = ProductCustomAddon::with('addon')
                    ->whereHas('addon', function ($query) {
                        $query->active();
                    })
                    ->where('product_id', $productId)
                    ->where('custom_addon_id', $value['addon_id'])
                    ->first();

                if (is_null($addonObject)) {
                    return __('Addon is not found currently!');
                }

                if (!is_null($addonObject->qty) && $requestQty > $addonObject->qty) {
                    return __('The required quantity is greater than the current quantity of the addition!');
                }

                $addonPrice = floatval($addonObject->price);
//                if ($isFastDelivery == true) {
//                    $addonPrice = 2 * $addonPrice;
//                }

                $totalPrice += intval($value['qty']) * $addonPrice;
                $result['models'][$key] = $addonObject;
                $result['qty_details'][$key] = [
                    'qty' => $requestQty,
                    'price' => $addonPrice,
                    'addon_id' => $value['addon_id'],
                ];
            }
        }
        $result['total_qty'] = $totalQty;
        $result['total_price'] = $totalPrice;
        return $result;
    }

    public function deleteItemFromCart(Request $request)
    {
        $customer_id = $request->customer_id ?? config('setting.order_default_customer_id');
        if ($request->product_type == 'product') {
            $deleted = $this->deleteProductFromCart($request->product_id,$customer_id);
        } else {
            $deleted = $this->deleteProductFromCart('var-' . $request->product_id,$customer_id);
        }

        if ($deleted) {
            $couponDiscount = Cart::session($customer_id)->getCondition('coupon_discount');
            if (!is_null($couponDiscount)) {
                $couponCode = $couponDiscount->getAttributes()['coupon']->code ?? null;
                $request['code'] = $couponCode;
                $this->applyCoupon($request);
            }

            $refresh = $this->refreshCart($customer_id,true);
            $data['cartItems'] = $refresh['cartItems'];
            $data['cartTotals'] = $refresh['cartTotals'];

            return response()->json(["message" => __('catalog::frontend.cart.delete_item'), "data" => $data], 200);
        }

        return response()->json(["errors" => __('catalog::frontend.cart.error_in_cart')], 422);
    }

    public function clear(Request $request)
    {
        $customer_id = $request->customer_id ?? config('setting.order_default_customer_id');
        $cleared = $this->clearCart($customer_id);
        $refresh = $this->refreshCart($customer_id,true);
        $data['cartItems'] = $refresh['cartItems'];
        $data['cartTotals'] = $refresh['cartTotals'];

        if ($cleared) {
            return response()->json(["message" => __('catalog::frontend.cart.clear_cart'), "data" => $data], 200);
        }

        return response()->json(["errors" => __('catalog::frontend.cart.error_in_cart')], 422);
    }

    public function applyCoupon(Request $request)
    {
        $customer_id = $request->customer_id ?? config('setting.order_default_customer_id');
        if($customer_id){
            $userToken = $customer_id;
        }else{
            if (auth()->check()) {
                $userToken = auth()->id() ?? null;
            } else {
                $userToken = get_cookie_value(config('core.config.constants.CART_KEY')) ?? null;
            }
        }

        if (is_null($userToken)) {
            return response()->json(["errors" => __('apps::frontend.general.user_token_not_found')], 422);
        }

        // Store Coupon Here
        if($request->code){
            $code = $request->code;
        }else{
            $code  = $this->createCoupon($request);
        }

        $coupon = Coupon::where('code', $code)->active()->first();
        if ($coupon) {
            if (!is_null($coupon->start_at) && !is_null($coupon->expired_at)) {
                if ($coupon->start_at > Carbon::now()->format('Y-m-d') || $coupon->expired_at < Carbon::now()->format('Y-m-d')) {
                    return response()->json(["errors" => __('coupon::frontend.coupons.validation.code.expired')], 422);
                }
            }

            if (auth()->guest() && !in_array('guest', $coupon->user_type ?? [])) {
                return response()->json(["errors" => __('coupon::frontend.coupons.validation.code.custom')], 422);
            }

            if (auth()->check() && !in_array('user', $coupon->user_type ?? [])) {
                return response()->json(["errors" => __('coupon::frontend.coupons.validation.code.custom')], 422);
            }

            $coupon_users = $coupon->users->pluck('id')->toArray() ?? [];
            if ($coupon_users != []) {
                if (auth()->check() && !in_array(auth()->id(), $coupon_users)) {
                    return response()->json(["errors" => __('coupon::frontend.coupons.validation.code.custom')], 422);
                }
            }

            if (auth()->check()) {
                $userCouponsCount = OrderCoupon::where('coupon_id', $coupon->id)
                    ->whereHas('order', function ($q) use ($userToken) {
                        $q->where('user_id', $userToken);
                        $q->whereHas('paymentStatus', function ($q) {
                            $q->whereIn('flag', ['success', 'cash', 'subscriptions_balance', 'loyalty_points']);
                        });
                    })->count();

                if (!is_null($coupon->user_max_uses) && $userCouponsCount > intval($coupon->user_max_uses)) {
                    return response()->json(["errors" => __('coupon::frontend.coupons.validation.user_max_uses')], 422);
                }
            }

            // Remove Old General Coupon Condition
            $this->removeCartConditionByType('coupon_discount', $userToken);
            $cartItems = getCartContent($userToken);
            $prdList = $this->getProductsList($coupon, $coupon->flag);
            $prdListIds = array_values(!empty($prdList) ? array_column($prdList->toArray(), 'id') : []);
            $is_fast_delivery = $this->getFastDelivery($userToken);
            $request['user_token'] = $userToken;
            $conditionValue = $this->addProductCouponCondition($cartItems, $coupon, $userToken, $prdListIds,$is_fast_delivery);

            $data = [
                "coupon_value" => $conditionValue > 0 ? number_format($conditionValue, 3) : 0,
                'subTotal' => number_format($this->cartSubTotal($request) , 2),
                'total' => number_format($this->cartTotal($request), 2),
            ];

            $refresh = $this->refreshCart($userToken,true);
            $data['cartTotals'] = $refresh['cartTotals'];

            return response()->json(["message" => __('coupon::frontend.coupons.checked_successfully'), "data" => $data], 200);
        } else {
            return response()->json(["errors" => __('coupon::frontend.coupons.validation.code.not_found')], 422);
        }
    }

    public function removeCoupon(Request $request)
    {
        $request['user_token'] = auth('api')->id() ?? $request->customer_id;
        $this->removeConditionByName('coupon_discount', $request['user_token']);
        $refresh = $this->refreshCart( $request['user_token'],true);
        $data['cartTotals'] = $refresh['cartTotals'];
        return response()->json(["message" => __('coupon::frontend.coupons.removed_successfully'), "data" => $data], 200);
    }

    protected function getProductsList($coupon, $flag = 'products')
    {
        $coupon_vendors = $coupon->vendors ? $coupon->vendors->pluck('id')->toArray() : [];
        $coupon_products = $coupon->products ? $coupon->products->pluck('id')->toArray() : [];
        $coupon_categories = $coupon->categories ? $coupon->categories->pluck('id')->toArray() : [];

        $products = \Modules\Catalog\Entities\Product::where('status', true);

        if ($flag == 'products') {
            $products = $products->whereIn('id', $coupon_products);
        }

        if ($flag == 'vendors') {
            $products = $products->whereHas('vendor', function ($query) use ($coupon_vendors, $flag) {
                $query->whereIn('id', $coupon_vendors);
                $query->active();
                $query->whereHas('subbscription', function ($q) {
                    $q->active()->unexpired()->started();
                });
            });
        }

        if ($flag == 'categories') {
            $products = $products->whereHas('categories', function ($query) use ($coupon_categories) {
                $query->active();
                $query->whereIn('product_categories.category_id', $coupon_categories);
            });
        }

        return $products->get(['id']);
    }

    private function addProductCouponCondition($cartItems, $coupon, $userToken, $prdListIds = [],$is_fast_delivery=0)
    {
        $totalValue = 0;
        $discount_value = 0;
        $selectedProdId = [];

        foreach ($cartItems as $cartItem) {
            $cartKey = $cartItem->id;
            if ($cartItem->attributes->product->product_type == 'product') {
                $prdId = $cartItem->attributes->product->id;
            } else {
                $prdId = $cartItem->attributes->product->product->id;
            }
            // Remove Old Condition On Product
            Cart::session($userToken)->removeItemCondition($prdId, 'product_coupon');

            if (count($prdListIds) > 0 && in_array($prdId, $prdListIds)) {

                if ($coupon->discount_type == "value") {
                    $discount_value = $coupon->discount_value;
                    if(!in_array($prdId,$selectedProdId)){
                        $selectedProdId[] = $prdId;
                        $totalValue += intval($cartItem->quantity) * $discount_value;
                    }
                } elseif ($coupon->discount_type == "percentage") {
                    $discount_value = (floatval($cartItem->price) * $coupon->discount_percentage) / 100;
                    $totalValue += ($discount_value * intval($cartItem->quantity)) * ($is_fast_delivery ? 2 : 1);
                }
                $prdCoupon = new CartCondition(array(
                    'name' => 'product_coupon',
                    'type' => 'product_coupon',
                    'value' => number_format($discount_value * -1, 3),
                ));
                addItemCondition($prdId, $prdCoupon, $userToken);
                $this->saveEmptyDiscountCouponCondition($coupon, $userToken); // to use it to check coupon in order
            }
        }
        $this->discountCouponCondition($coupon, $totalValue, $userToken);

        // check free delivery in coupon
        if ($coupon->free_delivery == 1) {
            $deliveryCondition = $this->getConditionByName('company_delivery_fees');
            if (!is_null($deliveryCondition)) {
                $this->addFreeDeliveryChargeCondition($userToken, $deliveryCondition);
            }
        }

        return $totalValue;
    }

    public function store(Request  $request)
    {
        $userToken = $request->customer_id ?? config('setting.order_default_customer_id');
        $request->request->add(json_decode(get_cookie_value('DIRECT_ORDER_COOKIE_' . $userToken), true) ?? []);

        $v = Validator::make($request->all(), $rules = [
//            'address_id' => 'required|exists:addresses,id',
            'pickup_date' => 'required_if:has_pick_up,==,1',
            'pickup_working_times_id'   => 'required_if:has_pick_up,==,1',
            'delivery_date'       => 'required_if:has_delivery,==,1',
            'delivery_working_times_id' => 'required_if:has_delivery,==,1',
        ],['address_id.*'=>'Invalid Address Info , please select customer']);

        if ($v->fails()) {
            return response()->json(["errors" => $v->errors()], 422);
        }

        if (getCartContent($userToken)->count() == 0) {
            return response()->json(["errors" => [[__('Choose items firstly!')]]], 422);
        }

        if (!is_null($request->pickup_date)) {
            if ($request->pickup_date < date('Y-m-d')) {
                return response()->json(["errors" => [[__('Pick-up day is not available, choose another day')]]], 422);
            }
        }

        if (!is_null($request->delivery_date)) {
            if ($request->delivery_date < date('Y-m-d')) {
                return response()->json(["errors" => [[__('Delivery day is not available, choose another day')]]], 422);
            }
        }

        $pickUpDetails = $this->workingTime->getPickUpDayDetails($request->pickup_working_times_id);
        $deliveryDetails = $this->workingTime->getDeliveryDayDetails($request->delivery_working_times_id);

        if($request->has_pick_up){
            $request->request->add(['receiving_time' => $pickUpDetails->pickupWorkingTimes[0]->from.'-'.$pickUpDetails->pickupWorkingTimes[0]->to,]);
        }

        if($request->has_delivery){
            $request->request->add(['delivery_time' => $deliveryDetails->deliveryWorkingTimes[0]->from . '-'.$deliveryDetails->deliveryWorkingTimes[0]->to]);
        }

        $cartTotal = getCartTotal($userToken);
        if ($cartTotal && in_array($request->payment_type ,['loyalty_points','subscriptions_balance'])){
            if($request->payment_type == 'loyalty_points' && $cartTotal > (($user->loyalty_points_count ?? 0) * 10 / 1000)){
                return response()->json(["errors" => [[__('Sorry Loyalty Points are less than order total !')]]], 422);
            }
            if($request->payment_type == 'subscriptions_balance' && $cartTotal > ($user->subscriptions_balance ?? 0) ){
                return response()->json(["errors" => [[__('Sorry Subscriptions Balance is less than order total !')]]], 422);
            }
        }

        foreach (getCartContent($userToken) as $key => $item) {
            $cartProduct = $item->attributes->product;
            $product = $this->product->findById($cartProduct->id);
            if (!$product) {
                return response()->json(["errors" => [[__('cart::api.cart.product.not_found') . $cartProduct->id]]], 422);
            }

            // check addons validation
            $allQtyCheck = $this->checkAddonsValidation($product->id, $item->attributes['qty_details']);
            if (gettype($allQtyCheck) == 'string') {
                return response()->json(["errors" => [[$allQtyCheck]]], 422);
            }
        }

        $order = $this->order->createPosOrder($request);
        if (!$order) {
            return response()->json(["errors" => [[__('order::frontend.orders.index.alerts.order_failed')]]], 422);
        }

        if($request->address_id && $request->has_pick_up && $request->has_delivery){
            $this->assignDriverToOrder($request->all(),$order->id);
        }

        if(env('APP_ENV') != 'local'){
            $this->fireLog($order);
            $this->sendNotificationToDrivers($order);
        }

        $this->clearCart($userToken);
        $url = $this->payOrder($request,$order);

        if($request->message_customer && $url){
            $this->messageCustomer($url,$order);
        }

        return response()->json(["message" => __('Order has been created successfully!')], 200);
    }

    public function payOrder(Request $request, $order)
    {
        $userId = $order->user_id;
        $url = '';
        if ($order->payment_status_id == 3) {
            $order->transactions()->delete();
        }

        if (in_array($request->payment_type, ['knet', 'cc'])) {
            $paymentUrl = $this->payment->send($order, $request->payment_type, 'pay-order');
            if (!is_null($paymentUrl)) {
                $order->update([
                    'payment_status_id' => 1, // pending
                ]);

                $order->transactions()->create([
                    'method' => $request->payment_type,
                    'result' => null,
                ]);

                $url = $paymentUrl;
            }
        } elseif ($request->payment_type == 'cash') {
            $order->update([
                'payment_status_id' => 4, // cash
            ]);
            if($request->payment_status_id == 2){
                $order->update([
                    'payment_confirmed_at' => date('Y-m-d H:i:s'),
                ]);
            }
            $order->transactions()->create([
                'method' => 'cash',
                'result' => null,
            ]);
        } elseif ($request->payment_type == 'subscriptions_balance') {

            $checkSubscriptionBalanceCondition = $this->checkSubscriptionBalanceCondition($userId);
            if ($checkSubscriptionBalanceCondition == true && floatval($order->user->subscriptions_balance) >= floatval($order->total)) {

                DB::beginTransaction();
                try {
                    $order->update([
                        'payment_status_id' => 5, // subscriptions_balance
                        'payment_confirmed_at' => date('Y-m-d H:i:s'),
                    ]);
                    $order->transactions()->create([
                        'method' => 'subscriptions_balance',
                        'result' => null,
                    ]);
                    $this->decrementUserSubscriptionsBalance($userId, $order->total);
                    // add user subscriptions balance logs
                    $amountBefore = floatval($order->user->subscriptions_balance);
                    $amountAfter = $amountBefore - floatval($order->total);
                    SubscriptionBalanceLog::create([
                        'user_id' => $userId,
                        'order_id' => $order->id,
                        'amount_before' => $amountBefore,
                        'amount' => $order->total,
                        'amount_after' => $amountAfter,
                    ]);

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                    throw $e;
                }
            }
        } elseif ($request->payment_type == 'loyalty_points') {
            $userLoyaltyPoints = $order->user->loyalty_points_count;
            $useDinarCount = calculateUserFilsFromPointsCount($userLoyaltyPoints) / 1000;
            if (floatval($order->total) <= $useDinarCount) {
                $order->update([
                    'payment_status_id' => 6, // loyalty_points
                    'payment_confirmed_at' => date('Y-m-d H:i:s'),
                ]);
                $order->transactions()->create([
                    'method' => 'loyalty_points',
                    'result' => null,
                ]);

                $remainingUserPointsCount = calculateUserPointsCount(floatval($order->total));
                $userPointsCount = $userLoyaltyPoints - $remainingUserPointsCount;
                $order->user->decrement('loyalty_points_count', $userPointsCount);

                LoyaltyPointBalanceLog::create([
                    'user_id' => $userId,
                    'order_id' => $order->id,
                    'points_count_before' => $userLoyaltyPoints,
                    'points_count' => $userPointsCount,
                    'points_count_after' => $remainingUserPointsCount,
                ]);
            }
        }

        if (in_array($request->payment_type, ['knet', 'cc', 'subscriptions_balance'])) {
            $userPointsCount = calculateUserPointsCount($order->total);
            $order->user->increment('loyalty_points_count', $userPointsCount);
        }

        return $url;
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
    }

    public function messageCustomer($url,$order)
    {
        // generate payment link
        // send link to customer whatsapp
        $mobile = validatePhone($order->user->mobile);
        $mobile =  strlen($mobile) == 8 ? '965'.$mobile : $mobile;

        if($url && env('ENABLE_WHATSAPP')){
            \Message::sendLink([
                'phone' => $mobile,
                'url'  => $url,
                'title' => 'Order #'.$order->id.' Payment Link',
                'body' => 'Order #'.$order->id.' Payment Link with total amount : ' .number_format($order->total,3) . 'KD',
            ]);
        }

        logger($order->id);
    }

    private function checkAddonsValidation($productId, $qty)
    {
        foreach ($qty as $key => $value) {
            $requestQty = intval($value['qty']);
            $addonObject = ProductCustomAddon::with('addon')
                ->whereHas('addon', function ($query) {
                    $query->active();
                })
                ->where('product_id', $productId)
                ->where('custom_addon_id', $value['addon_id'])
                ->first();

            if (is_null($addonObject)) {
                return __('Addon is not found currently!');
            }

            if (!is_null($addonObject->qty) && $requestQty > $addonObject->qty) {
                return __('The required quantity is greater than the current quantity of the addition!');
            }
        }

        return null;
    }

    public function createCoupon($request)
    {
        $data = [
            'code' =>  str_random(5),
            'discount_type' => $request->discount_type ?? 'percentage',
            'start_at' => date('Y-m-d'),
            'expired_at' => date('Y-m-d'),
            'custom_type' => 'pos discount',
            'status' => 1,
            "title" => 'pos discount',
            "user_type" =>  ['user'],
            'free_delivery' =>  0,
            'user_max_uses' => 1,
            'discount_value'    => null,
            'discount_percentage'   => null,
            'max_discount_percentage_value' => null
        ];

        if ($request->discount_type == 'value') {
            $data['discount_percentage'] = null;
            $data['discount_value'] = $request->discount_value;
        } elseif ($request->discount_type == 'percentage') {
            $data['discount_percentage'] = $request->discount_percentage;
            $data['discount_value'] = null;
        }

        Coupon::create($data);
        return $data['code'];
    }
}
