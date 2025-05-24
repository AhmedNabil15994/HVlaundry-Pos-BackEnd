<?php

namespace Modules\Baqat\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $response = [
            'id' => $this->id,
            'title' => $this->title,
            'duration_by_days' => $this->duration_by_days,
            'client_price' => $this->client_price,
        ];

        if ($this->offer) {
            if (!is_null($this->offer->offer_price)) {
                $response['price'] = $this->offer->offer_price;
            } else {
                $response['price'] = number_format(calculateOfferAmountByPercentage($this->price, $this->offer->percentage), 3);
            }
        } else {
            $response['price'] = $this->price;
        }

        return $response;
    }
}
