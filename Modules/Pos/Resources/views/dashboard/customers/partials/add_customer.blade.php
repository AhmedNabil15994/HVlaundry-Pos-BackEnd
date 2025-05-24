<div id="kt_activities" class="bg-body drawer drawer-end" data-kt-drawer="true" data-kt-drawer-name="activities" data-kt-drawer-activate="true"
     data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'300px', 'lg': '600px'}" data-kt-drawer-direction="end"
     data-kt-drawer-toggle="#kt_activities_toggle" data-kt-drawer-close="#kt_activities_close">

    <div class="card shadow-none border-0 rounded-0">
        <!--begin::Header-->
        <div class="card-header" id="kt_activities_header">
            <h3 class="card-title fw-bold text-gray-900">Customer Details</h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5" id="kt_activities_close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </button>
            </div>
        </div>
        <!--end::Header-->

        <!--begin::Body-->
        <div class="card-body position-relative" id="kt_activities_body">
            <!--begin::Content-->
            <div id="kt_activities_scroll" class="position-relative scroll-y me-n5 pe-5" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_activities_body" data-kt-scroll-dependencies="#kt_activities_header, #kt_activities_footer" data-kt-scroll-offset="5px">
                <!--begin::Timeline items-->
                <div class="timeline timeline-border-dashed">
                    <!--begin::Timeline item-->
                    <div class="timeline-item">
                        <!--begin::Timeline line-->
                        <div class="timeline-line"></div>
                        <!--end::Timeline line-->

                        <!--begin::Timeline icon-->
                        <div class="timeline-icon">
                            <i class="ki-duotone ki-pencil fs-2 text-gray-500">
                                <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span>
                            </i>
                        </div>
                        <!--end::Timeline icon-->

                        <!--begin::Timeline content-->
                        <div class="timeline-content mb-10 mt-n1">
                            <!--begin::Timeline heading-->
                            <div class="mb-5 pe-3">
                                <!--begin::Title-->
                                <a href="#" class="fs-5 fw-semibold text-gray-800 text-hover-primary mb-2">Basic Info:</a>
                                <!--end::Title-->
                            </div>
                            <!--end::Timeline heading-->

                            <!--begin::Timeline details-->
                            <div class="overflow-auto pb-5">
                                <div class="border border-dashed border-gray-300 rounded min-w-450px p-5">
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7 col-12 clearSelection">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Name</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control form-control-solid" placeholder="Name" name="name" value="" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7 col-12 clearSelection">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="required">Email</span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="email" class="form-control form-control-solid" placeholder="Email" name="email" value="" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7 col-12 clearSelection">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Phone</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="tel" class="form-control form-control-solid" placeholder="Phone" name="mobile" value="" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-7 col-12 clearSelection">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Password</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="password" class="form-control form-control-solid" placeholder="Password" name="password" value="" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row mb-15 col-12 clearSelection">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Password Confirmation</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="password" class="form-control form-control-solid" placeholder="Password Confirmation" name="password_confirmation" value="" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                            </div>
                            <!--end::Timeline details-->
                        </div>
                        <!--end::Timeline content-->
                    </div>
                    <!--end::Timeline item-->
                    <!--begin::Timeline item-->
                    <div class="timeline-item">
                        <!--begin::Timeline line-->
                        <div class="timeline-line"></div>
                        <!--end::Timeline line-->

                        <!--begin::Timeline icon-->
                        <div class="timeline-icon">
                            <i class="ki-duotone ki-map fs-2 text-gray-500">
                                <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span>
                            </i>
                        </div>
                        <!--end::Timeline icon-->

                        <!--begin::Timeline content-->
                        <div class="timeline-content mb-10 mt-n1">
                            <!--begin::Timeline heading-->
                            <div class="mb-5 pe-3 clearSelection w-100 ">
                                <!--begin::Title-->
                                <a href="#" class="fs-5 fw-semibold text-gray-800 text-hover-primary mb-2">Address Information:</a>
                                <!--end::Title-->
                                <!--begin::Switch-->
                                <label class="form-check form-switch form-check-custom form-check-solid float-right">
                                    <!--begin::Input-->
                                    <input class="form-check-input" name="has_address" type="checkbox" id="has_address" checked/>
                                    <!--end::Input-->
                                    <!--begin::Label-->
                                    <span class="form-check-label fw-semibold text-muted" >Yes</span>
                                    <!--end::Label-->
                                </label>
                                <div class="clearfix"></div>
                                <!--end::Switch-->
                            </div>
                            <!--end::Timeline heading-->

                            <!--begin::Timeline details-->
                            <div class="overflow-auto pb-5">
                                <div class="border border-dashed border-gray-300 rounded min-w-450px p-5 user_address">
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column col-12 mb-7 fv-row clearSelection">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="required">Country</span>
                                            <span class="ms-1" data-bs-toggle="tooltip" title="Country of origination">
                                            <i class="ki-outline ki-information fs-7"></i>
                                        </span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select name="country_id" data-control="select2" data-placeholder="Select a Country..." data-dropdown-parent=".user_address" class="form-select form-select-solid fw-bold">
                                            @if (isset($countries) && count($countries) > 0)
                                                <option value=""></option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ old('country_id') == $country->id || $country->id == '1' ? 'selected' : '' }}>
                                                        {{ $country->title }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column col-12 mb-7 fv-row clearSelection">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="required">City</span>
                                            <span class="ms-1" data-bs-toggle="tooltip" title="City of origination">
                                            <i class="ki-outline ki-information fs-7"></i>
                                        </span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select name="state" data-control="select2" data-placeholder="Select a State..." data-dropdown-parent=".user_address" class="form-select form-select-solid fw-bold">
                                            @foreach ($cityWithStates as $city)
                                                <option value=""></option>
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
                                    <div class="d-flex flex-column col-12 mb-7 fv-row clearSelection">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Block</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input class="form-control form-control-solid" placeholder="" name="block" value="" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column col-12 mb-7 fv-row clearSelection">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Building</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input class="form-control form-control-solid" placeholder="" name="building" value="" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column col-12 mb-7 fv-row clearSelection">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Street</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input class="form-control form-control-solid" placeholder="" name="street" value="" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column col-12 mb-7 fv-row clearSelection">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Gada</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input class="form-control form-control-solid" placeholder="" name="avenue" value="" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column col-12 mb-7 fv-row clearSelection">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Floor</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input class="form-control form-control-solid" placeholder="" name="floor" value="" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column col-12 mb-7 fv-row clearSelection">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Flat</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input class="form-control form-control-solid" placeholder="" name="flat" value="" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column col-12 mb-7 fv-row clearSelection">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Automated Number</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input class="form-control form-control-solid" placeholder="" name="automated_number" value="" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column mb-7 col-12 fv-row clearSelection">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Address Details</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <textarea name="address" class="form-control form-control-solid" cols="30" rows="10"></textarea>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row col-12 mb-7">
                                        <!--begin::Wrapper-->
                                        <div class="d-flex flex-stack clearSelection">
                                            <!--begin::Label-->
                                            <div class="me-5">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-semibold">Use as a default adderess?</label>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Label-->
                                            <!--begin::Switch-->
                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                <!--begin::Input-->
                                                <input class="form-check-input" name="is_default" type="checkbox" value="1" id="kt_modal_add_customer_billing" checked="checked" />
                                                <!--end::Input-->
                                                <!--begin::Label-->
                                                <span class="form-check-label fw-semibold text-muted" for="kt_modal_add_customer_billing">Yes</span>
                                                <!--end::Label-->
                                            </label>
                                            <!--end::Switch-->
                                        </div>
                                        <!--begin::Wrapper-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                            </div>
                            <!--end::Timeline details-->
                        </div>
                        <!--end::Timeline content-->
                    </div>
                    <!--end::Timeline item-->
                </div>
                <!--end::Timeline items-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Body-->

        <!--begin::Footer-->
        <div class="card-footer py-5 text-center" id="kt_activities_footer">
            <a href="#" class="btn btn-bg-body create_customer w-100" style="color: #FFF;background: #764fa8">
                Create Customer
                <i class="ki-duotone ki-arrow-right fs-3 text-white"><span class="path1"></span><span class="path2"></span></i>
            </a>
        </div>
        <!--end::Footer-->
    </div>
</div>

@push('extra_scripts')
    <script>
        "use strict";
        // On document ready
        KTUtil.onDOMContentLoaded(function () {

            $(document).on('change','#kt_activities input[name="has_address"]',function (){
                $('.user_address').toggle({height: 'toggle'});
            })

            $(document).on('click','.create_customer',function (e){
                e.preventDefault();e.stopPropagation();
                $.ajax({
                    type: 'POST',
                    url: "{{route('dashboard.pos.customers.store')}}",
                    data:{
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'name': $('#kt_activities input[name="name"]').val(),
                        'email': $('#kt_activities input[name="email"]').val(),
                        'mobile': $('#kt_activities input[name="mobile"]').val(),
                        'password': $('#kt_activities input[name="password"]').val(),
                        'password_confirmation': $('#kt_activities input[name="password_confirmation"]').val(),
                        'has_address': $('#kt_activities input[name="has_address"]').is(":checked") ? 1 : 0,

                        'user_address[country_id]': $('#kt_activities select[name="country_id"]').val(),
                        'user_address[state]': $('#kt_activities select[name="state"]').val(),
                        'user_address[block]': $('#kt_activities input[name="block"]').val(),
                        'user_address[building]': $('#kt_activities input[name="building"]').val(),
                        'user_address[street]': $('#kt_activities input[name="street"]').val(),
                        'user_address[avenue]': $('#kt_activities input[name="avenue"]').val(),
                        'user_address[floor]': $('#kt_activities input[name="floor"]').val(),
                        'user_address[flat]': $('#kt_activities input[name="flat"]').val(),
                        'user_address[automated_number]': $('#kt_activities input[name="automated_number"]').val(),
                        'user_address[address]': $('#kt_activities [name="address"]').val(),
                        'user_address[is_default]': $('#kt_activities input[name="is_default"]').is(":checked") ? 1 : 0,
                    },
                    success:function (data){
                        successMessage(data[1])
                        $('#kt_activities_close').click()
                        if($('#kt_customers_table').length){
                            let myTable = new $.fn.dataTable.Api( '#kt_customers_table' );
                            myTable.ajax.reload();
                        }
                        if($('select[name="customer_id"]').length){
                            $('select[name="customer_id"]').select2('open');
                            var $search = $('select[name="customer_id"]').data('select2').dropdown.$search || $('select[name="customer_id"]').data('select2').selection.$search;
                            $search.val($('#kt_activities input[name="name"]').val());
                            $search.trigger('keyup');
                            setTimeout(function() { $('.select2-results__option').trigger("mouseup"); }, 500);
                        }

                        clearFormData();
                    },
                    error:function (error){
                        $.each(error.responseJSON.errors ,function (index,item){
                            errorMessage(item[0])
                        })
                    }
                })
            });

        });
    </script>
@endpush
