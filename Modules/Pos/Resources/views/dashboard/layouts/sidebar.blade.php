<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}"
     data-kt-drawer-overlay="true" data-kt-drawer-width="auto" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
{{--    <div class="app-sidebar-header px-6 py-7" id="kt_app_sidebar_header">--}}
{{--        <!--begin::Logo-->--}}
{{--        <a href="{{route('dashboard.pos.index')}}">--}}
{{--            <img alt="Logo" src="{{asset('/pos/assets/media/logo.png')}}"/>--}}
{{--        </a>--}}
{{--        <!--end::Logo-->--}}
{{--    </div>--}}
    <div class="app-sidebar-logo px-6 py-7" id="kt_app_sidebar_logo" style="position:relative;">
        <a href="{{route('dashboard.pos.index')}}" style="display: inline-block;width: 80%">
            <img alt="Logo" src="{{asset('/pos/assets/media/logo.png')}}" class="h-85px app-sidebar-logo-default w-100 d-hidden sidebar_logo">
        </a>

        <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted h-30px mt-7 w-30px position-absolute translate-middle rotate"
             data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
            <i class="ki-outline ki-burger-menu-5 fs-3x text-stylish"></i>
        </div>
        <!--end::Sidebar toggle-->
    </div>
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <div class="app-sidebar-content px-2">
            <!--begin::Primary menu-->
            <div class="scroll-ms my-5" id="kt_app_sidebar_content" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_header" data-kt-scroll-offset="10px">
                <!--begin::Menu-->
                <div data-kt-menu="true" class="menu menu-sub-indention menu-rounded menu-column menu-arrow-gray-500 fw-semibold fs-5">
                    <!--begin:Menu item-->
                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{active(route('dashboard.pos.index'))}}" href="{{route('dashboard.pos.index')}}">
                                <span class="menu-icon">
                                    <i class="ki-outline ki-home-2 fs-3x"></i>
                                </span>
                                <span class="menu-title mx-6 mt-1">Home</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link {{active(URL::to(locale().'/dashboard/Pos/orders/create'))}}" href="{{route('dashboard.pos.orders.create')}}">
                                <span class="menu-icon">
                                    <i class="ki-outline ki-basket-ok fs-3x"></i>
                                </span>
                                <span class="menu-title mx-6 mt-1">Create Order</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{active(URL::to(locale().'/dashboard/Pos/orders'))}} {{active(URL::to(locale().'/dashboard/Pos/orders/details*'))}}" href="{{route('dashboard.pos.orders.index')}}">
                            <span class="menu-icon">
                                <i class="ki-outline ki-cheque fs-3x"></i>
                            </span>
                            <span class="menu-title mx-6 mt-1">Orders</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{active(URL::to(locale().'/dashboard/Pos/customers*'))}}" href="{{route('dashboard.pos.customers.index')}}">
                                <span class="menu-icon">
                                    <i class="ki-outline ki-people fs-3x"></i>
                                </span>
                            <span class="menu-title mx-6 mt-1">Customers</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
{{--                    <!--begin:Menu item-->--}}
{{--                    <div class="menu-item">--}}
{{--                        <!--begin:Menu link-->--}}
{{--                        <a class="menu-link" href="#">--}}
{{--                                <span class="menu-icon">--}}
{{--                                    <i class="ki-outline ki-graph-up fs-3x"></i>--}}
{{--                                </span>--}}
{{--                            <span class="menu-title mx-6 mt-1">Reports</span>--}}
{{--                        </a>--}}
{{--                        <!--end:Menu link-->--}}
{{--                    </div>--}}
{{--                    <!--end:Menu item-->--}}
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link {{active(URL::to(locale().'/dashboard/Pos/pos-configs*'))}}" href="{{route('dashboard.pos.settings.index')}}">
                                <span class="menu-icon">
                                    <i class="ki-outline ki-setting-3 fs-3x"></i>
                                </span>
                            <span class="menu-title mx-6 mt-1">System Settings</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link" href="{{route('dashboard.home')}}">
                                <span class="menu-icon">
                                    <i class="ki-outline ki-exit-left fs-3x"></i>
                                </span>
                            <span class="menu-title mx-6 mt-1">Back To Dashboard</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                </div>
                <!--end::Menu-->
            </div>
            <!--end::Primary menu-->
        </div>
    </div>
</div>

