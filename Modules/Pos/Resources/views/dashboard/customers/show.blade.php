@extends('pos::dashboard.layouts.app')

@section('title' , __('apps::dashboard.navbar.pos_system') . ' -- '.'Customers')
@section('page_name' , 'Customer Details')


@section('content')
    <div class="card">
        <div class="card-header py-5">
            <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6 w-100">
                @include('pos::dashboard.customers.partials.tabs')
            </ul>

            <div class="tab-content w-100" id="myTabContent">
                <div class="tab-pane fade" id="kt_tab_pane_1" role="tabpanel">
                    @include('pos::dashboard.customers.partials.info')
                </div>
                <div class="tab-pane fade show active py-5" id="kt_tab_pane_2" role="tabpanel">
                    @include('pos::dashboard.customers.partials.orders')
                </div>
                <div class="tab-pane fade" id="kt_tab_pane_3" role="tabpanel">
                    @include('pos::dashboard.customers.partials.transactions')
                </div>
                <div class="tab-pane fade" id="kt_tab_pane_4" role="tabpanel">
                    @include('pos::dashboard.customers.partials.subscriptions')
                </div>
                <div class="tab-pane fade" id="kt_tab_pane_5" role="tabpanel">
                    @include('pos::dashboard.customers.partials.addresses')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
@endpush

@push('scripts')
    <script>
        "use strict";

        // On document ready
        KTUtil.onDOMContentLoaded(function () {

        });
    </script>
@endpush
