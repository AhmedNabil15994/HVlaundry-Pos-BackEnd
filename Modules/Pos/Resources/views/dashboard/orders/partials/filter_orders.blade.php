<div id="kt_filter_orders" class="bg-body drawer drawer-end" data-kt-drawer="true" data-kt-drawer-name="filter_orders"
     data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'300px', 'lg': '600px'}"
     data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_filter_orders_toggle" data-kt-drawer-close="#kt_filter_orders_close">

    <div class="card shadow-none border-0 rounded-0 w-100">
        <!--begin::Header-->
        <div class="card-header" id="kt_filter_orders_header">
            <h3 class="card-title fw-bold text-gray-900">Filter Orders</h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5" id="kt_filter_orders_close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </button>
            </div>
        </div>
        <!--end::Header-->

        <!--begin::Body-->
        <div class="card-body position-relative" id="kt_filter_orders_body" style="position:relative;">
            <!--begin::Content-->
            <div id="kt_filter_orders_scroll" class="position-relative scroll-y me-n5 pe-5" data-kt-scroll="true" data-kt-scroll-height="auto"
                 data-kt-scroll-wrappers="#kt_filter_orders_body" data-kt-scroll-dependencies="#kt_filter_orders_header, #kt_filter_orders_footer" data-kt-scroll-offset="5px">
                <!--begin::Timeline details-->
                <div class="overflow-auto pb-5 mb-10">
                    <div class="rounded p-5">
                        <!--begin::Input group-->
                        <div class="d-flex flex-column col-12 mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span>Basket Type</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="basket_types[]" data-control="select2-checkbox" data-placeholder="All"
                                    data-dropdown-parent="#kt_filter_orders" class="form-select form-select-solid fw-bold" multiple>
                                <option value="pickup_delivery">Pickup & Delivery</option>
                                <option value="pickup">Pickup Only</option>
                                <option value="delivery">Delivery Only</option>
                            </select>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column col-12 mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span>Status</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="order_status_ids[]" data-control="select2-checkbox" data-placeholder="All"
                                    data-dropdown-parent="#kt_filter_orders" class="form-select form-select-solid fw-bold" multiple>
                                @foreach($statuses as $status)
                                    <option value="{{$status->id}}">{{$status->title}}</option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column col-12 mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span>Payment Method</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="payment_methods[]" data-control="select2-checkbox" data-placeholder="All"
                                    data-dropdown-parent="#kt_filter_orders" class="form-select form-select-solid fw-bold" multiple>
                                @foreach(config('setting.supported_payments') as $key => $payment)
                                    @if($key == 'upayment')
                                        @foreach($payment['client_commissions'] as $commissionKey => $commission)
                                            <option value="{{$commissionKey}}"> {{ $commissionKey == 'knet' ? __('Knet') : __('Visa / Master')}} </option>
                                        @endforeach
                                    @else
                                        <option value="{{$key}}"> {{__(ucfirst($key))}} </option>
                                    @endif
                                @endforeach
                                <option value="subscriptions_balance"> {{ __('Subscriptions Balance') }} </option>
                                <option value="loyalty_points"> {{ __('Loyalty Points Balance') }} </option>
                            </select>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column col-12 mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span>Payment Status</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="payment_status_ids[]" data-control="select2-checkbox" data-placeholder="All"
                                    data-dropdown-parent="#kt_filter_orders" class="form-select form-select-solid fw-bold" multiple>
                                @foreach ($paymentStatuses as $paymentStatus)
                                    @if($paymentStatus->id <= 3)
                                        <option value="{{ $paymentStatus->id }}">{{ ucfirst($paymentStatus->flag) }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column col-12 mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span>Date</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="date" data-control="select2" data-placeholder="All"
                                    data-dropdown-parent="#kt_filter_orders" class="form-select form-select-solid fw-bold">
                                <option value="placed">Placed</option>
                                <option value="pickup">Pickup</option>
                                <option value="delivery">Delivery</option>
                                <option value="payment">Payment</option>
                            </select>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column col-12 mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">Date Range</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input class="form-control form-control-solid" name="date_range" placeholder="Pick date rage" id="kt_daterangepicker_1"/>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column col-12 mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span>Customer</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="user_id" data-placeholder="All"
                                    data-dropdown-parent="#kt_filter_orders" class="form-select form-select-solid fw-bold">
                            </select>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column col-12 mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span>State</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="state_ids[]" data-control="select2-checkbox" data-placeholder="All"
                                    data-dropdown-parent="#kt_filter_orders" class="form-select form-select-solid fw-bold" multiple>
                                @foreach ($cityWithStates as $city)
                                    <optgroup label="{{ $city->title }}">
                                        @foreach ($city->states as $state)
                                            <option value="{{ $state->id }}" {{ old('state') == $state->id ? 'selected' : '' }}>
                                                {{ $state->title }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column col-12 mb-7 fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span>Driver</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="driver_ids[]" data-control="select2-checkbox" data-placeholder="All"
                                    data-dropdown-parent="#kt_filter_orders" class="form-select form-select-solid fw-bold" multiple>
                                @foreach($drivers as $driver)
                                    <option value="{{$driver->id}}">{{$driver->name}}</option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                </div>
                <!--end::Timeline details-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Body-->

        <!--begin::Footer-->
        <div class="card-footer py-5 text-center d-flex" id="kt_filter_orders" style="position:fixed;bottom: 0;width: -webkit-fill-available;background: #FFF;">
            <div class="col-6 px-5">
                <a href="#" class="clear-filter btn btn-bg-body btn-stylish text-stylish w-100">
                    <span class="title">Clear</span>
                </a>
            </div>
            <div class="col-6 px-5">
                <a href="#" class="btn btn-bg-body do-filter w-100" style="color: #FFF;background: #764fa8">
                    <span class="title">Apply</span>
                </a>
            </div>
        </div>
        <!--end::Footer-->
    </div>
</div>
