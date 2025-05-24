<?php

namespace Modules\Coupon\Entities;

use Illuminate\Database\Eloquent\Model;

class RechargeCouponHistory extends Model
{
    public $table = 'recharge_coupons_history';
    protected $fillable = ['recharge_coupon_id','user_id'];
}
