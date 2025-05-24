<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <i class="ki-outline ki-arrow-up"></i>
</div>
<!--end::Scrolltop-->

<!--begin::Toast-->
<div id="kt_docs_toast_stack_container" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 99999 !important;">
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-kt-docs-toast="stack">
        <div class="toast-header">
            <strong class="me-auto">{{__('apps::dashboard.navbar.pos_system')}}</strong>
            <small>Now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body"></div>
    </div>
</div>
<!--end::Toast-->
<!--begin::Toast-->
<div class="position-fixed top-0 end-0 p-3" style="z-index:  999999 !important;">
    <div id="kt_docs_toast_toggle" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body"></div>
    </div>
</div>
<!--end::Toast-->
@yield('extra')
