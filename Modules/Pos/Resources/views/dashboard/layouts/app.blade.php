<!DOCTYPE html>

<html lang="{{locale()}}" dir="{{locale() == 'ar' ? 'rtl' : 'ltr'}}" direction="{{locale() == 'ar' ? 'rtl' : 'ltr'}}" style="direction:{{locale() == 'ar' ? 'rtl' : 'ltr'}};" data-bs-theme-mode="light">
    <head>
        <meta charset="utf-8" />
        <title>@yield('title', '--') || {{ config('app.name') }}</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        @include('pos::dashboard.layouts.head')
    </head>

    <!--begin::Body-->
    <body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="true"
          data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
          data-kt-app-sidebar-push-footer="true" data-kt-app-sidebar-minimize="on" class="app-default">
        <!--begin::Theme mode setup on page load-->
        <script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
        <!--end::Theme mode setup on page load-->

        <!--begin::App-->
        <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
            <!--begin::Page-->
            <div class="app-page flex-column flex-column-fluid" id="kt_app_page">

                <!--begin::Header-->
                @include('pos::dashboard.layouts.header')
                <!--end::Header-->

                <!--begin::Wrapper-->
                <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">

                    <!--begin::Sidebar-->
                    @include('pos::dashboard.layouts.sidebar')
                    <!--end::Sidebar-->

                    <!--begin::Main-->
                    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                        <!--begin::Content wrapper-->
                        <div class="d-flex flex-column flex-column-fluid">
                            <!--begin::Toolbar-->
                            @include('pos::dashboard.layouts.breadcrumb')
                            <!--end::Toolbar-->
                            <!--begin::Content-->
                            <div id="kt_app_content" class="app-content flex-column-fluid mt-10">
                                <!--begin::Content container-->
                                <div id="kt_app_content_container" class="app-container m-0">
                                    @yield('content')
                                </div>
                                <!--end::Content container-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Content wrapper-->

                        <!--begin::Footer-->
                        @include('pos::dashboard.layouts.footer')
                        <!--end::Footer-->
                    </div>
                    <!--end:::Main-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Page-->
        </div>
        <!--end::App-->

        @include('pos::dashboard.layouts.extra')
        @include('pos::dashboard.layouts.scripts')
    </body>
</html>
