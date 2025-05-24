<?php

namespace Modules\Coupon\Http\Controllers\WebService;

use Carbon\Carbon;
use Cart;
use Darryldecode\Cart\CartCondition;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Apps\Http\Controllers\WebService\WebServiceController;
use Modules\Cart\Traits\CartTrait;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Traits\ShoppingCartTrait;
use Modules\Coupon\Entities\Coupon;
use Modules\Coupon\Entities\RechargeCoupon;
use Modules\Coupon\Entities\RechargeCouponHistory;
use Modules\Coupon\Http\Requests\WebService\CouponRequest;

class CouponController extends WebServiceController
{
    use ShoppingCartTrait;
    /*
     *** Start - Check Api Coupon
     */
    public function checkCoupon(CouponRequest $request)
    {
        $request['user_token'] = auth('api')->id() ?? $request->user_token;
        $cart = $this->getCart($request['user_token']);
        if ($cart->getContent()->count() == 0)
            return $this->error(__('coupon::api.coupons.validation.cart_is_empty'), [], 401);

        $coupon = Coupon::where('code', $request->code)->active()->first();
        if ($coupon) {

            if ($coupon->start_at > Carbon::now()->format('Y-m-d') || $coupon->expired_at < Carbon::now()->format('Y-m-d'))
                return $this->error(__('coupon::api.coupons.validation.code.expired'), [], 401);

            $coupon_users = $coupon->users->pluck('id')->toArray() ?? [];
            if ($coupon_users <> []) {
                if (auth()->check() && !in_array(auth()->id(), $coupon_users))
                    return $this->error(__('coupon::api.coupons.validation.code.custom'), [], 401);
            }

            // Remove Old General Coupon Condition
            $this->removeCartConditionByType('coupon_discount', $request->user_token);

            $cartItems = getCartContent($request->user_token);
            $prdList = $this->getProductsList($coupon, $coupon->flag);
            $prdListIds = array_values(!empty($prdList) ? array_column($prdList->toArray(), 'id') : []);
            $is_fast_delivery = $this->getFastDelivery($request->user_token);

            $conditionValue = $this->addProductCouponCondition($cartItems, $coupon, $request['user_token'], $prdListIds,$is_fast_delivery);
            $subtotal = $this->cartSubTotal($request);
            $delivery_fees = 0;
            $delivery = getCartConditionByName($customer_id ?? config('setting.order_default_customer_id'),'company_delivery_fees');
            if($delivery){
                $delivery_fees = $delivery->getValue();
            }
            $subtotal = getCartSubTotal($customer_id ?? config('setting.order_default_customer_id')) * ($is_fast_delivery ? 2:1);
            $total = $subtotal + $delivery_fees - $conditionValue;

            return $this->response([
                'discount_value' => $conditionValue > 0 ? number_format($conditionValue, 3) : 0,
                'subTotal' => number_format($subtotal, 3),
                'total' => number_format($total, 3),
            ]);
        } else {
            return $this->error(__('coupon::api.coupons.validation.code.not_found'), [], 401);
        }
    }

    protected function getProductsList($coupon, $flag = 'products')
    {
        $coupon_vendors = $coupon->vendors ? $coupon->vendors->pluck('id')->toArray() : [];
        $coupon_products = $coupon->products ? $coupon->products->pluck('id')->toArray() : [];
        $coupon_categories = $coupon->categories ? $coupon->categories->pluck('id')->toArray() : [];

        $products = Product::where('status', true);

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
//                $prdId = $cartKey = $cartItem->id;
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


    public function check_recharge_coupon(Request $request)
    {
        $userId = auth('api')->id() ?? $request->user_token;
        $coupon = RechargeCoupon::where('code', $request->code)->active()->first();
        if ($coupon) {

            if ($coupon->start_at > Carbon::now()->format('Y-m-d') || $coupon->expired_at < Carbon::now()->format('Y-m-d'))
                return $this->error(__('coupon::api.coupons.validation.code.expired'), [], 401);

            $coupon_users = $coupon->users->pluck('id')->toArray() ?? [];
            if ($coupon_users <> []) {
                if (!in_array($userId, $coupon_users))
                    return $this->error(__('coupon::api.coupons.validation.code.custom'), [], 401);
            }

            $count = RechargeCouponHistory::where([
                ['recharge_coupon_id', $coupon->id],
                ['user_id',$userId]
            ])->count();
            if($count >= $coupon->user_max_uses){
                return $this->error(__('coupon::api.coupons.validation.code.not_found'), [], 401);
            }

            auth('api')->user()->increment('subscriptions_balance',$coupon->balance);
            RechargeCouponHistory::create(['user_id'=>$userId,'recharge_coupon_id'=>$coupon->id]);

            return $this->response([
                    'balance_added'   => number_format($coupon->balance,3),
                    'current_balance' => number_format(auth('api')->user()->subscriptions_balance,3),
            ]);
        } else {
            return $this->error(__('coupon::api.coupons.validation.code.not_found'), [], 401);
        }
    }
}
