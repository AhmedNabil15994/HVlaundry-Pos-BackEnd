@php
    $delivery_fees = 0;
    $delivery = getCartConditionByName($customer_id ?? config('setting.order_default_customer_id'),'company_delivery_fees');
    if($delivery){
        $delivery_fees = $delivery->getValue();
    }

    $subtotal = getCartSubTotal($customer_id ?? config('setting.order_default_customer_id')) * ($is_fast_delivery ? 2:1);
    $discount = getCartItemsCouponValue($customer_id ?? config('setting.order_default_customer_id'));
    $total = $subtotal + $delivery_fees - $discount;
@endphp
<div class="accordion-body p-5 py-5">
    <div class="row mb-5">
        <div class="col-6 text-left">Subtotal</div>
        <div class="col-6 text-right prices fw-bold text-dark-800"><span class="subtotal">{{ number_format($subtotal, 3) }}</span> {{__('KD')}}</div>
    </div>
    <div class="row mb-5">
        <div class="col-6 text-left">Delivery Fees</div>
        <div class="col-6 text-right prices fw-bold text-dark-800"><span class="delivery">{{ number_format($delivery_fees, 3) }}</span> {{__('KD')}}</div>
    </div>
    @if(getCartConditionByName($customer_id ?? config('setting.order_default_customer_id'),'coupon_discount'))
        <div class="row mb-5 discount-row">
            <div class="col-6 text-left">
                Discount <br>
                <a href="#" class="removeDiscount text-center text-danger">Remove Coupon?</a>
            </div>
            <div class="col-6 text-right prices fw-bold text-dark-800"><span class="discount">{{ number_format(getCartItemsCouponValue($customer_id ?? config('setting.order_default_customer_id')) , 3) }}</span> {{__('KD')}}</div>
        </div>
    @else
    <div class="row mb-5">
        <label class="form-label">
            <i class="ki-outline ki-discount fs-2x text-stylish"></i>
            <a href="#" class="text-stylish text-decoration" data-toggle=".discount-form" data-target=".discount-form"> Apply Discount</a>
        </label>
    </div>
    <div class="row mb-5 discount-form">
        <div class="col-9 row">
{{--            <input type="text" class="form-control" name="coupon" placeholder="Coupon Code">--}}
            <div class="col-5">
                <div class="d-block fv-row">
                    <div class="form-check form-check-custom d-block form-check-solid mb-5">
                        <input class="form-check-input me-3 w-15px h-15px" name="discount_type" type="radio" value="value" checked/>
                        <label class="form-check-label">
                            <div class="fw-semibold text-gray-800">Value</div>
                        </label>
                    </div>
                    <div class="form-check form-check-custom d-block form-check-solid mb-5">
                        <input class="form-check-input me-3 w-15px h-15px" name="discount_type" type="radio" value="percentage"/>
                        <label class="form-check-label">
                            <div class="fw-semibold text-gray-800">Percentage</div>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-7 p-0">
                <input type="text" class="form-control discount value" name="discount_value" placeholder="Discount Value">
                <input type="text" class="form-control discount percentage d-hidden" name="discount_percentage" placeholder="Discount Percentage %">
            </div>
        </div>
        <div class="col-3">
            <a href="#" class="applyCoupon btn text-stylish"><i class="ki-outline ki-discount fs-1 text-stylish"></i> Apply</a>
        </div>
    </div>
    @endif
    <hr style="color:#ccc;">
    <div class="row mb-5">
        <div class="col-6 text-left">Total</div>
        <div class="col-6 text-right prices fw-bold text-dark-800"><span class="total">{{ number_format($total, 3) }}</span> {{__('KD')}}</div>
    </div>
</div>


{{--\Cart::getCondition('coupon_discount') == null || \Cart::getCondition('coupon_discount')->getValue() ==0) &&(is_null(getCartItemsCouponValue()) || getCartItemsCouponValue($customer_id ?? null) == 0--}}
@push('extra_scripts')
    <script>
        $(function (){
            @if($is_fast_delivery)
                $('input[name="is_fast_delivery"]').prop('checked',true).trigger('change')
            @endif
        });
    </script>
@endpush
