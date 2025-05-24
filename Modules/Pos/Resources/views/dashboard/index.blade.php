@extends('pos::dashboard.layouts.app')

@section('title' , __('apps::dashboard.navbar.pos_system'))
@section('page_name' , 'Home')

@section('content')
    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 mb-10">
        {{getTimeGreeting()}} {{auth()->user()->name}}
        <!--begin::Description-->
        <span class="page-desc text-muted fs-7 fw-semibold"></span>
        <!--end::Description-->
    </h1>

    <!--begin::Row-->
    <div class="row gx-5 gx-xl-10 mb-xl-10">
        <!--begin::Col-->
        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-10">
            <div class="row">
                <div class="col-6">
                    <div class="card mb-5 mb-xl-10">
                        <div class="card-header pt-5 border-0">
                            <div class="card-title d-flex flex-column">
                                <div class="d-flex align-items-center">
                                    <span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">{{$pickUpOrders ?? 0}}</span>
                                </div>
                                <span class="text-gray-500 pt-1 fw-semibold fs-6">Pickup Orders</span>
                            </div>
                        </div>
                        <div class="card-body d-flex align-items-end px-0 pb-0">
                            <div id="kt_card_widget_12_chart" class="w-100" style="height: 80px"></div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card mb-5 mb-xl-10">
                        <div class="card-header pt-5 border-0">
                            <div class="card-title d-flex flex-column">
                                <div class="d-flex align-items-center">
                                    <span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">{{$deliveryOrders ?? 0}}</span>
                                </div>
                                <span class="text-gray-500 pt-1 fw-semibold fs-6">Delivery Orders</span>
                            </div>
                        </div>
                        <div class="card-body d-flex align-items-end px-0 pb-0">
                            <div id="kt_card_widget_8_chart" class="w-100" style="height: 80px"></div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card mb-5 mb-xl-10">
                        <div class="card-header pt-5 border-0">
                            <div class="card-title d-flex flex-column">
                                <div class="d-flex align-items-center">
                                    <span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">{{$unPaidOrders ?? 0}}</span>
                                </div>
                                <span class="text-gray-500 pt-1 fw-semibold fs-6">UnPaid Orders</span>
                            </div>
                        </div>
                        <div class="card-body d-flex align-items-end px-0 pb-0">
                            <div id="kt_card_widget_9_chart" class="w-100" style="height: 80px"></div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card mb-xl-10">
                        <div class="card-header pt-5 border-0">
                            <div class="card-title d-flex flex-column">
                                <div class="d-flex align-items-center">
                                    <span class="fs-4 fw-semibold text-gray-500 me-1 align-self-start">{{__('KD')}}</span>
                                    <span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">{{$total ?? 0}}</span>
                                </div>
                                <span class="text-gray-500 pt-1 fw-semibold fs-6">Total Revenue</span>
                            </div>
                        </div>
                        <div class="card-body d-flex align-items-end px-0 pb-0">
                            <div id="kt_card_widget_6_chart" class="w-100" style="height: 95px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--begin::Col-->
        <div class="col-lg-12 col-xl-12 col-xxl-6 mb-5 mb-xl-0">
            <!--begin::Chart widget 3-->
            <div class="card card-flush overflow-hidden h-md-100">
                <!--begin::Header-->
                <div class="card-header py-5">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-gray-900">Revenue Monthly</span>
                    </h3>
                    <!--end::Title-->
                </div>
                <!--end::Header-->
                <!--begin::Card body-->
                <div class="card-body d-flex justify-content-between flex-column pb-1 px-0">
                    <!--begin::Statistics-->
                    <div class="px-9 mb-5">
                        <!--begin::Statistics-->
                        <div class="d-flex mb-2">
                            <span class="fs-4 fw-semibold text-gray-500 me-1">{{__('KD')}}</span>
                            <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">{{$totalThisMonth ?? 0}}</span>
                        </div>
                        <span class="text-gray-500 pt-1 fw-semibold fs-6">This Month</span>
                        <!--end::Statistics-->
                    </div>
                    <!--end::Statistics-->
                    <!--begin::Chart-->
                    <div id="kt_charts_widget_3100" class="min-h-auto ps-4 pe-6" style="height: 300px"></div>
                    <!--end::Chart-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Chart widget 3-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
@endsection

@push('scripts')
    <script>
        KTUtil.onDOMContentLoaded(function () {
            var labels = {!!$monthlyOrders['orders_dates'] !!};
            var count = {!!$monthlyOrders['profits'] !!};

            var e = document.getElementById("kt_charts_widget_3100");
            if (e) {
                var t = { self: null, rendered: !1 },
                    a = function () {
                        parseInt(KTUtil.css(e, "height"));
                        var a = KTUtil.getCssVariableValue("--bs-gray-500"),
                            o = KTUtil.getCssVariableValue("--bs-gray-200"),
                            r = KTUtil.getCssVariableValue("--bs-info"),
                            s = {
                                series: [{ name: "Total Revenue", data: count }],
                                chart: { fontFamily: "inherit", type: "area", height: 350, toolbar: { show: !1 } },
                                plotOptions: {},
                                legend: { show: !1 },
                                dataLabels: { enabled: !1 },
                                fill: { type: "solid", opacity: 1 },
                                stroke: { curve: "smooth", show: !0, width: 3, colors: [r] },
                                xaxis: {
                                    categories: labels,
                                    axisBorder: { show: !1 },
                                    axisTicks: { show: !1 },
                                    labels: { style: { colors: a, fontSize: "12px" } },
                                    crosshairs: { position: "front", stroke: { color: r, width: 1, dashArray: 3 } },
                                    tooltip: { enabled: !0, formatter: void 0, offsetY: 0, style: { fontSize: "12px" } },
                                },
                                yaxis: { labels: { style: { colors: a, fontSize: "12px" } } },
                                states: { normal: { filter: { type: "none", value: 0 } }, hover: { filter: { type: "none", value: 0 } }, active: { allowMultipleDataPointsSelection: !1, filter: { type: "none", value: 0 } } },
                                tooltip: {
                                    style: { fontSize: "12px" },
                                    y: {
                                        formatter: function (e) {
                                            return  e + "  {{__('KD')}}";
                                        },
                                    },
                                },
                                colors: [KTUtil.getCssVariableValue("--bs-info-light")],
                                grid: { borderColor: o, strokeDashArray: 4, yaxis: { lines: { show: !0 } } },
                                markers: { strokeColor: r, strokeWidth: 3 },
                            };
                        (t.self = new ApexCharts(e, s)), t.self.render(), (t.rendered = !0);
                    };
                a()
            }
        });
    </script>
@endpush
