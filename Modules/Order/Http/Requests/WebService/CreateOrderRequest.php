<?php

namespace Modules\Order\Http\Requests\WebService;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Company\Entities\DeliveryCharge;
use Modules\Vendor\Entities\Vendor;
use Modules\Vendor\Entities\VendorDeliveryCharge;
use Illuminate\Support\Str;
use Modules\Company\Entities\Company;
use Modules\Vendor\Traits\VendorTrait;

class CreateOrderRequest extends FormRequest
{
    public function rules()
    {
        $rules['payment'] = 'required';
        return $rules;
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        $messages = [
            'user_id.exists' => __('order::api.orders.validations.user_id.exists'),
            'payment.required' => __('order::api.payment.validations.required'),
            'payment.in' => __('order::api.payment.validations.in') . ' cash,knet,cc,subscriptions_balance,loyalty_points',
        ];

        return $messages;
    }

}
