<a href="#" data-target="{{ url(route('dashboard.orders.datatable')) }}?user_id={{$user->id}}" class="btn btn-success filter-orders">Active</a>
<a href="#" data-target="{{ url(route('dashboard.all_orders.datatable')) }}?user_id={{$user->id}}" class="btn btn-secondary filter-orders">History</a>

<div class="card mt-5 w-100 orders">
    <div class="card-header py-5">
        <h3 class="card-title">All Active Orders</h3>
        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <!--begin::Toolbar-->
            <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
                <a href="{{route('dashboard.pos.orders.create')}}" class="btn btn-primary">
                    <i class="ki-outline ki-plus-square fs-3"></i>
                    Add Order
                </a>
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
    </div>
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

@push('extra_scripts')
    <script>
        "use strict";
        let ordersTableUrl = "{{ url(route('dashboard.orders.datatable')) }}?user_id={{$user->id}}";

        // Class definition
        var ordersData = function () {
            // Shared variables
            var table;
            var dt;

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
                            targets: 5,
                            orderable: false,
                            render: function (data,index,full) {
                                return `
                                    <span class="p-3 px-5 order_status" style="background: ${full.order_status_color};">${data}</span>`;
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
                                            <a href="#" class="menu-link px-3" data-toggle="${data}" data-kt-docs-table-filter="delete_row">
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
                const dataContainer = document.querySelector('.orders');
                const deleteButtons = dataContainer.querySelectorAll('[data-kt-docs-table-filter="delete_row"]');

                deleteButtons.forEach(d => {
                    // Delete button on click
                    d.addEventListener('click', function (e) {
                        e.preventDefault();

                        // Select parent row
                        const parent = e.target.closest('tr');
                        const item_id = $(this).data('toggle');

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
                                    $.ajax({
                                        type: "DELETE",
                                        url:"{{route('dashboard.orders.destroy',['id'=>':id'])}}".replace(':id',item_id),
                                        data:{'_token': $('meta[name="csrf-token"]').attr('content'),},
                                        success:function (data){
                                            if(data[0]){
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
                                            }else{
                                                errorMessage(data[1])
                                            }
                                        },
                                        error:function (error){
                                            errorMessage(error[1])
                                        }
                                    })
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
                const dataContainer = document.querySelector('.orders');
                const container = document.querySelector('#kt_active_orders_table');
                const checkboxes = dataContainer.querySelectorAll('[type="checkbox"]');

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
                    let selectedCheckboxes = container.querySelectorAll('[type="checkbox"]:checked');
                    let item_ids = [];
                    selectedCheckboxes.forEach(sc => {
                        item_ids.push(sc.value)
                    });

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
                                $.ajax({
                                    type: "GET",
                                    url:"{{route('dashboard.orders.deletes')}}",
                                    data:{
                                        '_token': $('meta[name="csrf-token"]').attr('content'),
                                        'ids': item_ids,
                                    },
                                    success:function (data){
                                        if(data[0]){
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
                                        }else{
                                            errorMessage(data[1])
                                        }
                                    },
                                    error:function (error){
                                        errorMessage(error[1])
                                    }
                                })

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
                const dataContainer = document.querySelector('.orders');
                const container = document.querySelector('#kt_active_orders_table');
                const toolbarBase = dataContainer.querySelector('[data-kt-docs-table-toolbar="base"]');
                const toolbarSelected = dataContainer.querySelector('[data-kt-docs-table-toolbar="selected"]');
                const selectedCount = dataContainer.querySelector('[data-kt-docs-table-select="selected_count"]');

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
                    // handleSearchDatatable();
                    initToggleToolbar();
                    handleDeleteRows();
                }
            }
        }();

        // On document ready
        KTUtil.onDOMContentLoaded(function () {
            ordersData.init();

            $('.filter-orders').on('click',function (e){
                $("#kt_active_orders_table").DataTable().destroy();
                ordersTableUrl = $(this).data('target');
                ordersData.init();
            });

        });
    </script>
@endpush
