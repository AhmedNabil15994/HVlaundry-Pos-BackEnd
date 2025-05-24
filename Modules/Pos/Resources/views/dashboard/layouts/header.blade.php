<div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize" data-kt-sticky-offset="{default: '200px', lg: '300px'}" data-kt-sticky-animation="false">
    <!--begin::Header container-->
    <div class="app-container container-xxl d-flex align-items-stretch flex-stack m-0" id="kt_app_header_container">
        <!--begin::Header mobile-->
        <div class="d-flex align-items-center d-lg-none">
            <!--begin::Sidebar toggle-->
            <button id="kt_app_sidebar_mobile_toggle" class="btn btn-icon btn-color-gray-500 btn-active-color-primary ms-n4 me-1">
                <i class="ki-outline ki-burger-menu-6 fs-2x"></i>
            </button>
            <!--end::Sidebar toggle-->
            <!--begin::Logo-->
            <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 me-lg-15">
                <a href="{{route('dashboard.pos.index')}}">
                    <img alt="Logo" src="{{asset('/pos/assets/media/logo.png')}}" class="h-30px" />
                </a>
            </div>
            <!--end::Logo-->
        </div>
        <!--end::Header mobile-->
        <!--begin::Navbar wrapper-->
        <div class="d-flex flex-lg-grow-1 flex-stack gap-5" id="kt_app_navbar_wrapper">
            <!--begin::Navbar-->
            <div class="d-flex align-items-center gap-2 gap-lg-4">
                <a href="{{URL::current()}}" class="btn btn-flex fs-6 h-40px px-4"><h2>@yield('page_name')</h2></a>
            </div>
            <!--end::Navbar-->
        </div>
        <!--end::Navbar wrapper-->
    </div>
    <!--end::Header container-->
</div>
