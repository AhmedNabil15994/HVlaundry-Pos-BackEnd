<?php

namespace Modules\Order\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Catalog\Transformers\WebService\OrderProductAddonsResource;
use Modules\Catalog\Transformers\WebService\ProductResource;
use Modules\Core\Traits\CoreTrait;

class OrderProductResource extends JsonResource
{
    use CoreTrait;

    public function toArray($request)
    {
        return  [
            'id'    => $this->id,
            'title' => $this->product->title,
            'image' => url($this->product->image),
            'selling_price' => $this->price,
            'total' => $this->order->is_fast_delivery ? number_format($this->total * 2 , 3) : number_format($this->total,3),
            'notes' => $this->notes,
            'addons' =>  count($this->orderProductCustomAddons) ? OrderProductAddonsResource::collection($this->orderProductCustomAddons) : [],
        ];
    }
}
