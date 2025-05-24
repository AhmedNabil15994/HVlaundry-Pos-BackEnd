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

class DeliveryInfoRequest extends FormRequest
{

    public function rules()
    {
       return [
           'address_id' => 'required|numeric|exists:addresses,id',

       ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'state_id.required' => __('order::api.address.validations.state_id.required'),
            'state_id.numeric' => __('order::api.address.validations.state_id.numeric'),
        ];
    }
}
