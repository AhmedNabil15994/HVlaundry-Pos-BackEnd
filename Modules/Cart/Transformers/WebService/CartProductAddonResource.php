<?php

namespace Modules\Cart\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Catalog\Transformers\WebService\ProductOptionResource;
use Modules\Catalog\Transformers\WebService\ProductVariantResource;
use Modules\Catalog\Transformers\WebService\ProductVariantValueResource;

class CartProductAddonResource extends JsonResource
{

    public function __construct($resource,$qty)
    {
        $this->resource = $resource;
        parent::__construct($resource);
        $this->addon_qty = $qty;
    }
    public function toArray($request)
    {
        return [
            'id' => $this->custom_addon_id,
            'title' => $this->addon->title,
            'image' => url($this->addon->image),
            'price' => $this->price,
            'qty'   => $this->addon_qty ?? null,
        ];
    }
}
