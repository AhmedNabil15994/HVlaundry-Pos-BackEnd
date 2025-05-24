<?php

namespace Modules\Catalog\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;
// use Modules\Advertising\Transformers\WebService\AdvertisingResource;
use Modules\Tags\Transformers\WebService\TagsResource;
use Modules\Vendor\Traits\VendorTrait;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'title' => optional($this)->title,
            'description' => htmlView(optional($this)->description),
            'image' => $this->image ? url($this->image) : null,
            'addons' => AddOnsResource::collection($this->customAddons),
            'sharable_link' => route('frontend.products.index', $this->slug),
            'categories' => CategoryResource::collection($this->parentCategories),
        ];

        if (auth('api')->check()) {
            $result['is_favorite'] = CheckProductInUserFavourites($this->id, auth('api')->id());
        } else {
            $result['is_favorite'] = null;
        }

        return $result;
    }
}
