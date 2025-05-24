<?php

namespace Modules\Coupon\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class RechargeCouponRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod()) {
            // handle creates
            case 'post':
            case 'POST':

                return [
                    'code' => 'required|unique:coupons,code',
                     'balance' => 'required',
                    'start_at' => 'required|date_format:Y-m-d|after_or_equal:' . date('Y-m-d'),
                    'expired_at' => 'required|date_format:Y-m-d|after:start_at',
                    // 'user_type' => 'required|array|in:user,guest',
                    'max_discount_percentage_value' => 'nullable|numeric',
                    'users_count' => 'nullable|numeric|min:1',
                ];

            //handle updates
            case 'put':
            case 'PUT':
                return [
                    'code' => 'required|unique:coupons,code',
                    'balance' => 'required',
                    'start_at' => 'required|date_format:Y-m-d|after_or_equal:' . date('Y-m-d'),
                    'expired_at' => 'required|date_format:Y-m-d|after:start_at',
                    // 'user_type' => 'required|array|in:user,guest',
                    'max_discount_percentage_value' => 'nullable|numeric',
                    'users_count' => 'nullable|numeric|min:1',
                ];
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        $v = [
            'discount_type.required' => __('coupon::dashboard.coupons.validation.discount_type.required'),
            'code.required' => __('coupon::dashboard.coupons.validation.code.required'),
            'code.unique' => __('coupon::dashboard.coupons.validation.code.unique'),
            'coupon_flag.in' => __('coupon::dashboard.coupons.validation.coupon_flag.in'),

            'vendor_ids.required_if' => __('coupon::dashboard.coupons.validation.vendor_ids.required_if'),
            'category_ids.required_if' => __('coupon::dashboard.coupons.validation.category_ids.required_if'),
            'product_ids.required_if' => __('coupon::dashboard.coupons.validation.product_ids.required_if'),
            'discount_value.required_if' => __('coupon::dashboard.coupons.validation.discount_value.required_if'),
            'discount_percentage.required_if' => __('coupon::dashboard.coupons.validation.discount_percentage.required_if'),
            'discount_percentage.required' => __('coupon::dashboard.coupons.validation.discount_percentage.required_if'),

            'start_at.required' => __('coupon::dashboard.coupons.validation.start_at.required'),
            'start_at.date_format' => __('coupon::dashboard.coupons.validation.start_at.date_format'),
            'start_at.after_or_equal' => __('coupon::dashboard.coupons.validation.start_at.after_or_equal'),
            'expired_at.required' => __('coupon::dashboard.coupons.validation.expired_at.required'),
            'expired_at.date_format' => __('coupon::dashboard.coupons.validation.expired_at.date_format'),
            'expired_at.after' => __('coupon::dashboard.coupons.validation.expired_at.after'),
        ];
        return $v;
    }
}
