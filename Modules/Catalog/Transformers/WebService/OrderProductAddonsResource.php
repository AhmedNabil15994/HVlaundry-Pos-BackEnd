<?php

namespace Modules\Catalog\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductAddonsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->addon->id,
            'option' => $this->addon->getTranslation('title', locale()) ?? '---',
            'price' => number_format($this->price, 3),
            'qty' => $this->qty,
            'image' => !is_null($this->addon->image) ? url($this->addon->image) : null,
            'total' => number_format($this->price * $this->qty ,3)
        ];
    }
}
