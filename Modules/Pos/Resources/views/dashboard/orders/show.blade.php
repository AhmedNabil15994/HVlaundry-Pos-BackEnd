@extends('pos::dashboard.layouts.app')

@section('title' , __('apps::dashboard.navbar.pos_system') . ' -- '.'Customers')
@section('page_name' , 'Customer Details')


@section('content')
    <div class="card">
        <div class="card-header py-5">
            <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6 w-100">
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_1"><b>Info</b></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_2"><b>Orders</b></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_3"><b>Transactions</b></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_4"><b>Subscriptions</b></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_5"><b>Addresses</b></a>
                </li>
            </ul>

            <div class="tab-content w-100" id="myTabContent">
                <div class="tab-pane fade" id="kt_tab_pane_1" role="tabpanel">
                    ...
                </div>
                <div class="tab-pane fade show active py-5" id="kt_tab_pane_2" role="tabpanel">
                    <a href="#" data-target="{{ url(route('dashboard.orders.datatable')) }}?user_id={{$user->id}}" class="btn btn-success filter-orders">Active</a>
                    <a href="#" data-target="{{ url(route('dashboard.all_orders.datatable')) }}?user_id={{$user->id}}" class="btn btn-secondary filter-orders">History</a>

                    <div class="card mt-5 w-100">
                        <div class="card-header py-5">
                            <h3 class="card-title">All Active Orders</h3>
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Toolbar-->
                                <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
                                    <button type="button" class="btn btn-primary">
                                        <i class="ki-outline ki-plus-square fs-3"></i>
                                        Add Order
                                    </button>
                                    <!--end::Add customer-->
                                </div>
                                <!--end::Toolbar-->
                                <!--begin::Group actions-->
                                <div class="d-flex justify-content-end align-items-center d-none" data-kt-docs-table-toolbar="selected">
                                    <div class="fw-bold me-5"><span class="me-2" data-kt-docs-table-select="selected_count"></span>Selected</div>
                                    <button type="button" class="btn btn-danger" data-kt-docs-table-select="delete_selected">Delete Selected</button>
                                </div>
                                <!--end::Group actions-->
                            </div>
                            <!--end::Card toolbar-->
                            <div class="card-body">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_active_orders_table">
                                    <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="w-10px pe-2">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_active_orders_table .form-check-input" value="1" />
                                            </div>
                                        </th>
                                        <th>ID</th>
                                        <th>{{ __('order::dashboard.orders.datatable.subtotal') }}</th>
                                        <th>{{ __('order::dashboard.orders.datatable.shipping') }}</th>
                                        <th>{{ __('order::dashboard.orders.datatable.total') }}</th>
                                        <th>{{ __('order::dashboard.orders.datatable.status') }}</th>
                                        <th>{{ __('order::dashboard.orders.datatable.method') }}</th>
                                        <th>{{ __('order::dashboard.orders.datatable.state') }}</th>
                                        <th>{{ __('order::dashboard.orders.datatable.created_at') }}</th>
                                        <th>{{ __('order::dashboard.orders.datatable.options') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="kt_tab_pane_3" role="tabpanel">
                    <a href="#" data-target="{{ url(route('dashboard.transactions.datatable')) }}?user_id={{$user->id}}" class="btn btn-success filter-transactions">Orders Transactions</a>
                    <a href="#" data-target="{{ url(route('dashboard.transactions.subscriptions_datatable')) }}?user_id={{$user->id}}" class="btn btn-primary filter-transactions">Subscriptions Transactions</a>

                    <div class="card mt-5 w-100">
                        <div class="card-header py-5">
                            <h3 class="card-title">Transactions</h3>
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Toolbar-->
                                <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
                                </div>
                                <!--end::Toolbar-->
                                <!--begin::Group actions-->
                                <div class="d-flex justify-content-end align-items-center d-none" data-kt-docs-table-toolbar="selected">
                                    <div class="fw-bold me-5"><span class="me-2" data-kt-docs-table-select="selected_count"></span>Selected</div>
                                    <button type="button" class="btn btn-danger" data-kt-docs-table-select="delete_selected">Delete Selected</button>
                                </div>
                                <!--end::Group actions-->
                            </div>
                            <!--end::Card toolbar-->
                            <div class="card-body">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_transactions_table">
                                    <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="w-10px pe-2">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_active_orders_table .form-check-input" value="1" />
                                            </div>
                                        </th>
                                        <th>ID</th>
                                        <th>{{__('transaction::dashboard.transactions.datatable.payment_id')}}</th>
                                        <th>{{__('transaction::dashboard.transactions.datatable.method')}}</th>
                                        <th>{{__('transaction::dashboard.transactions.datatable.result')}}</th>
                                        <th>{{__('transaction::dashboard.transactions.datatable.track_id')}}</th>
                                        <th>{{__('transaction::dashboard.transactions.datatable.type')}}</th>
                                        <th>{{__('transaction::dashboard.transactions.datatable.ref')}}</th>
                                        <th>{{__('transaction::dashboard.transactions.datatable.created_at')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="kt_tab_pane_4" role="tabpanel">
                    <div class="card mt-5 w-100">
                        <div class="card-header py-5">
                            <h3 class="card-title w-100">Subscriptions</h3>
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Toolbar-->
                                <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
                                </div>
                                <!--end::Toolbar-->
                                <!--begin::Group actions-->
                                <div class="d-flex justify-content-end align-items-center d-none" data-kt-docs-table-toolbar="selected">
                                    <div class="fw-bold me-5"><span class="me-2" data-kt-docs-table-select="selected_count"></span>Selected</div>
                                    <button type="button" class="btn btn-danger" data-kt-docs-table-select="delete_selected">Delete Selected</button>
                                </div>
                                <!--end::Group actions-->
                            </div>
                            <!--end::Card toolbar-->
                            <div class="card-body">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_subscriptions_table">
                                    <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="w-10px pe-2">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_active_orders_table .form-check-input" value="1" />
                                            </div>
                                        </th>
                                        <th>ID</th>
                                        <th>{{__('baqat::dashboard.baqat_subscriptions.datatable.baqa')}}</th>
                                        <th>{{__('baqat::dashboard.baqat_subscriptions.datatable.price')}}</th>
                                        <th>{{__('baqat::dashboard.baqat_subscriptions.datatable.start_at')}}</th>
                                        <th>{{__('baqat::dashboard.baqat_subscriptions.datatable.end_at')}}</th>
                                        <th>{{__('baqat::dashboard.baqat_subscriptions.datatable.created_at')}}</th>
                                        <th>{{__('baqat::dashboard.baqat_subscriptions.datatable.options')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="kt_tab_pane_5" role="tabpanel">
                    <div class="card mt-5 w-100">
                        <div class="card-header py-5">
                            <h3 class="card-title w-50">Addresses</h3>
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar w-45">
                                <!--begin::Toolbar-->
                                <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
                                    <button type="button" class="btn btn-primary">
                                        <i class="ki-outline ki-plus-square fs-3"></i>
                                        Add Address
                                    </button>
                                </div>
                                <!--end::Toolbar-->
                                <!--begin::Group actions-->
                                <div class="d-flex justify-content-end align-items-center d-none" data-kt-docs-table-toolbar="selected">
                                    <div class="fw-bold me-5"><span class="me-2" data-kt-docs-table-select="selected_count"></span>Selected</div>
                                    <button type="button" class="btn btn-danger" data-kt-docs-table-select="delete_selected">Delete Selected</button>
                                </div>
                                <!--end::Group actions-->
                            </div>
                            <!--end::Card toolbar-->
                            <div class="card-body">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_addresses_table">
                                    <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="w-10px pe-2">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_active_orders_table .form-check-input" value="1" />
                                            </div>
                                        </th>
                                        <th>ID</th>
                                        <th>{{ __('user::dashboard.users.datatable.address.state') }}</th>
                                        <th>{{ __('user::dashboard.users.datatable.address.username') }}</th>
                                        <th>{{ __('user::dashboard.users.datatable.address.email') }}</th>
                                        <th class="text-center">{{ __('user::dashboard.users.datatable.address.mobile') }}</th>
                                        <th>{{ __('user::dashboard.users.datatable.address.block') }}</th>
                                        <th>{{ __('user::dashboard.users.datatable.address.building') }}</th>
                                        <th>{{ __('user::dashboard.users.datatable.created_at') }}</th>
                                        <th>{{ __('user::dashboard.users.datatable.options') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                    </div>
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
        let ordersTableUrl = "{{ url(route('dashboard.orders.datatable')) }}?user_id={{$user->id}}";
        let transactionsTableUrl = "{{ url(route('dashboard.transactions.datatable')) }}?user_id={{$user->id}}";
        let addressTableUrl = "{{ url(route('dashboard.user_addresses.datatable')) .'?user_id='. $user->id }}";
        let subscriptionTableUrl = "{{ url(route('dashboard.baqat_subscriptions.datatable')) }}?user_id={{$user->id}}";

        // Class definition
        var ordersData = function () {
            // Shared variables
            var table;
            var dt;
            var filterPayment;

            // Private functions
            var initDatatable = function () {
                dt = $("#kt_active_orders_table").DataTable({
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    stateSave: true,
                    select: {
                        style: 'multi',
                        selector: 'td:first-child input[type="checkbox"]',
                        className: 'row-selected'
                    },
                    ajax: {
                        url: ordersTableUrl,
                    },
                    columns: [
                        {
                            data: 'id',
                            className: 'dt-center',
                            orderable: false
                        },
                        {
                            data: 'id',
                            className: 'dt-center'
                        },
                        {
                            data: 'subtotal',
                            className: 'dt-center'
                        },
                        {
                            data: 'shipping',
                            className: 'dt-center'
                        },
                        {
                            data: 'total',
                            className: 'dt-center'
                        },
                        {
                            data: 'order_status_title',
                            className: 'dt-center'
                        },
                        {
                            data: 'transaction',
                            className: 'dt-center',
                            orderable: false
                        },
                        {
                            data: 'state',
                            className: 'dt-center',
                            orderable: false
                        },
                        {
                            data: 'created_at',
                            className: 'dt-center'
                        },
                        {
                            data: 'id'
                        },
                    ],
                    columnDefs: [
                        {
                            targets: 0,
                            orderable: false,
                            render: function (data) {
                                return `
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="${data}" />
                                    </div>`;
                            }
                        },
                        {
                            targets: -1,
                            data: null,
                            orderable: false,
                            className: 'text-end',
                            render: function (data, type, row) {
                                let showUrl = "{{route('dashboard.pos.orders.show',['id'=> ':id'])}}".replace(':id',data)
                                return `
                                    <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                                        Actions
                                        <span class="svg-icon fs-5 m-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                    <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="currentColor" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)"></path>
                                                </g>
                                            </svg>
                                        </span>
                                    </a>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="${showUrl}" class="menu-link px-3">View</a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-kt-docs-table-filter="delete_row">
                                                Delete
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                `;
                            },
                        },
                    ],
                    // Add data-filter attribute
                    createdRow: function (row, data, dataIndex) {
                        if (data["deleted_at"] != null) {
                            $(row).addClass('danger');
                        }
                    }
                });

                table = dt.$;

                // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
                dt.on('draw', function () {
                    initToggleToolbar();
                    toggleToolbars();
                    handleDeleteRows();
                    KTMenu.createInstances();
                });
            }

            // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
            var handleSearchDatatable = function () {
                const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
                filterSearch.addEventListener('keyup', function (e) {
                    dt.search(e.target.value).draw();
                });
            }

            // Delete customer
            var handleDeleteRows = () => {
                // Select all delete buttons
                const deleteButtons = document.querySelectorAll('[data-kt-docs-table-filter="delete_row"]');

                deleteButtons.forEach(d => {
                    // Delete button on click
                    d.addEventListener('click', function (e) {
                        e.preventDefault();

                        // Select parent row
                        const parent = e.target.closest('tr');

                        // Get customer name
                        const customerName = parent.querySelectorAll('td')[1].innerText;

                        // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                        Swal.fire({
                            text: "Are you sure you want to delete " + customerName + "?",
                            icon: "warning",
                            showCancelButton: true,
                            buttonsStyling: false,
                            confirmButtonText: "Yes, delete!",
                            cancelButtonText: "No, cancel",
                            customClass: {
                                confirmButton: "btn fw-bold btn-danger",
                                cancelButton: "btn fw-bold btn-active-light-primary"
                            }
                        }).then(function (result) {
                            if (result.value) {
                                // Simulate delete request -- for demo purpose only
                                Swal.fire({
                                    text: "Deleting " + customerName,
                                    icon: "info",
                                    buttonsStyling: false,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(function () {
                                    Swal.fire({
                                        text: "You have deleted " + customerName + "!.",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary",
                                        }
                                    }).then(function () {
                                        // delete row data from server and re-draw datatable
                                        dt.draw();
                                    });
                                });
                            } else if (result.dismiss === 'cancel') {
                                Swal.fire({
                                    text: customerName + " was not deleted.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                });
                            }
                        });
                    })
                });
            }

            // Init toggle toolbar
            var initToggleToolbar = function () {
                // Toggle selected action toolbar
                // Select all checkboxes
                const container = document.querySelector('#kt_active_orders_table');
                const checkboxes = container.querySelectorAll('[type="checkbox"]');

                // Select elements
                const deleteSelected = document.querySelector('[data-kt-docs-table-select="delete_selected"]');

                // Toggle delete selected toolbar
                checkboxes.forEach(c => {
                    // Checkbox on click event
                    c.addEventListener('click', function () {
                        setTimeout(function () {
                            toggleToolbars();
                        }, 50);
                    });
                });

                // Deleted selected rows
                deleteSelected.addEventListener('click', function () {
                    // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                    Swal.fire({
                        text: "Are you sure you want to delete selected orders?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        showLoaderOnConfirm: true,
                        confirmButtonText: "Yes, delete!",
                        cancelButtonText: "No, cancel",
                        customClass: {
                            confirmButton: "btn fw-bold btn-danger",
                            cancelButton: "btn fw-bold btn-active-light-primary"
                        },
                    }).then(function (result) {
                        if (result.value) {
                            // Simulate delete request -- for demo purpose only
                            Swal.fire({
                                text: "Deleting selected orders",
                                icon: "info",
                                buttonsStyling: false,
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function () {
                                Swal.fire({
                                    text: "You have deleted all selected orders!.",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                }).then(function () {
                                    // delete row data from server and re-draw datatable
                                    dt.draw();
                                });

                                // Remove header checked box
                                const headerCheckbox = container.querySelectorAll('[type="checkbox"]')[0];
                                headerCheckbox.checked = false;
                            });
                        } else if (result.dismiss === 'cancel') {
                            Swal.fire({
                                text: "Selected orders were not deleted.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                }
                            });
                        }
                    });
                });
            }

            // Toggle toolbars
            var toggleToolbars = function () {
                // Define variables
                const container = document.querySelector('#kt_active_orders_table');
                const toolbarBase = document.querySelector('[data-kt-docs-table-toolbar="base"]');
                const toolbarSelected = document.querySelector('[data-kt-docs-table-toolbar="selected"]');
                const selectedCount = document.querySelector('[data-kt-docs-table-select="selected_count"]');

                // Select refreshed checkbox DOM elements
                const allCheckboxes = container.querySelectorAll('tbody [type="checkbox"]');

                // Detect checkboxes state & count
                let checkedState = false;
                let count = 0;

                // Count checked boxes
                allCheckboxes.forEach(c => {
                    if (c.checked) {
                        checkedState = true;
                        count++;
                    }
                });

                // Toggle toolbars
                if (checkedState) {
                    selectedCount.innerHTML = count;
                    toolbarBase.classList.add('d-none');
                    toolbarSelected.classList.remove('d-none');
                } else {
                    toolbarBase.classList.remove('d-none');
                    toolbarSelected.classList.add('d-none');
                }
            }

            // Public methods
            return {
                init: function () {
                    initDatatable();
                    initToggleToolbar();
                    handleDeleteRows();
                }
            }
        }();

        var transactionsData = function () {
            // Shared variables
            var table1;
            var dt1;

            // Private functions
            var initTransactionDatatable = function () {
                dt1 = $("#kt_transactions_table").DataTable({
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    stateSave: true,
                    select: {
                        style: 'multi',
                        selector: 'td:first-child input[type="checkbox"]',
                        className: 'row-selected'
                    },
                    ajax: {
                        url: transactionsTableUrl,
                    },
                    columns: [
                        {data: 'id' 		 	        , className: 'dt-center'},
                        {data: 'id' 		 	        , className: 'dt-center'},
                        {data: 'payment_id' 			, className: 'dt-center'},
                        {data: 'method' 			    , className: 'dt-center'},
                        {data: 'result' 			    , className: 'dt-center'},
                        {data: 'track_id' 			  , className: 'dt-center'},
                        {data: 'type' 			      , className: 'dt-center' , orderable: false},
                        {data: 'ref' 			        , className: 'dt-center'},
                        {data: 'created_at' 		  , className: 'dt-center'},
                    ],
                    columnDefs: [
                        {
                            targets: 0,
                            orderable: false,
                            render: function (data) {
                                return `
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="${data}" />
                                    </div>`;
                            }
                        },
                    ],
                    // Add data-filter attribute
                    createdRow: function (row, data, dataIndex) {
                        if (data["deleted_at"] != null) {
                            $(row).addClass('danger');
                        }
                    }
                });

                table1 = dt1.$;

                // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
                dt1.on('draw', function () {
                    initTransactionsToggleToolbar();
                    toggleTransactionsToolbars();
                    handleTransactionsDeleteRows();
                    KTMenu.createInstances();
                });
            }

            // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
            var handleTransactionsSearchDatatable = function () {
                const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
                filterSearch.addEventListener('keyup', function (e) {
                    dt1.search(e.target.value).draw();
                });
            }

            // Delete customer
            var handleTransactionsDeleteRows = () => {
                // Select all delete buttons
                const deleteButtons = document.querySelectorAll('[data-kt-docs-table-filter="delete_row"]');

                deleteButtons.forEach(d => {
                    // Delete button on click
                    d.addEventListener('click', function (e) {
                        e.preventDefault();

                        // Select parent row
                        const parent = e.target.closest('tr');

                        // Get customer name
                        const customerName = parent.querySelectorAll('td')[1].innerText;

                        // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                        Swal.fire({
                            text: "Are you sure you want to delete " + customerName + "?",
                            icon: "warning",
                            showCancelButton: true,
                            buttonsStyling: false,
                            confirmButtonText: "Yes, delete!",
                            cancelButtonText: "No, cancel",
                            customClass: {
                                confirmButton: "btn fw-bold btn-danger",
                                cancelButton: "btn fw-bold btn-active-light-primary"
                            }
                        }).then(function (result) {
                            if (result.value) {
                                // Simulate delete request -- for demo purpose only
                                Swal.fire({
                                    text: "Deleting " + customerName,
                                    icon: "info",
                                    buttonsStyling: false,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(function () {
                                    Swal.fire({
                                        text: "You have deleted " + customerName + "!.",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary",
                                        }
                                    }).then(function () {
                                        // delete row data from server and re-draw datatable
                                        dt1.draw();
                                    });
                                });
                            } else if (result.dismiss === 'cancel') {
                                Swal.fire({
                                    text: customerName + " was not deleted.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                });
                            }
                        });
                    })
                });
            }

            // Init toggle toolbar
            var initTransactionsToggleToolbar = function () {
                // Toggle selected action toolbar
                // Select all checkboxes
                const container = document.querySelector('#kt_transactions_table');
                const checkboxes = container.querySelectorAll('[type="checkbox"]');

                // Select elements
                const deleteSelected = document.querySelector('[data-kt-docs-table-select="delete_selected"]');

                // Toggle delete selected toolbar
                checkboxes.forEach(c => {
                    // Checkbox on click event
                    c.addEventListener('click', function () {
                        setTimeout(function () {
                            toggleTransactionsToolbars();
                        }, 50);
                    });
                });

                // Deleted selected rows
                deleteSelected.addEventListener('click', function () {
                    // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                    Swal.fire({
                        text: "Are you sure you want to delete selected transactions?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        showLoaderOnConfirm: true,
                        confirmButtonText: "Yes, delete!",
                        cancelButtonText: "No, cancel",
                        customClass: {
                            confirmButton: "btn fw-bold btn-danger",
                            cancelButton: "btn fw-bold btn-active-light-primary"
                        },
                    }).then(function (result) {
                        if (result.value) {
                            // Simulate delete request -- for demo purpose only
                            Swal.fire({
                                text: "Deleting selected transactions",
                                icon: "info",
                                buttonsStyling: false,
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function () {
                                Swal.fire({
                                    text: "You have deleted all selected transactions!.",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                }).then(function () {
                                    // delete row data from server and re-draw datatable
                                    dt1.draw();
                                });

                                // Remove header checked box
                                const headerCheckbox = container.querySelectorAll('[type="checkbox"]')[0];
                                headerCheckbox.checked = false;
                            });
                        } else if (result.dismiss === 'cancel') {
                            Swal.fire({
                                text: "Selected transactions were not deleted.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                }
                            });
                        }
                    });
                });
            }

            // Toggle toolbars
            var toggleTransactionsToolbars = function () {
                // Define variables
                const container = document.querySelector('#kt_transactions_table');
                const toolbarBase = document.querySelector('[data-kt-docs-table-toolbar="base"]');
                const toolbarSelected = document.querySelector('[data-kt-docs-table-toolbar="selected"]');
                const selectedCount = document.querySelector('[data-kt-docs-table-select="selected_count"]');

                // Select refreshed checkbox DOM elements
                const allCheckboxes = container.querySelectorAll('tbody [type="checkbox"]');

                // Detect checkboxes state & count
                let checkedState = false;
                let count = 0;

                // Count checked boxes
                allCheckboxes.forEach(c => {
                    if (c.checked) {
                        checkedState = true;
                        count++;
                    }
                });

                // Toggle toolbars
                if (checkedState) {
                    selectedCount.innerHTML = count;
                    toolbarBase.classList.add('d-none');
                    toolbarSelected.classList.remove('d-none');
                } else {
                    toolbarBase.classList.remove('d-none');
                    toolbarSelected.classList.add('d-none');
                }
            }

            // Public methods
            return {
                init: function () {
                    initTransactionDatatable();
                    initTransactionsToggleToolbar();
                    handleTransactionsDeleteRows();
                }
            }
        }();

        var addressessData = function () {
            // Shared variables
            var table2;
            var dt2;

            // Private functions
            var initAddressesDatatable = function () {
                dt2 = $("#kt_addresses_table").DataTable({
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    stateSave: true,
                    select: {
                        style: 'multi',
                        selector: 'td:first-child input[type="checkbox"]',
                        className: 'row-selected'
                    },
                    ajax: {
                        url: addressTableUrl,
                    },
                    columns: [
                        {
                            data: 'id',
                            className: 'dt-center'
                        },
                        {
                            data: 'id',
                            className: 'dt-center'
                        },
                        {
                            data: 'state',
                            className: 'dt-center',
                            orderable: false,
                        },
                        {
                            data: 'username',
                            className: 'dt-center',
                            orderable: false,
                        },
                        {
                            data: 'email',
                            className: 'dt-center',
                            orderable: false,
                        },
                        {
                            data: 'mobile',
                            className: 'dt-center',
                            orderable: false,
                        },
                        {
                            data: 'block',
                            className: 'dt-center',
                            orderable: false,
                        },
                        {
                            data: 'building',
                            className: 'dt-center',
                            orderable: false,
                        },
                        {
                            data: 'created_at',
                            className: 'dt-center'
                        },
                        {
                            data: 'id'
                        },
                    ],
                    columnDefs: [
                        {
                            targets: 0,
                            orderable: false,
                            render: function (data) {
                                return `
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="${data}" />
                                    </div>`;
                            }
                        },
                        {
                            targets: -1,
                            data: null,
                            orderable: false,
                            className: 'text-end',
                            render: function (data, type, row) {
                                return `
                                    <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                                        Actions
                                        <span class="svg-icon fs-5 m-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                    <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="currentColor" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)"></path>
                                                </g>
                                            </svg>
                                        </span>
                                    </a>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">Edit</a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-kt-docs-table-filter="delete_row">
                                                Delete
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                `;
                            },
                        },

                    ],
                    // Add data-filter attribute
                    createdRow: function (row, data, dataIndex) {
                        if (data["deleted_at"] != null) {
                            $(row).addClass('danger');
                        }
                    }
                });

                table2 = dt2.$;

                // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
                dt2.on('draw', function () {
                    initAddressesToggleToolbar();
                    toggleAddressesToolbars();
                    handleAddressesDeleteRows();
                    KTMenu.createInstances();
                });
            }

            // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
            var handleAddressesSearchDatatable = function () {
                const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
                filterSearch.addEventListener('keyup', function (e) {
                    dt2.search(e.target.value).draw();
                });
            }

            // Delete customer
            var handleAddressesDeleteRows = () => {
                // Select all delete buttons
                const deleteButtons = document.querySelectorAll('[data-kt-docs-table-filter="delete_row"]');

                deleteButtons.forEach(d => {
                    // Delete button on click
                    d.addEventListener('click', function (e) {
                        e.preventDefault();

                        // Select parent row
                        const parent = e.target.closest('tr');

                        // Get customer name
                        const customerName = parent.querySelectorAll('td')[1].innerText;

                        // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                        Swal.fire({
                            text: "Are you sure you want to delete " + customerName + "?",
                            icon: "warning",
                            showCancelButton: true,
                            buttonsStyling: false,
                            confirmButtonText: "Yes, delete!",
                            cancelButtonText: "No, cancel",
                            customClass: {
                                confirmButton: "btn fw-bold btn-danger",
                                cancelButton: "btn fw-bold btn-active-light-primary"
                            }
                        }).then(function (result) {
                            if (result.value) {
                                // Simulate delete request -- for demo purpose only
                                Swal.fire({
                                    text: "Deleting " + customerName,
                                    icon: "info",
                                    buttonsStyling: false,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(function () {
                                    Swal.fire({
                                        text: "You have deleted " + customerName + "!.",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary",
                                        }
                                    }).then(function () {
                                        // delete row data from server and re-draw datatable
                                        dt2.draw();
                                    });
                                });
                            } else if (result.dismiss === 'cancel') {
                                Swal.fire({
                                    text: customerName + " was not deleted.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                });
                            }
                        });
                    })
                });
            }

            // Init toggle toolbar
            var initAddressesToggleToolbar = function () {
                // Toggle selected action toolbar
                // Select all checkboxes
                const container = document.querySelector('#kt_addresses_table');
                const checkboxes = container.querySelectorAll('[type="checkbox"]');

                // Select elements
                const deleteSelected = document.querySelector('[data-kt-docs-table-select="delete_selected"]');

                // Toggle delete selected toolbar
                checkboxes.forEach(c => {
                    // Checkbox on click event
                    c.addEventListener('click', function () {
                        setTimeout(function () {
                            toggleTransactionsToolbars();
                        }, 50);
                    });
                });

                // Deleted selected rows
                deleteSelected.addEventListener('click', function () {
                    // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                    Swal.fire({
                        text: "Are you sure you want to delete selected addresses?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        showLoaderOnConfirm: true,
                        confirmButtonText: "Yes, delete!",
                        cancelButtonText: "No, cancel",
                        customClass: {
                            confirmButton: "btn fw-bold btn-danger",
                            cancelButton: "btn fw-bold btn-active-light-primary"
                        },
                    }).then(function (result) {
                        if (result.value) {
                            // Simulate delete request -- for demo purpose only
                            Swal.fire({
                                text: "Deleting selected addresses",
                                icon: "info",
                                buttonsStyling: false,
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function () {
                                Swal.fire({
                                    text: "You have deleted all selected addresses!.",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                }).then(function () {
                                    // delete row data from server and re-draw datatable
                                    dt2.draw();
                                });

                                // Remove header checked box
                                const headerCheckbox = container.querySelectorAll('[type="checkbox"]')[0];
                                headerCheckbox.checked = false;
                            });
                        } else if (result.dismiss === 'cancel') {
                            Swal.fire({
                                text: "Selected addresses were not deleted.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                }
                            });
                        }
                    });
                });
            }

            // Toggle toolbars
            var toggleAddressesToolbars = function () {
                // Define variables
                const container = document.querySelector('#kt_addresses_table');
                const toolbarBase = document.querySelector('[data-kt-docs-table-toolbar="base"]');
                const toolbarSelected = document.querySelector('[data-kt-docs-table-toolbar="selected"]');
                const selectedCount = document.querySelector('[data-kt-docs-table-select="selected_count"]');

                // Select refreshed checkbox DOM elements
                const allCheckboxes = container.querySelectorAll('tbody [type="checkbox"]');

                // Detect checkboxes state & count
                let checkedState = false;
                let count = 0;

                // Count checked boxes
                allCheckboxes.forEach(c => {
                    if (c.checked) {
                        checkedState = true;
                        count++;
                    }
                });

                // Toggle toolbars
                if (checkedState) {
                    selectedCount.innerHTML = count;
                    toolbarBase.classList.add('d-none');
                    toolbarSelected.classList.remove('d-none');
                } else {
                    toolbarBase.classList.remove('d-none');
                    toolbarSelected.classList.add('d-none');
                }
            }

            // Public methods
            return {
                init: function () {
                    initAddressesDatatable();
                    initAddressesToggleToolbar();
                    handleAddressesDeleteRows();
                }
            }
        }();

        var subscriptionsData = function () {
            // Shared variables
            var table3;
            var dt3;

            // Private functions
            var initSubscriptionsDatatable = function () {
                dt3 = $("#kt_subscriptions_table").DataTable({
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    stateSave: true,
                    select: {
                        style: 'multi',
                        selector: 'td:first-child input[type="checkbox"]',
                        className: 'row-selected'
                    },
                    ajax: {
                        url: subscriptionTableUrl,
                    },
                    columns: [
                        {data: 'id', className: 'dt-center'},
                        {data: 'id', className: 'dt-center'},
                        {data: 'baqa', className: 'dt-center', orderable: false},
                        {data: 'price', className: 'dt-center', orderable: false},
                        {data: 'start_at', className: 'dt-center'},
                        {data: 'end_at', className: 'dt-center'},
                        {data: 'created_at', className: 'dt-center'},
                        {data: 'id'},
                    ],
                    columnDefs: [
                        {
                            targets: 0,
                            orderable: false,
                            render: function (data) {
                                return `
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="${data}" />
                                    </div>`;
                            }
                        },
                        {
                            targets: -1,
                            data: null,
                            orderable: false,
                            className: 'text-end',
                            render: function (data, type, row) {
                                return `
                                    <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                                        Actions
                                        <span class="svg-icon fs-5 m-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                    <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="currentColor" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)"></path>
                                                </g>
                                            </svg>
                                        </span>
                                    </a>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">View</a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-kt-docs-table-filter="delete_row">
                                                Delete
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                `;
                            },
                        },

                    ],
                    // Add data-filter attribute
                    createdRow: function (row, data, dataIndex) {
                        if (data["deleted_at"] != null) {
                            $(row).addClass('danger');
                        }
                    }
                });

                table3 = dt3.$;

                // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
                dt3.on('draw', function () {
                    initSubscriptionsToggleToolbar();
                    toggleSubscriptionsToolbars();
                    handleSubscriptionsDeleteRows();
                    KTMenu.createInstances();
                });
            }

            // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
            var handleSubscriptionsSearchDatatable = function () {
                const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
                filterSearch.addEventListener('keyup', function (e) {
                    dt3.search(e.target.value).draw();
                });
            }

            // Delete customer
            var handleSubscriptionsDeleteRows = () => {
                // Select all delete buttons
                const deleteButtons = document.querySelectorAll('[data-kt-docs-table-filter="delete_row"]');

                deleteButtons.forEach(d => {
                    // Delete button on click
                    d.addEventListener('click', function (e) {
                        e.preventDefault();

                        // Select parent row
                        const parent = e.target.closest('tr');

                        // Get customer name
                        const customerName = parent.querySelectorAll('td')[1].innerText;

                        // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                        Swal.fire({
                            text: "Are you sure you want to delete " + customerName + "?",
                            icon: "warning",
                            showCancelButton: true,
                            buttonsStyling: false,
                            confirmButtonText: "Yes, delete!",
                            cancelButtonText: "No, cancel",
                            customClass: {
                                confirmButton: "btn fw-bold btn-danger",
                                cancelButton: "btn fw-bold btn-active-light-primary"
                            }
                        }).then(function (result) {
                            if (result.value) {
                                // Simulate delete request -- for demo purpose only
                                Swal.fire({
                                    text: "Deleting " + customerName,
                                    icon: "info",
                                    buttonsStyling: false,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(function () {
                                    Swal.fire({
                                        text: "You have deleted " + customerName + "!.",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary",
                                        }
                                    }).then(function () {
                                        // delete row data from server and re-draw datatable
                                        dt3.draw();
                                    });
                                });
                            } else if (result.dismiss === 'cancel') {
                                Swal.fire({
                                    text: customerName + " was not deleted.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                });
                            }
                        });
                    })
                });
            }

            // Init toggle toolbar
            var initSubscriptionsToggleToolbar = function () {
                // Toggle selected action toolbar
                // Select all checkboxes
                const container = document.querySelector('#kt_subscriptions_table');
                const checkboxes = container.querySelectorAll('[type="checkbox"]');

                // Select elements
                const deleteSelected = document.querySelector('[data-kt-docs-table-select="delete_selected"]');

                // Toggle delete selected toolbar
                checkboxes.forEach(c => {
                    // Checkbox on click event
                    c.addEventListener('click', function () {
                        setTimeout(function () {
                            toggleSubscriptionsToolbars();
                        }, 50);
                    });
                });

                // Deleted selected rows
                deleteSelected.addEventListener('click', function () {
                    // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                    Swal.fire({
                        text: "Are you sure you want to delete selected subscriptions?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        showLoaderOnConfirm: true,
                        confirmButtonText: "Yes, delete!",
                        cancelButtonText: "No, cancel",
                        customClass: {
                            confirmButton: "btn fw-bold btn-danger",
                            cancelButton: "btn fw-bold btn-active-light-primary"
                        },
                    }).then(function (result) {
                        if (result.value) {
                            // Simulate delete request -- for demo purpose only
                            Swal.fire({
                                text: "Deleting selected subscriptions",
                                icon: "info",
                                buttonsStyling: false,
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function () {
                                Swal.fire({
                                    text: "You have deleted all selected subscriptions!.",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                }).then(function () {
                                    // delete row data from server and re-draw datatable
                                    dt3.draw();
                                });

                                // Remove header checked box
                                const headerCheckbox = container.querySelectorAll('[type="checkbox"]')[0];
                                headerCheckbox.checked = false;
                            });
                        } else if (result.dismiss === 'cancel') {
                            Swal.fire({
                                text: "Selected subscriptions were not deleted.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                }
                            });
                        }
                    });
                });
            }

            // Toggle toolbars
            var toggleSubscriptionsToolbars = function () {
                // Define variables
                const container = document.querySelector('#kt_subscriptions_table');
                const toolbarBase = document.querySelector('[data-kt-docs-table-toolbar="base"]');
                const toolbarSelected = document.querySelector('[data-kt-docs-table-toolbar="selected"]');
                const selectedCount = document.querySelector('[data-kt-docs-table-select="selected_count"]');

                // Select refreshed checkbox DOM elements
                const allCheckboxes = container.querySelectorAll('tbody [type="checkbox"]');

                // Detect checkboxes state & count
                let checkedState = false;
                let count = 0;

                // Count checked boxes
                allCheckboxes.forEach(c => {
                    if (c.checked) {
                        checkedState = true;
                        count++;
                    }
                });

                // Toggle toolbars
                if (checkedState) {
                    selectedCount.innerHTML = count;
                    toolbarBase.classList.add('d-none');
                    toolbarSelected.classList.remove('d-none');
                } else {
                    toolbarBase.classList.remove('d-none');
                    toolbarSelected.classList.add('d-none');
                }
            }

            // Public methods
            return {
                init: function () {
                    initSubscriptionsDatatable();
                    initSubscriptionsToggleToolbar();
                    handleSubscriptionsDeleteRows();
                }
            }
        }();

        // On document ready
        KTUtil.onDOMContentLoaded(function () {
            ordersData.init();
            transactionsData.init();
            addressessData.init();
            subscriptionsData.init();

            $('.filter-orders').on('click',function (e){
                $("#kt_active_orders_table").DataTable().destroy();
                ordersTableUrl = $(this).data('target');
                ordersData.init();
            });

            $('.filter-transactions').on('click',function (e){
                $("#kt_transactions_table").DataTable().destroy();
                transactionsTableUrl = $(this).data('target');
                transactionsData.init();
            });
        });
    </script>
@endpush
