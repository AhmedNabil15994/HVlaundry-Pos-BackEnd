<?php

namespace Modules\Coupon\Entities;

use Illuminate\Database\Eloquent\Model;

class RechargeCouponUser extends Model
{
    protected $fillable = ['recharge_coupon_id','user_id'];
}
