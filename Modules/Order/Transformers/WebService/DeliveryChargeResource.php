<?php

namespace Modules\Order\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Company\Transformers\Dashboard\CompanyResource;
use Modules\Company\Transformers\WebService\AvailabilitiesResource;

class DeliveryChargeResource extends JsonResource{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'delivery' => $this->delivery,
            'min_order_amount' => $this->min_order_amount,
            'state_id' => $this->state_id,
            'company'   => new CompanyResource($this->company),
        ];
    }
}
