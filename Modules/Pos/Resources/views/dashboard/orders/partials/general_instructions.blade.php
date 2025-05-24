<div id="general_instruction" class="bg-body drawer drawer-end" data-kt-drawer="true"
     data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'300px', 'lg': '600px'}"
     data-kt-drawer-direction="end" data-kt-drawer-toggle="#general_instruction_toggle" data-kt-drawer-close="#general_instruction_close">

    <div class="card shadow-none border-0 rounded-0 w-100">
        <!--begin::Header-->
        <div class="card-header" id="general_instruction_header">
            <h3 class="card-title fw-bold text-gray-900">General Instructions</h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5" id="general_instruction_close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </button>
            </div>
        </div>
        <!--end::Header-->

        <!--begin::Body-->
        <div class="card-body position-relative" id="general_instruction_body">
            <!--begin::Content-->
            <div id="general_instruction_scroll" class="position-relative me-n5 pe-5" data-kt-scroll="true" data-kt-scroll-height="auto"
                 data-kt-scroll-wrappers="#general_instruction_body" data-kt-scroll-dependencies="#general_instruction_header, #general_instruction_footer">
                <div class="text-center">
                    <h3 class="fw-bold text-gray-600 fs-4 mb-5 mt-10">Notes</h3>
                    <div class="row">
                        <div class="col-12 row form-group">
                            <textarea name="notes" class="form-control form-control-solid h-150px mh-150px min-h150px" placeholder="Type Your Notes Here"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Content-->
        </div>
        <!--end::Body-->

        <!--begin::Footer-->
        <div class="card-footer py-5 text-center" id="general_instruction_footer">
            <a href="#" class="btn btn-bg-body add_note w-100" style="color: #FFF;background: #764fa8">
                <span class="title">Add Note</span>
                <i class="ki-duotone ki-arrow-right fs-3 text-white"><span class="path1"></span><span class="path2"></span></i>
            </a>
        </div>
        <!--end::Footer-->
    </div>
</div>
