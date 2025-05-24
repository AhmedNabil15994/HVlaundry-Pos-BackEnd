<?php

namespace Modules\Catalog\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class AddOnsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->getTranslation('title', locale()) ?? '---',
            'image' => !is_null($this->image) ? url($this->image) : null,
            'price' => number_format($this?->pivot?->price ?? $this->price, 3),
            'qty' => $this->pivot->qty ?? ($this->qty ?? 1),
        ];
    }
}
