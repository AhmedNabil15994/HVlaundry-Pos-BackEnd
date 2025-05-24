<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\StarchType;

class OrderProduct extends Model
{
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function order()
    {
        return $this->belongsTo(Order::class)->withTrashed();
    }

    public function starchType()
    {
        return $this->belongsTo(StarchType::class,'starch','id')->withTrashed();
    }

    public function refund()
    {
        return $this->morphOne(OrderRefundItem::class, 'item');
    }

    public function refundOperation($qty, $increment_stock)
    {
        $refund_money = $this->total;
        $currentQty = $qty;
        $refundQty = $this->qty - $qty;
        $newTotal = $currentQty * $this->sale_price;
        $newOriginalTotal = $currentQty * $this->price;

        $refund_money = $refund_money - $newTotal;

        $data = [
            "qty" => $currentQty,
            "is_refund" => $currentQty == 0,
            "total" => $newTotal,
            'original_total' => $newOriginalTotal,
            "total_profit" => $newTotal - $newOriginalTotal,
        ];

        $this->update($data);
        $refund = $this->refund;

        if ($refund) {
            $refund->qty += $refundQty;
            $refund->total += $refund_money;
            $refund->save();
        } else {
            $this->refund()->create([
                "qty" => $refundQty,
                "total" => $refund_money,
            ]);
        }

        if ($increment_stock && $this->product) {

            $this->product()->increment('qty', $refundQty);
        }

        return $refund_money;
    }

    public function orderProductCustomAddons()
    {
        return $this->hasMany(OrderCustomAddon::class, 'order_product_id');
    }
}
