<?php

namespace Modules\Catalog\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class StarchTypeResource extends JsonResource
{
    public function toArray($request)
    {
        $response = [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image ? url($this->image) : null,
        ];

        if (request()->get('model_flag') == 'tree') {
            $response['sub_categories'] = StarchTypeResource::collection($this->childrenRecursive);
        }

        return $response;
    }
}
