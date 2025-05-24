<div id="kt_addresses" class="bg-body drawer drawer-end" data-kt-drawer="true" data-kt-drawer-name="addresses"
     data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'300px', 'lg': '600px'}"
     data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_addresses_toggle" data-kt-drawer-close="#kt_addresses_close">

    <div class="card shadow-none border-0 rounded-0">
        <!--begin::Header-->
        <div class="card-header" id="kt_addresses_header">
            <h3 class="card-title fw-bold text-gray-900">Address Details</h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5" id="kt_addresses_close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </button>
            </div>
        </div>
        <!--end::Header-->

        <!--begin::Body-->
        <div class="card-body position-relative" id="kt_addresses_body">
            <!--begin::Content-->
            <div id="kt_addresses_scroll" class="position-relative scroll-y me-n5 pe-5" data-kt-scroll="true" data-kt-scroll-height="auto"
                 data-kt-scroll-wrappers="#kt_addresses_body" data-kt-scroll-dependencies="#kt_addresses_header, #kt_addresses_footer" data-kt-scroll-offset="5px">
                <!--begin::Timeline items-->
                <div class="timeline timeline-border-dashed">
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
                            <div class="mb-5 pe-3">
                                <!--begin::Title-->
                                <a href="#" class="fs-5 fw-semibold text-gray-800 text-hover-primary mb-2">Address Information:</a>
                                <!--end::Title-->
                            </div>
                            <!--end::Timeline heading-->

                            <!--begin::Timeline details-->
                            <div class="overflow-auto pb-5">
                                <div class="border border-dashed border-gray-300 rounded min-w-450px p-5">
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column col-12 mb-7 fv-row">
                                        <!--begin::Label-->
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="required">Country</span>
                                            <span class="ms-1" data-bs-toggle="tooltip" title="Country">
                                            <i class="ki-outline ki-information fs-7"></i>
                                        </span>
                                        </label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select name="country_id" data-control="select2" data-placeholder="Select a Country..."
                                                data-dropdown-parent="#kt_addresses" class="form-select form-select-solid fw-bold">
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
                                        <select name="state" data-control="select2" data-placeholder="Select a State..."
                                                data-dropdown-parent="#kt_addresses" class="form-select form-select-solid fw-bold">
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
                                    <div class="d-flex flex-column col-12 mb-7 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Name</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input class="form-control form-control-solid" placeholder="" name="name" value="{{$user->name}}" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column col-12 mb-7 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Email</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input class="form-control form-control-solid" type="email" placeholder="" name="email" value="{{$user->email}}" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-column col-12 mb-7 fv-row">
                                        <!--begin::Label-->
                                        <label class="required fs-6 fw-semibold mb-2">Mobile</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input class="form-control form-control-solid" placeholder="" name="mobile" value="{{$user->mobile}}" />
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
                                        <input type="hidden" name="address_id">
                                        <textarea name="address" class="form-control form-control-solid" cols="30" rows="10"></textarea>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="fv-row col-12 mb-7 clearSelection">
                                        <!--begin::Wrapper-->
                                        <div class="d-flex flex-stack">
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
                                                <input class="form-check-input" name="is_default" type="checkbox" value="0"  id="kt_modal_add_customer_billing"/>
                                                <!--end::Input-->
                                                <!--begin::Label-->
                                                <span class="form-check-label fw-semibold text-muted">Yes</span>
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
        <div class="card-footer py-5 text-center" id="kt_addresses_footer">
            <a href="#" class="btn btn-bg-body create_address w-100" style="color: #FFF;background: #764fa8">
                <span class="title">Create Address</span>
                <i class="ki-duotone ki-arrow-right fs-3 text-white"><span class="path1"></span><span class="path2"></span></i>
            </a>
        </div>
        <!--end::Footer-->
    </div>
</div>
