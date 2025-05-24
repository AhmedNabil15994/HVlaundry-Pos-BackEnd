<?php

namespace Modules\Order\Traits;

use Modules\Catalog\Entities\Product;

trait OrderCalculationTrait
{
    public function calculateTheOrder($userToken = null,$is_fast_delivery = false)
    {
        $shipping = $this->getOrderShipping($userToken) ?? 0.000;
        $subtotal = getCartSubTotal($userToken) * ($is_fast_delivery ? 2:1);
        $discount = getCartItemsCouponValue($userToken);
        $total = $subtotal + $shipping - $discount;

        $order = $this->orderProducts($userToken);
        $order['shipping'] = $shipping;
        $order['subtotal'] = $subtotal;
        $order['total'] = $total;
        return $order;
    }

    public function totalOrder($userToken = null)
    {
        return getCartTotal($userToken);
    }

    public function subTotalOrder($userToken = null)
    {
        return getCartSubTotal($userToken);
    }

    public function getOrderShipping($userToken = null)
    {
        return getOrderShipping($userToken);
    }

    public function orderProducts($userToken = null)
    {
        $data = [];
        $subtotal = 0.000;
        $off = 0.000;
        $price = 0.000;
        $profite = 0.000;
        $profitePrice = 0.000;
        $coupon = null;

        if (!is_null(getCartConditionByName($userToken, 'coupon_discount'))) {
            $couponCondition = getCartConditionByName($userToken, 'coupon_discount');
            $coupon['id'] = $couponCondition->getAttributes()['coupon']->id;
            $coupon['code'] = $couponCondition->getAttributes()['coupon']->code;
            $coupon['type'] = $couponCondition->getAttributes()['coupon']->discount_type;
            $coupon['discount_value'] = $couponCondition->getAttributes()['coupon']->discount_value ?? $couponCondition->getValue();
            $coupon['discount_percentage'] = $couponCondition->getAttributes()['coupon']->discount_percentage;
        }

        foreach (getCartContent($userToken) as $k => $value) {
            $productObject = Product::active()->find($value->attributes->product->id);
            $product['product_id'] = $productObject->id;
            $product['product'] = $value->attributes->product;
            $product['original_price'] = $value->price;
            $product['starch'] = $value->starch ?? ($value->attributes->starch ?? null) ;
            $product['notes'] = $value->attributes->notes ??null;

            $product['quantity'] = $value->quantity;
            $product['sale_price'] = $value->price;

            $product['off'] = $product['original_price'] - $product['sale_price'];
            $product['original_total'] = $product['original_price'] * $product['quantity'];
            $product['total'] = $product['sale_price'] * $product['quantity'];
            $product['cost_price'] = $value->price;
            $product['total_cost_price'] = $product['cost_price'] * $product['quantity'];
            $product['total_profit'] = $product['total'] - $product['total_cost_price'];
            $product['qty_details'] = $value->attributes->qty_details;

            $off += $product['off'];
            $price += $product['total'];
            $subtotal += $product['original_total'];
            $profitePrice += $product['total_cost_price'];
            $profite += $product['total_profit'];

            $data[] = $product;
        }

        return [
            'profit' => $profite,
            'off' => $off,
            'coupon' => $coupon,
            'original_subtotal' => $subtotal,
            'products' => $data,
        ];
    }
}
