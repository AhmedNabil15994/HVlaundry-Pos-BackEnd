<?php

namespace Modules\User\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'image' => $this->image ? url($this->image) : url(config('core.config.user_img_path') . '/default.png'),
            'orders_count' => $this->orders_count,
            'subscriptions_balance' => number_format($this->subscriptions_balance ?? 0,3),
            'loyalty_points_count' =>number_format( (($this->loyalty_points_count ?? 0) * 10 / 1000) , 3) ,
            'addresses' => UserAddressResource::collection($this->addresses),
            'last_order_date'   => $this->orders_count ?  date('d-m-Y', strtotime($this->orders()->latest('id')->first()->created_at)) : '',
            'deleted_at' => $this->deleted_at,
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
