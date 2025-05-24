<?php

namespace Modules\Order\Transformers\WebService;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        $allOrderProducts = $this->orderProducts->mergeRecursive($this->orderVariations);
        $result = [
            'id' => $this->id,
            'total' => number_format($this->total, 3),
            'off'  => $this->off ,
            'is_fast_delivery'   => $this->is_fast_delivery,
            'shipping' => number_format($this->shipping, 3),
            'subtotal' => number_format($this->subtotal, 3),
            'transaction' => optional($this->transactions)->method,
            'order_status' => [
                'flag' => optional($this->orderStatus)->flag,
                'title' => optional($this->orderStatus)->title,
            ],
            'payment_status'    => optional($this->paymentStatus)->flag,
            'payment_confirmed_at'  => $this->payment_confirmed_at ? date('d-m-Y H:i', strtotime($this->payment_confirmed_at)) : null,
            'products' => OrderProductResource::collection($allOrderProducts),
            'address'   => new OrderAddressResource($this->orderAddress),
            'created_at' => date('d-m-Y H:i', strtotime($this->created_at)),
            'notes' => $this->notes,
            'order_notes' => $this->order_notes,
        ];

        return $result;
    }
}
