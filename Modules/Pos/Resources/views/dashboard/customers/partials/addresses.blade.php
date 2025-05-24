<div class="card mt-5 w-100 addresses">
    <div class="card-header py-5">
        <h3 class="card-title w-50">Addresses</h3>
        <!--begin::Card toolbar-->
        <div class="card-toolbar w-45">
            <!--begin::Toolbar-->
            <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
                <button type="button" class="btn btn-primary" id="kt_addresses_toggle">
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
                            <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_addresses_table .form-check-input" value="1" />
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

@section('extra')
    @include('pos::dashboard.customers.partials.add_address')
@endsection

@push('extra_scripts')
    <script>
        "use strict";
        let addressTableUrl = "{{ url(route('dashboard.user_addresses.datatable')) .'?user_id='. $user->id }}";
        // Shared variables
        var table2;
        var dt2;

        var addressessData = function () {

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
                                            <a href="#" class="menu-link edit_address px-3" data-area="${data}">Edit</a>
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
                const dataContainer = document.querySelector('.addresses');
                const deleteButtons = dataContainer.querySelectorAll('[data-kt-docs-table-filter="delete_row"]');

                deleteButtons.forEach(d => {
                    // Delete button on click
                    d.addEventListener('click', function (e) {
                        e.preventDefault();

                        // Select parent row
                        const parent = e.target.closest('tr');
                        const item_id = $(this).data('toggle');
                        // Get customer name
                        const customerName = parent.querySelectorAll('td')[3].innerText + ' -- ' + parent.querySelectorAll('td')[2].innerText;

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
                                        url:"{{route('dashboard.user_addresses.destroy',['id'=>':id'])}}".replace(':id',item_id),
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
                                                    dt2.draw();
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
            var initAddressesToggleToolbar = function () {
                // Toggle selected action toolbar
                // Select all checkboxes
                const dataContainer = document.querySelector('.addresses');
                const container = document.querySelector('#kt_addresses_table');
                const checkboxes = container.querySelectorAll('[type="checkbox"]');

                // Select elements
                const deleteSelected = dataContainer.querySelector('[data-kt-docs-table-select="delete_selected"]');
                // Toggle delete selected toolbar
                checkboxes.forEach(c => {
                    // Checkbox on click event
                    c.addEventListener('click', function () {
                        setTimeout(function () {
                            toggleAddressesToolbars();
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
                                $.ajax({
                                    type: "GET",
                                    url:"{{route('dashboard.user_addresses.deletes')}}",
                                    data:{
                                        '_token': $('meta[name="csrf-token"]').attr('content'),
                                        'ids': item_ids,
                                    },
                                    success:function (data){
                                        if(data[0]){
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
                const dataContainer = document.querySelector('.addresses');
                const container = document.querySelector('#kt_addresses_table');
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
                    initAddressesDatatable();
                    // handleAddressesSearchDatatable();
                    initAddressesToggleToolbar();
                    handleAddressesDeleteRows();
                }
            }
        }();

        // On document ready
        KTUtil.onDOMContentLoaded(function () {
            addressessData.init();

            $(document).on('click','#kt_addresses_close',function (){
                $('#kt_addresses .card-footer span.title').html('Create Address')
                $('#kt_addresses .create_address').removeClass('update_address')
            });

            $(document).on('click','.create_address',function (e){
                e.preventDefault();e.stopPropagation();
                let type = $(this).hasClass('update_address') ? "PUT" : "POST";
                let url = $(this).hasClass('update_address') ?
                            "{{route('dashboard.user_addresses.update',['id'=>':id'])}}".replace(':id',$('#kt_addresses [name="address_id"]').val()) :
                                "{{route('dashboard.user_addresses.store')}}";

                $.ajax({
                    type: type,
                    url: url,
                    data:{
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'user_id': {{$user->id}},
                        'username': $('#kt_addresses input[name="name"]').val(),
                        'email': $('#kt_addresses input[name="email"]').val(),
                        'mobile': $('#kt_addresses input[name="mobile"]').val(),
                        'country_id': $('#kt_addresses select[name="country_id"]').val(),
                        'state': $('#kt_addresses select[name="state"]').val(),
                        'block': $('#kt_addresses input[name="block"]').val(),
                        'building': $('#kt_addresses input[name="building"]').val(),
                        'street': $('#kt_addresses input[name="street"]').val(),
                        'avenue': $('#kt_addresses input[name="avenue"]').val(),
                        'floor': $('#kt_addresses input[name="floor"]').val(),
                        'flat': $('#kt_addresses input[name="flat"]').val(),
                        'automated_number': $('#kt_addresses input[name="automated_number"]').val(),
                        'address': $('#kt_addresses [name="address"]').val(),
                        'address_id': $('#kt_addresses [name="address_id"]').val(),
                        'is_default': $('#kt_addresses input[name="is_default"]').is(":checked") ? 1 : 0,
                    },
                    success:function (data){
                        successMessage(data[1])
                        $('#kt_addresses_close').click()
                        clearFormData();
                        dt2.ajax.reload();
                    },
                    error:function (error){
                        $.each(error.responseJSON.errors ,function (index,item){
                            errorMessage(item[0])
                        })
                    }
                })
            });

            $(document).on('click','.edit_address',function (e){
                e.preventDefault();e.stopPropagation();
                let address_id = $(this).data('area');
                $.ajax({
                    type: "GET",
                    url: '{{route('dashboard.user_addresses.getOne',['id'=>':id'])}}'.replace(':id',address_id),
                    success:function (data){
                        if(data[0]){
                            let addressObj = data[1];
                            clearFormData();
                            $('#kt_addresses input[name="name"]').val(addressObj.username), $('#kt_addresses input[name="email"]').val(addressObj.email),
                                $('#kt_addresses input[name="mobile"]').val(addressObj.mobile), $('#kt_addresses select[name="country_id"]').val(addressObj.country.id).trigger('change'),
                                $('#kt_addresses select[name="state"]').val(addressObj.state_id).trigger('change'), $('#kt_addresses input[name="block"]').val(addressObj.block),
                                $('#kt_addresses input[name="building"]').val(addressObj.building), $('#kt_addresses input[name="street"]').val(addressObj.street),
                                $('#kt_addresses input[name="avenue"]').val(addressObj.avenue), $('#kt_addresses input[name="floor"]').val(addressObj.floor),
                                $('#kt_addresses input[name="flat"]').val(addressObj.flat), $('#kt_addresses input[name="automated_number"]').val(addressObj.automated_number),
                                $('#kt_addresses [name="address"]').val(addressObj.address), $('#kt_addresses input[name="is_default"]').prop('checked',addressObj.is_default),
                                $('#kt_addresses [name="address_id"]').val(addressObj.id);

                            $('#kt_addresses').addClass('drawer-on')
                            $('#kt_addresses .card-footer span.title').html('Update Address')
                            $('#kt_addresses .create_address').addClass('update_address')
                        }else{
                            errorMessage(data[1])
                        }
                    },
                    error:function (error){
                        errorMessage(error[1])
                    }
                })
            })

        });
    </script>
@endpush
