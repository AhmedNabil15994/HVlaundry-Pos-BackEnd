<a href="#" data-target="{{ url(route('dashboard.pos.transactions.datatable')) }}?user_id={{$user->id}}" class="btn btn-success filter-transactions">Orders Transactions</a>
<a href="#" data-target="{{ url(route('dashboard.pos.transactions.subscriptions_datatable')) }}?user_id={{$user->id}}" class="btn btn-primary filter-transactions">Subscriptions Transactions</a>

<div class="card mt-5 w-100 transactions">
    <div class="card-header py-5">
        <h3 class="card-title w-100">Transactions</h3>
        <!--begin::Card toolbar-->
        <div class="card-toolbar w-100">
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
                            <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_transactions_table .form-check-input" value="1" />
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

@push('extra_scripts')
    <script>
        "use strict";
        let transactionsTableUrl = "{{ url(route('dashboard.pos.transactions.datatable')) }}?user_id={{$user->id}}";

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
                const dataContainer = document.querySelector('.transactions');
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
                                        url:"{{route('dashboard.transactions.destroy',['id'=>':id'])}}".replace(':id',item_id),
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
                                                    dt1.draw();
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
            var initTransactionsToggleToolbar = function () {
                // Toggle selected action toolbar
                // Select all checkboxes
                const dataContainer = document.querySelector('.transactions');
                const container = document.querySelector('#kt_transactions_table');
                const checkboxes = container.querySelectorAll('[type="checkbox"]');

                // Select elements
                const deleteSelected = dataContainer.querySelector('[data-kt-docs-table-select="delete_selected"]');

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
                    let selectedCheckboxes = container.querySelectorAll('[type="checkbox"]:checked');
                    let item_ids = [];
                    selectedCheckboxes.forEach(sc => {
                        item_ids.push(sc.value)
                    });
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
                                $.ajax({
                                    type: "GET",
                                    url:"{{route('dashboard.transactions.deletes')}}",
                                    data:{
                                        '_token': $('meta[name="csrf-token"]').attr('content'),
                                        'ids': item_ids,
                                    },
                                    success:function (data){
                                        if(data[0]){
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
                                                dt1.draw();
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
                const dataContainer = document.querySelector('.transactions');
                const container = document.querySelector('#kt_transactions_table');
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
                    initTransactionDatatable();
                    // handleTransactionsSearchDatatable();
                    initTransactionsToggleToolbar();
                    handleTransactionsDeleteRows();
                }
            }
        }();
        // On document ready
        KTUtil.onDOMContentLoaded(function () {
            transactionsData.init();
            $('.filter-transactions').on('click',function (e){
                $("#kt_transactions_table").DataTable().destroy();
                transactionsTableUrl = $(this).data('target');
                transactionsData.init();
            });
        });
    </script>
@endpush
