<?php

namespace Modules\User\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Area\Traits\AreaTrait;

class UserResource extends JsonResource
{
    use AreaTrait;

    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'calling_code' => $this->calling_code,
            'mobile' => $this->mobile,
            'image' => url($this->image),
            "is_verified" => $this->is_verified,
            "firebase_uuid" => $this->firebase_uuid,
            "code_verified" => $this->code_verified,
            "whatsapp_number" => $this->whatsapp_number,
            "subscriptions_balance" => $this->subscriptions_balance,
            "loyalty_points_count" => $this->loyalty_points_count,
            "loyalty_balance" => $this->loyalty_points_count / 1000,
            "maximum_received_orders_count" => $this->maximum_received_orders_count,
            "maximum_delivery_orders_count" => $this->maximum_delivery_orders_count,
        ];

        if (!is_null($this->country)) {
            $result['country'] = $this->getCountryInfoByCode($this->country);
        } else {
            $result['country'] = null;
        }

        return $result;
    }
}
