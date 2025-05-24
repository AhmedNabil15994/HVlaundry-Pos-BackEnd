<?php

namespace Modules\Cart\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\StarchType;
use Modules\Catalog\Transformers\WebService\ProductOptionResource;
use Modules\Catalog\Transformers\WebService\ProductVariantResource;
use Modules\Variation\Entities\ProductVariant;

class CartResource extends JsonResource
{
    public function toArray($request)
    {
        $result = [
            'id' => (string)$this->id,
            'title' => $this->attributes->product->title,
            'image' => url($this->attributes->product->image),
            'product_type' => $this->attributes->product->product_type,
            'notes' => $this->attributes->notes,
            'starch' => $this->attributes->starch ? StarchType::find($this->attributes->starch)->title : '',
        ];

        if ($this->attributes->qty_details) {
            $qty = $this->attributes->qty_details[0]['qty'];
            $result['addons'] = new CartProductAddonResource($this->attributes->custom_addons_models[0],$qty);
        }

        return $result;
    }
}
