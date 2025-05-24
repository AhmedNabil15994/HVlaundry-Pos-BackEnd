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

class DeliveryDaysRequest extends FormRequest
{

    public function rules()
    {
       return [
           'address_id' => 'required|numeric|exists:addresses,id',
           'receiving_date' => 'required|date_format:Y-m-d',
           'receiving_time_id' => 'required|exists:pickup_working_times,id',
       ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'address_id.required' => __('order::api.address.validations.address_id.required'),
            'address_id.numeric' => __('order::api.address.validations.address_id.numeric'),
        ];
    }
}
