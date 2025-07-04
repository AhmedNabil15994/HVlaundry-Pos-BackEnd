<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Modules\Area\Entities\State;
use Modules\Baqat\Entities\BaqatSubscription;
use Modules\Catalog\Entities\Product;
use Modules\Core\Traits\ScopesTrait;
use Modules\Notification\Entities\GeneralNotification;
use Modules\Occasion\Entities\Occasion;
use Modules\Order\Entities\DriverOrderStatus;
use Modules\Order\Entities\Order;
use Modules\Vendor\Entities\Vendor;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    // protected $with   = ['roles'];

    use Notifiable, ScopesTrait, HasApiTokens;
    use EntrustUserTrait {
        EntrustUserTrait::restore as private restoreA;
    }
    use SoftDeletes {
        EntrustUserTrait::restore as private restoreB;
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        "setting" => "array",
        "is_verified" => "boolean",
    ];

    public function getImageAttribute($value)
    {
        return is_null($value) ? '/uploads/users/user.png' : $value;
    }

    public function restore()
    {
        $this->restoreA();
        $this->restoreB();
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id');
    }

    public function default_address()
    {
        return $this->hasMany(Address::class, 'user_id')->where('is_default', 1);
    }

    public function driverOrders()
    {
        return $this->hasMany(\Modules\Order\Entities\OrderDriver::class);
    }

    public function driverOrderStatuses()
    {
        return $this->hasMany(DriverOrderStatus::class, 'user_id');
    }

    public function driverDeliveredOrderStatuses()
    {
        return $this->hasMany(DriverOrderStatus::class, 'user_id')->where('order_status_id', 5); // delivered
    }

    public function orders()
    {
        return $this->hasMany(\Modules\Order\Entities\Order::class);
    }

    public function country()
    {
        return $this->belongsTo(\Modules\Area\Entities\Country::class);
    }

    public function company()
    {
        return $this->belongsTo(\Modules\Company\Entities\Company::class, 'company_id');
    }

    public function occasions()
    {
        return $this->hasMany(Occasion::class, 'user_id');
    }

    public function favourites()
    {
        return $this->belongsToMany(Product::class, 'users_favourites');
    }

    public function generalNotifications()
    {
        return $this->hasMany(GeneralNotification::class, 'user_id');
    }

    public function mobileCodes()
    {
        return $this->hasMany(UserMobileCode::class, 'user_id');
    }

    public function preferredLocale()
    {
        return $this->setting["lang"] ?? locale();
    }

    public function getPhone()
    {
        return $this->calling_code . $this->mobile;
    }

    /* public function setCountryCodeAttribute($value)
    {
    $this->attributes['country_code'] = $value;
    $this->attributes['dial_code'] = app('countries')->formattedDialCode($value);
    }*/

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'vendor_drivers')->withTimestamps();
    }

    public function sellerVendors()
    {
        return $this->belongsToMany(Vendor::class, 'vendor_sellers', 'vendor_id', 'seller_id')->withTimestamps();
    }

    public function baqatSubscriptions()
    {
        return $this->hasMany(BaqatSubscription::class, 'user_id');
    }

    public function activeBaqatSubscription()
    {
        return $this->hasOne(BaqatSubscription::class, 'user_id')->unexpired()->successSubscriptions()->first();
    }

    public function subscriptionBalanceLogs()
    {
        return $this->hasMany(SubscriptionBalanceLog::class, 'user_id');
    }

    public function unPaidOrders()
    {
        return $this->hasMany(Order::class, 'user_id')
            ->directWithPieces()
            ->where(function ($query) {
                $query->whereNull('payment_status_id');
                $query->orWhereHas('paymentStatus', function ($query) {
                    $query->where('flag', 'pending');
                    $query->orWhere(function ($query) {
                        $query->whereIn('flag', ['success', 'cash', 'subscriptions_balance', 'loyalty_points']);
                        $query->whereNull('orders.payment_confirmed_at');
                    });
                });
            });
    }

    public function successOrders()
    {
        return $this->hasMany(Order::class, 'user_id')
            ->where(function ($query) {
                $query->whereHas('orderStatus', function ($q) {
                    $q->where('is_success', 1);
                });
            });
    }
    public function driverStates()
    {
        return $this->belongsToMany(State::class, 'driver_state')->withTimestamps();
    }
}
