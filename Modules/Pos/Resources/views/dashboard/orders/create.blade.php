@extends('pos::dashboard.layouts.app')

@section('title' , __('apps::dashboard.navbar.pos_system') . ' -- '.'Orders')
@section('page_name' , 'Add New Order')


@section('content')
    <button id="item_details_toggle" style="display: none"></button>
    <button id="general_instruction_toggle" style="display: none"></button>
    <!--begin::Row-->
    <div class="row gx-5 gx-xl-10 mb-xl-10">
        <!--begin::Col-->
        <div class="col-md-8 col-lg-6 col-xl-8 col-xxl-8 mb-10 products-card" style="position: relative;">
            <div class="card card-flush card-p-0 p-10 border-0">
                <!--begin::Page loading(append to body)-->
                <div class="page-loader w-100 h-100 products-loader">
                    <span class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </span>
                </div>
                <!--end::Page loading-->
                <div class="row mb-5">
                    <div class="col-12">
                        <label class="form-label mb-5">Category</label>
                        <ul class="nav nav-pills nav-pills-custom mb-6" role="tablist">
                            <li class="nav-item mb-3 me-3 category_id" role="presentation" data-area="0">
                                <a class="nav-link nav-link-border-solid btn btn-outline btn-flex btn-active-color-primary flex-column flex-stack px-2 pt-3 pb-7 page-bg active" data-bs-toggle="pill"
                                   href="#" style="width: 90px;height: 120px" aria-selected="true" role="tab">
                                    <div class="nav-icon mb-1">
                                        <img src="{{asset(config('setting.images.logo'))}}" class="w-50px" alt="">
                                    </div>
                                    <div class="">
                                        <span class="text-gray-800 fw-bold fs-5 d-block">All</span>
                                        <span class="text-gray-500 fw-semibold fs-7">{{count($products)}} Products</span>
                                    </div>
                                </a>
                            </li>
                            @foreach($categories as $key => $category)
                            <li class="nav-item mb-3 me-3 category_id" role="presentation" data-area="{{$category->id}}">
                                <a class="nav-link nav-link-border-solid btn btn-outline btn-flex btn-active-color-primary flex-column flex-stack px-2 pt-3 pb-7 page-bg "
                                   data-bs-toggle="pill" href="#" style="width: 90px;height: 120px" aria-selected="true" role="tab">
                                    <div class="nav-icon mb-1">
                                        <img src="{{asset($category->image)}}" class="w-50px" alt="">
                                    </div>
                                    <div class="">
                                        <span class="text-gray-800 fw-bold fs-5 d-block">{{$category->title}}</span>
                                        <span class="text-gray-500 fw-semibold fs-7">{{\Modules\Catalog\Entities\Product::active()->whereHas('customAddons')->whereHas('categories',function ($q) use ($category){$q->where('categories.id',$category->id);})->count()}} Products</span>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-4">
                        <div class="mb-3">
                            <label class="form-label">Search For Products</label>
                            <input type="text" class="form-control" name="s" placeholder="Search by product name">
                        </div>
                        <div class="mb-5">
{{--                            <label class="form-label">--}}
{{--                                <i class="ki-outline ki-plus fs-1 bg-gray-100 border-r-50 text-stylish"></i>--}}
{{--                                <a href="#" class="text-stylish text-decoration"> Add Custom Item</a>--}}
{{--                            </label>--}}
                        </div>
                    </div>
{{--                    <div class="col-6">--}}
{{--                        <div class="mb-10">--}}
{{--                            <label class="form-label">Category</label>--}}
{{--                            <select class="form-control" data-control="select2" data-placeholder="Select Category" name="category_id">--}}
{{--                                <option value=""></option>--}}
{{--                                @foreach($categories as $category)--}}
{{--                                    <option value="{{$category->id}}" {{old('category_id') == $category->id ? 'selected' : ''}}>{{$category->title}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
                <div class="d-block hover-scroll-y scroll-ms products" data-kt-scroll="true" style="height: 640px;">
                    @include('pos::dashboard.orders.partials.products')
                </div>
            </div>
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-4 col-lg-6 col-xl-4 col-xxl-4 mb-10">
            <div class="card bg-body cart" id="kt_pos_form">
                <!--begin::Header-->
                <div class="card-header pt-5 mb-10 border-bottom-2">
                    <h3 class="card-title fw-bold text-dark-500 fs-2x">Cart</h3>

                    <!--begin::Toolbar-->
                    <div class="card-toolbar">
                        <label class="form-label">
                            <i class="ki-outline ki-trash fs-2 text-stylish"></i> <a href="#" class="text-stylish fs-4 fw-bold text-decoration clearCart"> Reset</a>
                        </label>
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Header-->

                <!--begin::Body-->
                <div class="card-body p-0 pb-20" style="position: relative">
                    <!--begin::Page loading(append to body)-->
                    <div class="page-loader w-100 h-100 item-loader">
                        <span class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </span>
                    </div>
                    <!--end::Page loading-->

                    <div class="row mb-5 mx-0 px-7 border-bottom-2" style="border-bottom: 2px solid #F1F1F4 !important;">
                        <div class="col-9">
                            <div class="mb-5">
                                <label class="form-label">Search For Customer</label>
                                <select class="form-control" name="customer_id">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="customerIcon mt-7 cursor-pointer" id="kt_activities_toggle" data-bs-toggle="tooltip" data-bs-placement="top" title="Add New Customer">
                                <i class="ki-outline ki-user fs-2x"></i>
                            </div>
                        </div>
                        <div class="col-12 row mb-5 p-5 py-2 bg-light-primary customer-info" style="border-radius: 30px;display: none">
                            <div class="col-5">
                                <div class="d-flex align-items-center">
                                    <i class="ki-outline ki-user fs-2x text-stylish me-2"></i>
                                    <div class="fs-6 fw-semibold text-gray-600 info"></div>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="text-center mt-1">
                                    <i class="ki-outline ki-wallet fs-2x text-stylish me-2"></i>
                                    <div class="fs-6 fw-semibold text-gray-600 d-inline-block"><span class="balance">00.000</span> {{__('KD')}}</div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="text-right mt-2">
                                    <a href="#" class="clear_customer" data-target=".customer-info"><i class="ki-outline ki-cross-circle fs-2x text-stylish me-2"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="slideContent px-5 hover-scroll-y scroll-sm pb-5" data-kt-scroll="true" style="height: 600px">
                        <!--begin::Accordion-->
                        <div class="accordion" id="kt_accordion_1">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="kt_accordion_1_header_1">
                                    <button class="accordion-button text-stylish in fs-6 fw-semibold" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_1" aria-expanded="true" aria-controls="kt_accordion_1_body_1">
                                            <i class="ki-outline ki-time fs-2x text-stylish" style="margin-right: 5px"></i> Date & Time
                                    </button>
                                </h2>
                                <div id="kt_accordion_1_body_1" class="accordion-collapse collapsed collapse show" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                                    <div class="accordion-body p-5 py-10">
                                        <div class="form-check form-switch form-check-custom form-check-solid mb-5">
                                            <label class="form-check-label text-stylish" for="flexSwitchDefault">
                                                <i class="ki-outline ki-courier-express fs-2x text-stylish"></i> Fast
                                            </label>
                                            <input class="form-check-input mx-15 h-20px w-40px" type="checkbox" name="is_fast_delivery" value="" id="flexSwitchDefault"/>
                                        </div>

                                        <div class="form-check form-switch form-check-custom form-check-solid mb-5" id="customer_addresses_toggle">
                                            <label class="form-check-label" for="">
                                                <i class="ki-outline ki-map text-stylish fs-2x"></i> <a href="#" class="text-stylish text-decoration">Select Customer Address</a>
                                            </label>
                                        </div>

                                        <div class="form-check form-switch form-check-custom form-check-solid mb-5">
                                            <label class="form-check-label d-block" for="">
                                                <i class="ki-outline ki-courier text-stylish fs-2x"></i> <a href="#" class="text-stylish">Pick UP</a>
                                            </label>
                                            <input class="form-check-input mx-15 h-20px w-40px" type="checkbox" name="has_pick_up" value="0" data-target=".pickup"/>
                                        </div>

                                        <div class="form-check pickup form-switch form-check-custom form-check-solid mb-5 d-hidden">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="input-group" data-td-target-input="nearest" data-td-target-toggle="nearest">
                                                        <input type="text" name="pickup_date" class="form-control kt-datepicker"/>
                                                        <span class="input-group-text" data-td-target=".kt-datepicker" data-td-toggle="datetimepicker">
                                                            <i class="ki-duotone ki-calendar text-stylish fs-2"><span class="path1"></span><span class="path2"></span></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <select class="form-control" data-control="select2" data-placeholder="Select Pick Time" name="pick_up_time_id">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-check form-switch form-check-custom form-check-solid mb-5">
                                            <label class="form-check-label d-block" for="">
                                                <i class="ki-outline ki-delivery-time text-stylish fs-2x"></i> <a href="#" class="text-stylish">Delivery</a>
                                            </label>
                                            <input class="form-check-input mx-15 h-20px w-40px" type="checkbox" name="has_delivery" value="0" data-target=".delivery"/>
                                        </div>

                                        <div class="form-check form-switch delivery form-check-custom form-check-solid mb-5 d-hidden">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="input-group kt-datepicker2" data-td-target-input="nearest" data-td-target-toggle="nearest">
                                                        <input type="text" name="delivery_date" class="form-control" data-td-target=".kt-datepicker2"/>
                                                        <span class="input-group-text" data-td-target=".kt-datepicker2" data-td-toggle="datetimepicker">
                                                            <i class="ki-duotone ki-calendar text-stylish fs-2"><span class="path1"></span><span class="path2"></span></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <select class="form-control" data-control="select2" data-placeholder="Select Delivery Time" name="delivery_time_id">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Accordion-->
                        <!--begin::Accordion-->
                        <div class="accordion mt-5" id="kt_accordion_2">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="kt_accordion_2_header_1">
                                    <button class="accordion-button text-stylish collapsed fs-6 fw-semibold" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#kt_accordion_2_body_1" aria-expanded="true" aria-controls="kt_accordion_2_body_1">
                                        <i class="ki-outline ki-handcart fs-2x text-stylish" style="margin-right: 5px"></i> ITEMS
                                    </button>
                                </h2>
                                <div id="kt_accordion_2_body_1" class="accordion-collapse collapse" aria-labelledby="kt_accordion_2_header_1" data-bs-parent="#kt_accordion_2">
                                    @include('pos::dashboard.orders.partials.cartItems')
                                </div>
                            </div>
                        </div>
                        <!--end::Accordion-->
                        <!--begin::Accordion-->
                        <div class="accordion mt-5" id="kt_accordion_3">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="kt_accordion_3_header_1">
                                    <button class="accordion-button text-stylish collapsed fs-6 fw-semibold" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#kt_accordion_3_body_1" aria-expanded="true" aria-controls="kt_accordion_3_body_1">
                                        <i class="ki-outline ki-bill fs-2x text-stylish" style="margin-right: 5px"></i> Receipt
                                    </button>
                                </h2>
                                <div id="kt_accordion_3_body_1" class="accordion-collapse collapse" aria-labelledby="kt_accordion_3_header_1" data-bs-parent="#kt_accordion_3">
                                    @include('pos::dashboard.orders.partials.cartTotals')
                                </div>
                            </div>
                        </div>
                        <!--end::Accordion-->
                        <!--begin::Accordion-->
                        <div class="accordion my-5" id="kt_accordion_4">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="kt_accordion_4_header_1">
                                    <button class="accordion-button text-stylish collapsed fs-6 fw-semibold" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#kt_accordion_4_body_1" aria-expanded="true" aria-controls="kt_accordion_4_body_1">
                                        <i class="ki-outline ki-credit-cart fs-2x text-stylish" style="margin-right: 5px"></i> Payment
                                    </button>
                                </h2>
                                <div id="kt_accordion_4_body_1" class="accordion-collapse collapse" aria-labelledby="kt_accordion_4_header_1"
                                     data-bs-parent="#kt_accordion_4">
                                    <div class="accordion-body p-5 py-2">
                                        <div class="row my-8">
                                            <div class="col-4 text-left">Payment Method</div>
                                            <div class="col-8">
                                                <div class="fv-row">
                                                    @foreach(config('setting.supported_payments') as $key => $payment)
                                                        @if($key == 'upayment')
                                                            @foreach($payment['client_commissions'] as $commissionKey => $commission)
                                                                <div class="form-check form-check-custom d-block form-check-solid mb-2">
                                                                    <input class="form-check-input me-3 w-20px h-20px" name="payment_type" type="radio" value="{{$commissionKey}}"/>
                                                                    <label class="form-check-label fw-semibold text-gray-800">
                                                                        @if($commissionKey == 'knet')
                                                                            <img class="w-30px h-30px" src="{{ asset('frontend/assets/images/icons/i-02.png') }}" alt=""> {{ __('Knet')}}
                                                                        @else
                                                                            <img class="w-30px h-30px" src="{{ asset('frontend/assets/images/icons/i-01.png') }}" alt=""> {{__('Visa / Master')}}
                                                                        @endif
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <div class="form-check form-check-custom d-block form-check-solid mb-2">
                                                                <input class="form-check-input me-3 w-20px h-20px" name="payment_type" type="radio" value="{{$key}}"/>
                                                                <label class="form-check-label fw-semibold text-gray-800">
                                                                    <img class="w-30px h-30px" src="{{ asset('frontend/assets/images/icons/i-03.png') }}" alt=""> {{__(ucfirst($key))}}
                                                                </label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                    <div class="form-check form-check-custom d-block form-check-solid mb-2">
                                                        <input class="form-check-input me-3 w-20px h-20px" name="payment_type" type="radio" value="subscriptions_balance"/>
                                                        <label class="form-check-label fw-semibold text-gray-800">
                                                            <img class="w-30px h-30px" src="{{ asset('frontend/assets/images/products/credit.png') }}" alt=""> {{ __('Subscriptions Balance') }}
                                                            ( <span class="subscriptions_balance">0.000</span> {{__('KD')}} )
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-custom d-block form-check-solid mb-2">
                                                        <input class="form-check-input me-3 w-20px h-20px" name="payment_type" type="radio" value="loyalty_points"/>
                                                        <label class="form-check-label fw-semibold text-gray-800">
                                                            <img class="w-30px h-30px" src="{{ asset('frontend/assets/images/products/points.png') }}" alt=""> {{ __('Loyalty Points Balance') }}
                                                            ( <span class="loyalty_points">0.000</span> {{ __('KD') }} )
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row my-8 payment_status">
                                            <div class="col-4 text-left">Payment Status</div>
                                            <div class="col-8">
                                                <div class="fv-row">
                                                    <select class="form-control" data-control="select2" data-placeholder="Select Payment Status" name="payment_status_id">
                                                        <option value=""></option>
                                                        @foreach ($paymentStatuses as $paymentStatus)
                                                            @if($paymentStatus->id <= 3)
                                                                <option value="{{ $paymentStatus->id }}">{{ ucfirst($paymentStatus->flag) }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row my-8 payment_confirmation d-hidden">
                                            <div class="col-4 text-left">Payment Confirmed At</div>
                                            <div class="col-8">
                                                <div class="fv-row">
                                                    <div class="input-group" data-td-target-input="nearest" data-td-target-toggle="nearest">
                                                        <input type="text" name="payment_confirmed_at" class="form-control payment_confirmed_at"/>
                                                        <span class="input-group-text" data-td-target=".payment_confirmed_at" data-td-toggle="datetimepicker">
                                                            <i class="ki-duotone ki-calendar text-stylish fs-2"><span class="path1"></span><span class="path2"></span></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row my-8 message_customer d-hidden">
                                            <div class="col-4 text-left"> Whatsapp Payment Link</div>
                                            <div class="col-8">
                                                <div class="fv-row">
                                                    <div class="form-check form-switch form-check-custom form-check-solid mb-5 mt-2">
                                                        <input class="form-check-input mx-15 h-20px w-40px" type="checkbox" name="message_customer" value=""/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row my-8">
                                            <div class="col-4 text-left">Order Status</div>
                                            <div class="col-8">
                                                <div class="fv-row">
                                                    <select class="form-control" data-control="select2" data-placeholder="Select Order Status" name="order_status_id">
                                                        <option value=""></option>
                                                        @foreach ($statuses as $status)
                                                            <option value="{{ $status->id }}" {{ 7 == $status->id ? 'selected' : '' }}>{{ $status->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row my-8">
                                            <div class="col-4 text-left">Order Notes</div>
                                            <div class="col-8">
                                                <div class="fv-row">
                                                    <textarea name="order_notes" class="form-control form-control-solid p-5 px-5 h-150px mh-150px min-h150px" placeholder="Type Order Notes Here"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Accordion-->
                    </div>
                    <div class="card p-5" style="border-top-right-radius: 0;border-top-left-radius: 0;position: absolute;bottom: 0;width:100%">
                        <button class="btn btn-block createOrder" style="color: #FFF;background: #764fa8">Create Order</button>
                    </div>
                </div>
                <!--end: Card Body-->
            </div>
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
@endsection

@section('extra')
    @include('pos::dashboard.customers.partials.add_customer')
    @include('pos::dashboard.orders.partials.product_details')
    @include('pos::dashboard.orders.partials.general_instructions')
    @include('pos::dashboard.orders.partials.customer_addresses')
@endsection

@push('styles')
    <style>
        .customerIcon{
            border-radius: 50%;
            background: #764fa8 ;
            color: #FFF;
            width: 45px;
            height: 45px;
            padding: 9px;
            text-align: center;
            @if(locale() == 'ar')
            float: left;
            @else
            float: right;
            @endif
        }
        .discount-form{
            display: none;
        }
        .customerIcon i{
            color: #FFF;
        }
        @media (min-width: 1099px) {
            /*body{*/
            /*    overflow-y: hidden;*/
            /*}*/
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(function (){
            let customer_id = "{{config('setting.order_default_customer_id')}}";
            let address_id,state_id,min_order_amount,total,delivery;
            // $('#kt_app_sidebar_toggle').click()
            showLoading(500,$('.products-loader'))
            showLoading(500,$('.item-loader'))

            const paymentConfirmationDatePicker =flatpickr($('.payment_confirmed_at'),{
                enableTime: true,
                dateFormat: "d/m/Y H:i",
                minDate: "today",
            });

            const deliveryDatePicker = flatpickr($('.kt-datepicker2'),{
                enableTime: false,
                dateFormat: "d/m/Y",
                minDate: "today",
                onChange: function(selectedDates, dateStr, instance) {
                    getDeliveryTimes(selectedDates[0])
                    showLoading(500)
                },
            });

            const pickUpDatePicker = flatpickr($('.kt-datepicker'),{
                enableTime: false,
                dateFormat: "d/m/Y",
                minDate: "today",
                onChange: function(selectedDates, dateStr, instance) {
                    $('input[name="delivery_date"]').val('');
                    deliveryDatePicker.set('minDate',new Date(selectedDates[0]))
                    getPickUpTimes(selectedDates[0])
                    showLoading(500)
                },
            });

            $(document).on('change','input[name="discount_type"]',function (){
                let val = $(this).val();
                $('.discount-form .discount').addClass('d-hidden');
                $('.discount-form .discount.'+val).removeClass('d-hidden');
            });

            $('select[name="payment_status_id"],input[name="payment_type"]').on('change',function (){
                getPaymentConfirmation();
            });

            $('.category_id').on('click',function (e){
                $('.category_id a.active').removeClass('active');
                $(this).children('a.nav-link').addClass('active');
                let category_id = $(this).data('area') ? $(this).data('area') : null;
                $.ajax({
                    type: "GET",
                    url: "{{route('dashboard.pos.orders.searchProducts')}}",
                    data:{
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'req':{
                            'categories': category_id
                        },
                    },
                    success:function (response){
                        if(response.data){
                            $('.products').empty().html(response.data.productsHtml);
                            showLoading(500,$('.products-loader'))
                        }
                    },
                    error:function (error){
                        errorMessage(error.errors)
                    }
                });
            });

            $('input[name="s"]').on('keyup',function (e){
                let title = $(this).val();
                let length = title.length;
                if(length >= 3 || length === 0){
                    $.ajax({
                        type: "GET",
                        url: "{{route('dashboard.pos.orders.searchProducts')}}",
                        data:{
                            '_token': $('meta[name="csrf-token"]').attr('content'),
                            'search': {
                                'value': title
                            },
                        },
                        success:function (response){
                            if(response.data){
                                $('.products').empty().html(response.data.productsHtml);
                                showLoading(500,$('.products-loader'))
                            }
                        },
                        error:function (error){
                            errorMessage(error.errors)
                        }
                    });
                }
            });

            $(document).on('click','a[data-target=".discount-form"]',function (e){
                e.preventDefault(),e.stopPropagation();
                $($(this).data('target')).css('display','flex')
            });

            $(document).on('click','a.applyCoupon',function (e){
                e.preventDefault(),e.stopPropagation();
                calcDiscount();
            });

            $(document).on('click','a.removeDiscount',function (e){
                e.preventDefault(),e.stopPropagation();
                removeDiscount();
            });

            $(document).on('click','button.createOrder',function (e){
                e.preventDefault(),e.stopPropagation();
                storeOrder();
            });

            $(document).on('click','a.clear_customer',function (e){
                showLoading(500)
                e.preventDefault(),e.stopPropagation();
                $($(this).data('target')).css('display','none')
                $('select[name="customer_id"]').val('').trigger('change');
                $('#customer_addressess_scroll .timeline').empty();
                $('input[name="pickup_date"],input[name="delivery_date"]').val('');
                $('input[name="is_fast_delivery"]').prop('checked',false);
                customer_id=null,address_id=null,state_id=null,min_order_amount=null,delivery=null;
                clearPickUpTimesSelect();
                clearDeliveryTimesSelect();
                clearPaymentInputs();
            });

            $(document).on('click','#customer_addressess_body .address_item',function (e){
                $('#customer_addressess_body .address_item.active').removeClass('active');
                $(this).addClass('active');
                address_id = $(this).parent('.cursor-pointer').data('area');
                state_id = $(this).parent('.cursor-pointer').data('state');
                $('#customer_addressess_footer .select_address').click();
            });

            $(document).on('click','.product-card',function (){
                let product_id     = $(this).data('area');
                let product_image  = $(this).find('img').attr('src');
                let product_title  = $(this).find('.title').text();

                $('.products .product-card.active').removeClass('active');
                $(this).addClass('active');
                $('#item_details_toggle').click();

                $('#item_details_body .product-card').data('area',product_id)
                $('#item_details_body .product-card img').attr('src',product_image)
                $('#item_details_body .product-card .title').text(product_title);
                $('#item_details input[name="qty"]').val(1);
                $('#item_details textarea[name="notes"]').val('')
                $('#item_details [name="addon_price"]').val('0.000')
                $('#item_details input[name="starch"][value="1"]').prop('checked',true)
                getProductAddons(product_id);
            });

            $(document).on('click','#item_details .dialer button',function (){
                let currentVal = $('input[name="qty"]').val();
                let qtyVal = 1;
                if($(this).data('type') === 'increase'){
                    qtyVal = parseInt(currentVal) + 1;
                }else{
                    if(parseInt(currentVal) - 1){
                        qtyVal = parseInt(currentVal) - 1;
                    }
                }
                $('input[name="qty"]').val(qtyVal)
                calcSingleItem(qtyVal);
            });

            $(document).on('click','.addon-card',function (){
                let addon_id = $(this).data('area');
                $('.addon-card.active').removeClass('active');
                $(this).addClass('active');
                $('#item_details input[name="addon_price"]').val($(this).data('price'))
                calcSingleItem($('input[name="qty"]').val());
            });

            $(document).on('click','.removeCartItem',function (){
                $(this).tooltip(false);
                let url = $(this).data('target');
                let product_id = $(this).data('product');
                let product_type = $(this).data('type');
                $.ajax({
                    type: "POST",
                    url: url,
                    data:{
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'customer_id': customer_id,
                        'product_id': product_id,
                        'product_type': product_type,
                    },
                    success:function (response){
                        if(response.message){
                            $(this).parents('.cart-item').remove();
                            $('#kt_accordion_2_body_1').empty().html(response.data.cartItems);
                            $('#kt_accordion_2_body_1').collapse('show');

                            $('#kt_accordion_3_body_1').empty().html(response.data.cartTotals);
                            $('#kt_accordion_3_body_1').collapse('show');
                            successMessage(response.message);
                            showLoading(500);
                        }
                    },
                    error:function (error){
                        errorMessage(error.errors)
                    }
                })
            });

            $(document).on('click','.clearCart',function (){
                $('select[name="category_id"]').val('').trigger('change');
                $('input[name="s"]').val('');
                $.ajax({
                    type: "POST",
                    url: "{{route('dashboard.pos.orders.clearCart')}}",
                    data:{
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'customer_id': customer_id,
                    },
                    success:function (response){
                        if(response.message){
                            $(this).parents('.cart-item').remove();
                            $('a.clear_customer').click();
                            $('#kt_accordion_2_body_1').empty().html(response.data.cartItems);
                            $('#kt_accordion_2_body_1').collapse('hide');

                            $('#kt_accordion_3_body_1').empty().html(response.data.cartTotals);
                            $('#kt_accordion_3_body_1').collapse('hide');
                            // successMessage(response.message);
                            showLoading(500);
                        }
                    },
                    error:function (error){
                        errorMessage(error.errors)
                    }
                })
            });

            $(document).on('click','#customer_addressess_footer .select_address',function (){
                $('#customer_addressess_close').click();
                showLoading(500)
                calcShipping()
            });

            $('select[name="pick_up_time_id"],input[name="is_fast_delivery"]').on('change',function (){
                getDeliveryDates();
                showLoading(500)
            });

            $('input[name="has_pick_up"],input[name="has_delivery"]').on('change',function (){
                $($(this).data('target')).toggleClass('d-hidden')
                let val = $(this).is(":checked");

                if($(this).data('target') === '.pickup' && val){
                    showLoading(500)
                    getDeliveryDates();

                    let pickUpDate = $($(this).data('target')).find('input[name="pickup_date"]').val();
                    if(!pickUpDate){
                        $($(this).data('target')).find('input[name="pickup_date"]').val(moment().add(1,'days').format("DD/MM/YYYY"))
                        getPickUpTimes(moment().add(1,'days'))
                    }
                }else if($(this).data('target') === '.delivery' && val){
                    let deliveryDate = $($(this).data('target')).find('input[name="delivery_date"]').val();
                    if(!deliveryDate){
                        showLoading(500)
                        if(!$('input[name="pickup_date"]').val()){
                            $('input[name="pickup_date"]').val(moment().add(1,'days').format("DD/MM/YYYY"))
                            getPickUpTimes(moment().add(1,'days'))
                        }else{
                            $($(this).data('target')).find('input[name="delivery_date"]').val(moment().add(2,'days').format("DD/MM/YYYY"))
                            getDeliveryTimes(moment().add(2,'days'))
                        }
                    }
                }
            });

            $(document).on('click','#item_details .add_to_cart',function (){
                $.ajax({
                    type: "POST",
                    url: "{{route('dashboard.pos.orders.addToCart')}}",
                    data:{
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'customer_id': customer_id,
                        'product_id' : $(this).data('area'),
                        'addon_id' : $('#item_details .addon-card.active').data('area'),
                        'qty' : $('#item_details input[name="qty"]').val(),
                        'price' : $('#item_details input[name="addon_price"]').val(),
                        'notes' : $('#item_details textarea[name="notes"]').val(),
                        'starch' : $('#item_details .starch-data.d-hidden').length ? null : $('#item_details input[name="starch"]:checked').val(),
                    },
                    success:function (response){
                        if(response.data){
                            $('#item_details_close').click();
                            successMessage(response.message)

                            $('#kt_accordion_2_body_1').empty().html(response.data.cartItems);
                            $('#kt_accordion_2_body_1').collapse('show');

                            $('#kt_accordion_3_body_1').empty().html(response.data.cartTotals);
                            $('#kt_accordion_3_body_1').collapse('show');
                        }
                    },
                    error:function (error){
                        errorMessage(error.responseJSON.errors)
                    }
                })

            });

            $(document).on('click','.cart-item .instructions',function (){
                $('#general_instruction textarea[name="notes"]').val($(this).data('notes'))
                $('#general_instruction_toggle').click();
            });

            $(document).on('click','#general_instruction .add_note',function (){
                $('#general_instruction_close').click();
            });

            $('select[name="customer_id"]').select2({
                placeholder:"Select Customer",
                minimumInputLength: 3,
                ajax: {
                    url: '{{route('dashboard.pos.customers.getAll')}}',
                    type: "GET",
                    data: function (params) {
                        showLoading(500)
                        return {
                            search : {value: params.term},
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    }
                }
            });

            $('select[name="customer_id"]').on('change',function (){
                if($(this).val()){
                    showLoading(500)
                    $('.customer-info').css('display','flex')
                    customer_id = $(this).val();
                    getCustomerInfo(customer_id);
                }
            });

            if(customer_id){
                $('select[name="customer_id"]').select2('open');
                var $search = $('select[name="customer_id"]').data('select2').dropdown.$search || $('select[name="customer_id"]').data('select2').selection.$search;
                $search.val('{{\Modules\User\Entities\User::find(config('setting.order_default_customer_id'))->name}}');
                $search.trigger('keyup');
                setTimeout(function() { $('.select2-results__option').trigger("mouseup"); }, 500);
            }

            function getProductAddons(product_id){
                $('#item_details .addonsRow').empty();
                $.ajax({
                    type: "GET",
                    url: "{{route('dashboard.pos.orders.get_product_addons')}}",
                    data:{
                        'product_id' : product_id,
                    },
                    success:function (response){
                        let itemDesign = '';
                        showLoading(500);
                        if(response.addons.length === 2){
                            itemDesign = "<div class='col-2'></div>"
                        }
                        $.each(response.addons ,function (index,item){
                           itemDesign+= ' <div class="col-4">'+
                                `<div class="card cursor-pointer addon-card ${index === 0 ? 'active' : ''} w-120px mh-120px" data-price=${item.pivot.price} data-area="${item.id}">`+
                                   '<div class="card-body text-center p-0 py-5">'+
                                        `<img src="${item.image_url}" class="rounded-3 w-75px h-75px w-xxl-75px h-xxl-75px" alt="">`+
                                       '<div class="mb-2">'+
                                            '<div class="text-center">'+
                                                `<span class="fw-semibold text-gray-600 cursor-pointer fs-4">${item.title['{{locale()}}']}</span>`+
                                            '</div>'+
                                       '</div>'+
                                   '</div>'+
                                '</div>'+
                           '</div>';

                           if(index === 0){
                               $('#item_details input[name="addon_price"]').val(item.pivot.price)
                           }
                        });

                        if(response.has_starch){
                            $('.starch-data').removeClass('d-hidden')
                        }else{
                            $('.starch-data').addClass('d-hidden')
                        }
                        $('#item_details .add_to_cart').data('area',product_id)
                        $('#item_details .addonsRow').html(itemDesign);
                    },
                    error:function (error){
                        errorMessage(error[1])
                    }
                })
            }

            function getCustomerInfo(customer_id){
                $('.customer-info .info').html('')
                $('.customer-info .balance').html('00.000')

                $.ajax({
                    type: "GET",
                    url: '{{route('dashboard.pos.customers.getOne',['id'=>':id'])}}'.replace(':id',customer_id),
                    success:function (data){
                        if(data[0]){
                            let userObj = data[1];
                            $('.customer-info .info').html(userObj.name + '<br>' + userObj.mobile)
                            $('.customer-info .balance').html(userObj.subscriptions_balance)
                            $('.subscriptions_balance').html(userObj.subscriptions_balance)
                            $('.loyalty_points').html(userObj.loyalty_points_count)
                            buildAddressesData(userObj.addresses);
                        }else{
                            errorMessage(data[1])
                        }
                    },
                    error:function (error){
                        errorMessage(error[1])
                    }
                })
            }

            function buildAddressesData(data){
                $('#kt_accordion_1_body_1').collapse('show');
                $('#kt_customer_addressess .timeline').empty();

                let x ='';
                $.each(data,function (index,item){
                    x+= `<div class="row mb-5 cursor-pointer" data-state="${item.state_id}" data-area="${item.id}" data-toggle="${item.user_id}">`+
                            '<div class="d-block text-center w-100 address_item py-2 pb-3">'+
                                '<i class="ki-outline ki-map fs-2x text-stylish me-2"></i>'+
                                '<div class="fs-3 fw-semibold  d-inline-block">';
                    x+= item.state;
                    if (item.street) {
                        x+= ' / ' + "{{__('Street')}}" + ': ' + item.street;
                    }
                    if (item.floor) {
                        x+= ' / ' + "{{__('Floor')}}" + ': ' + item.floor;
                    }
                    if (item.flat) {
                        x+= ' / ' + "{{__('Flat')}}" + ': ' + item.flat;
                    }
                    x+='</div></div></div>';
                });
                $('#kt_customer_addressess .timeline').html(x);
                $('#customer_addresses_toggle').click();
            }

            function getPickUpTimes(day){
                $.ajax({
                    type: "GET",
                    url: "{{route('dashboard.pos.orders.get_pickup_working_times')}}",
                    data:{
                        'state_id' : state_id,
                        'customer_id': customer_id,
                        'address_id': address_id,
                        'pickUpDate': moment(day).format('YYYY-MM-DD'),
                        'is_fast_delivery':  $('input[name="is_fast_delivery"]').is(":checked") ? 1 : 0,
                    },
                    success:function (response){
                        if(response.status === 1){
                            buildPickUpData(response.data.fullData);
                        }else{
                            clearPickUpTimesSelect();
                            clearDeliveryTimesSelect();
                            $('input[name="delivery_date"]').val('');
                            errorMessage(response.message)
                        }
                    },
                    error:function (error){
                        errorMessage(error[1])
                    }
                })
            }

            function buildPickUpData(data){
                let pickUpTimes = '<option value=""></option>';

                $('input[name="pickup_date"]').val(data.firstSelection.pickup.day.full_date_slash);
                // pickUpDatePicker.setDate(data.firstSelection.day.full_date_slash)
                $('select[name="pick_up_time_id"]').empty();
                $('select[name="pick_up_time_id"]').select2('destroy');

                $.each(data.pickupWorkingDays ,function (index,item){
                    if(data.firstSelection.pickup.day.full_date === item.full_date){
                        $.each(item.pickup_working_times ,function (childIndex,childItem){
                            pickUpTimes+= `<option value="${childItem.id}" ${data.firstSelection.pickup.time.pickup_working_times_id === childItem.id ? 'selected' : ''}>${childItem.from + ' - ' + childItem.to}</option>`;
                        });
                    }
                });

                $('select[name="pick_up_time_id"]').html(pickUpTimes);
                $('select[name="pick_up_time_id"]').select2().val(data.firstSelection.pickup.time.pickup_working_times_id).trigger('change');

                buildDeliveryData(data);
            }

            function buildDeliveryData(data,dontClear=0){
                let deliveryTimes = '<option value=""></option>';

                $('input[name="delivery_date"]').val(data.firstSelection.delivery.day.full_date_slash);
                $('select[name="delivery_time_id"]').empty();
                $('select[name="delivery_time_id"]').select2('destroy');

                $.each(data.deliveryWorkingDays ,function (index,item){
                    if(data.firstSelection.delivery.day.full_date === item.full_date){
                        $.each(item.delivery_working_times ,function (childIndex,childItem){
                            deliveryTimes+= `<option value="${childItem.id}" ${data.firstSelection.delivery.time === childItem.id ? 'selected' : ''}>${childItem.from + ' - ' + childItem.to}</option>`;
                        });
                    }
                });

                if(!dontClear){
                    $('#kt_accordion_2_body_1').empty().html(data.cartItems);
                    $('#kt_accordion_2_body_1').collapse('show');

                    $('#kt_accordion_3_body_1').empty().html(data.cartTotals);
                    $('#kt_accordion_3_body_1').collapse('show');
                }

                $('select[name="delivery_time_id"]').html(deliveryTimes);
                $('select[name="delivery_time_id"]').select2();

            }

            function getDeliveryDates(){
                let selected_pickup_receiving_date =  moment($('input[name="pickup_date"]').val(),'DD/MM/YYYY').format('YYYY-MM-DD');
                let selected_pickup_receiving_time = $('select[name="pick_up_time_id"] option:selected').text();
                if($('input[name="pickup_date"]').val()){
                    $.ajax({
                        type: "GET",
                        url: "{{route('dashboard.pos.orders.get_pickup_working_times')}}",
                        data:{
                            'state_id' : state_id,
                            'customer_id': customer_id,
                            'address_id': address_id,
                            'pickUpDate': selected_pickup_receiving_date,
                            'pickUpTime': selected_pickup_receiving_time,
                            'is_fast_delivery':  $('input[name="is_fast_delivery"]').is(":checked") ? 1 : 0,
                        },
                        success:function (response){
                            if(response.status === 1){
                                buildDeliveryData(response.data.fullData);
                            }else{
                                clearDeliveryTimesSelect();
                                errorMessage(response.message)
                            }
                        },
                        error:function (error){
                            errorMessage(error[1])
                        }
                    })
                }

            }

            function getDeliveryTimes(day){
                $.ajax({
                    type: "GET",
                    url: "{{route('dashboard.pos.orders.get_delivery_working_times')}}",
                    data:{
                        'state_id' : state_id,
                        'deliveryDate': moment(day).format('YYYY-MM-DD'),
                        'pickUpDate': moment($('input[name="pickup_date"]').val(),'DD/MM/YYYY').format('YYYY-MM-DD'),
                        'pickUpTime': $('select[name="pick_up_time_id"] option:selected').text(),
                        'is_fast_delivery':  $('input[name="is_fast_delivery"]').is(":checked") ? 1 : 0,
                    },
                    success:function (response){
                        if(response.status === 1){
                            buildDeliveryData(response.data.fullData,1);
                        }else{
                            clearDeliveryTimesSelect();
                            errorMessage(response.message)
                        }
                    },
                    error:function (error){
                        errorMessage(error[1])
                    }
                })
            }

            function calcShipping(date){
                let url = "{{route('dashboard.pos.orders.get_pickup_working_times')}}";
                $.ajax({
                    type: "GET",
                    url: url,
                    data:{
                        "state_id" : state_id,
                        'customer_id': customer_id,
                        'address_id': address_id,
                        'is_fast_delivery':  $('input[name="is_fast_delivery"]').is(":checked") ? 1 : 0,
                    },
                    success:function (response){
                        min_order_amount = response.data.deliveryCharge.min_order_amount;
                        delivery = response.data.deliveryCharge.delivery
                        $('span.delivery').html(delivery)

                        buildPickUpData(response.data.fullData);
                    },
                    error:function (error){
                        errorMessage(error[1])
                    }
                })
            }

            function calcSingleItem(qty){
                let price = 0;
                if($('.addon-card.active').length){
                    price = $('.addon-card.active').data('price');
                }
                $('#item_details input[name="addon_price"]').val((parseFloat(price) * qty).toFixed(3))
            }

            function calcDiscount(){
                $.ajax({
                    type: "POST",
                    url: "{{route('dashboard.pos.orders.applyCoupon')}}",
                    data:{
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        "state_id" : state_id,
                        'customer_id': customer_id,
                        'address_id': address_id,
                        'is_fast_delivery':  $('input[name="is_fast_delivery"]').is(":checked") ? 1 : 0,
                        'discount_type': $('input[name="discount_type"]:checked').val(),
                        'discount_percentage': $('input[name="discount_percentage"]').val(),
                        'discount_value': $('input[name="discount_value"]').val(),
                        // 'coupon': $('input[name="coupon"]').val(),
                    },
                    success:function (response){
                        if(response.message){
                            $('#kt_accordion_3_body_1').empty().html(response.data.cartTotals);
                            $('#kt_accordion_3_body_1').collapse('show');
                            successMessage(response.message);
                            showLoading(500);
                        }
                    },
                    error:function (error){
                        errorMessage(error.responseJSON.errors)
                    }
                })
            }

            function storeOrder(){
                $.ajax({
                    type: "POST",
                    url: "{{route('dashboard.pos.orders.store')}}",
                    data:{
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        "state_id" : state_id,
                        'customer_id': customer_id,
                        'address_id': address_id,
                        'has_pick_up':  $('input[name="has_pick_up"]').is(":checked") ? 1 : 0,
                        'has_delivery':  $('input[name="has_delivery"]').is(":checked") ? 1 : 0,
                        'is_fast_delivery':  $('input[name="is_fast_delivery"]').is(":checked") ? 1 : 0,
                        'pickup_date'   : moment($('input[name="pickup_date"]').val(),'DD/MM/YYYY').format('YYYY-MM-DD'),
                        'pickup_working_times_id' : $('select[name="pick_up_time_id"] option:selected').val(),
                        'delivery_date'   : moment($('input[name="delivery_date"]').val(),'DD/MM/YYYY').format('YYYY-MM-DD'),
                        'delivery_working_times_id' : $('select[name="delivery_time_id"] option:selected').val(),
                        'payment_type' : $('input[name="payment_type"]:checked').val(),
                        'payment_status_id' : $('select[name="payment_status_id"] option:selected').val(),
                        'order_status_id' : $('select[name="order_status_id"] option:selected').val(),
                        'payment_confirmed_at' : $('input[name="payment_confirmed_at"]').val() ? moment($('input[name="payment_confirmed_at"]').val(),'DD/MM/YYYY hh:mm').format('YYYY-MM-DD hh:mm') : '',
                        'order_notes' : $('textarea[name="order_notes"]').val(),
                        'message_customer':  $('input[name="message_customer"]').is(":checked") ? 1 : 0,
                    },
                    success:function (response){
                        if(response.message){
                            successMessage(response.message);
                            showLoading(500);
                            $('.clearCart').click()
                        }
                    },
                    error:function (error){
                        $.each(error.responseJSON.errors,function (index,item){
                            errorMessage(item[0])
                        })
                    }
                })
            }

            function showLoading(time,item=null){
                if(item){
                    item.show();
                }else{
                    $(".page-loader.item-loader").show();
                }

                setTimeout(function() {
                    KTApp.hidePageLoading();
                    if(item){
                        item.hide();
                    }else{
                        $(".page-loader.item-loader").hide();
                    }
                }, time);
            }

            function clearPickUpTimesSelect(){
                let pickUpTimes = '<option value=""></option>';
                $('select[name="pick_up_time_id"]').empty();
                $('select[name="pick_up_time_id"]').select2('destroy');
                $('select[name="pick_up_time_id"]').html(pickUpTimes);
                $('select[name="pick_up_time_id"]').select2();
            }

            function clearDeliveryTimesSelect(){
                let deliveryTimes = '<option value=""></option>';
                $('select[name="delivery_time_id"]').empty();
                $('select[name="delivery_time_id"]').select2('destroy');
                $('select[name="delivery_time_id"]').html(deliveryTimes);
                $('select[name="delivery_time_id"]').select2();
            }

            function clearPaymentInputs(){
                $('input[name="payment_type"]').prop('checked',false);
                $('.subscriptions_balance').html('0.000');
                $('.loyalty_points').html('0.000');
                $('[name="payment_status_id"]').val(0).trigger('change');
                $('[name="order_status_id"]').val(7).trigger('change');
                $('[name="order_notes"]').val('');
                $('[name="message_customer"]').prop('checked',false)
                $('#kt_accordion_4_body_1').collapse('hide');
            }

            function getPaymentConfirmation(){
                if($('[name="payment_status_id"]').val() == 2 && $('[name="payment_type"]:checked').val()){
                    $('.payment_confirmation').removeClass('d-hidden');
                }else{
                    $('.payment_confirmation').addClass('d-hidden');
                }

                if($('[name="payment_status_id"]').val() == 1 &&
                    ($('[name="payment_type"]:checked').val() == 'knet' || $('[name="payment_type"]:checked').val() == 'cc')){
                    $('.message_customer').removeClass('d-hidden');
                }else{
                    $('.message_customer').addClass('d-hidden');
                }

                if($('[name="payment_type"]:checked').val() == 'subscriptions_balance' || $('[name="payment_type"]:checked').val() == 'loyalty_points'){
                    $('.payment_status').addClass('d-hidden');
                }else{
                    $('.payment_status').removeClass('d-hidden');
                }
            }

            function removeDiscount(){
                $.ajax({
                    type: "POST",
                    url: "{{route('dashboard.pos.orders.removeCoupon')}}",
                    data:{
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        "state_id" : state_id,
                        'customer_id': customer_id,
                        'address_id': address_id,
                        'is_fast_delivery':  $('input[name="is_fast_delivery"]').is(":checked") ? 1 : 0,
                    },
                    success:function (response){
                        if(response.message){
                            $('#kt_accordion_3_body_1').empty().html(response.data.cartTotals);
                            $('#kt_accordion_3_body_1').collapse('show');
                            successMessage(response.message);
                            showLoading(500);
                        }
                    },
                    error:function (error){
                        errorMessage(error.responseJSON.errors)
                    }
                })
            }
        });
    </script>
@endpush
