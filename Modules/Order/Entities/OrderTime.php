<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderTime extends Model
{
    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

    protected $table = 'order_times';
    protected $guarded = ["id"];
    protected $casts = [
        'receiving_data' => 'json',
        'delivery_data' => 'json',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
