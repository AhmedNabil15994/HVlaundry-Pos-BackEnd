<div id="kt_customer_addressess" class="bg-body drawer drawer-end" data-kt-drawer="true" data-kt-drawer-name="update_customer" data-kt-drawer-activate="true"
     data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'300px', 'lg': '600px'}" data-kt-drawer-direction="end"
     data-kt-drawer-toggle="#customer_addresses_toggle" data-kt-drawer-close="#customer_addressess_close">

    <div class="card shadow-none border-0 rounded-0 w-100">
        <!--begin::Header-->
        <div class="card-header" id="customer_addressess_header">
            <h3 class="card-title fw-bold text-gray-900">Customer Addresses</h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5" id="customer_addressess_close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </button>
            </div>
        </div>
        <!--end::Header-->

        <!--begin::Body-->
        <div class="card-body position-relative" id="customer_addressess_body">
            <!--begin::Content-->
            <div id="customer_addressess_scroll" class="position-relative scroll-y me-n5 pe-5" data-kt-scroll="true" data-kt-scroll-height="auto"
                 data-kt-scroll-wrappers="#customer_addressess_body" data-kt-scroll-dependencies="#customer_addressess_header, #customer_addressess_footer" data-kt-scroll-offset="5px">
                <!--begin::Timeline items-->
                <div class="timeline timeline-border-dashed px-5 mt-15">

                </div>
                <!--end::Timeline items-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Body-->

        <!--begin::Footer-->
        <div class="card-footer py-5 text-center" id="customer_addressess_footer">
            <a href="#" class="btn btn-bg-body select_address w-100" style="color: #FFF;background: #764fa8">
                Select Address
                <i class="ki-duotone ki-arrow-right fs-3 text-white"><span class="path1"></span><span class="path2"></span></i>
            </a>
        </div>
        <!--end::Footer-->
    </div>
</div>
