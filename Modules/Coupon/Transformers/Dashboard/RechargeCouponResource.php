<?php

namespace Modules\Coupon\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class RechargeCouponResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'balance' => $this->balance,
            'code' => $this->code,
            'status' => $this->status,
            'orders_count' => $this->orders_count,
            'expired_at' => $this->expired_at,
            'deleted_at' => $this->deleted_at,
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
