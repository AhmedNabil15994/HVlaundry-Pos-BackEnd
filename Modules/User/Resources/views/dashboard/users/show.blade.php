@extends('apps::dashboard.layouts.app')
@section('title', __('user::dashboard.users.show.title'))
@section('css')
    <style>
        .dataTables_wrapper .dt-buttons {
            float: {{ locale() == 'ar' ? 'right' : 'left' }} !important;
        }
        .mb-50{
            margin-bottom: 50px;
        }
    </style>

    <style type="text/css" media="print">
        @page {
            size: auto;
            margin: 0;
        }

        @media print {
            a[href]:after {
                content: none !important;
            }

            .contentPrint {
                width: 100%;
            }

            .no-print,
            .no-print * {
                display: none !important;
            }
        }
    </style>
@stop

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.home.title') }}</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="{{ url(route('dashboard.users.index')) }}">
                            {{ __('user::dashboard.users.index.title') }}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{ __('user::dashboard.users.show.title') }}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        @permission('statistics')
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 red" href="{{route('dashboard.completed_orders.index')}}">
                                <div class="visual">
                                    <i class="fa fa-bar-chart-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" id="count_orders" data-value="0">0</span>
                                    </div>
                                    <div class="desc">{{ __('apps::dashboard.home.statistics.comleted_orders') }}</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 green" href="{{route('dashboard.completed_orders.index')}}">
                                <div class="visual">
                                    <i class="fa fa-bar-chart-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" id="sum_total_orders" data-value="0">0</span> KWD
                                    </div>
                                    <div class="desc">{{ __('apps::dashboard.home.statistics.total_completed_orders') }}</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 yellow-lemon" href="#">
                                <div class="visual">
                                    <i class="fa fa-bar-chart-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="{{ number_format($user->subscriptions_balance, 3) }}">{{ number_format($user->subscriptions_balance, 3) }}</span> KWD
                                    </div>
                                    <div class="desc">{{ __('Your Balance') }}</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 yellow-gold" href="#">
                                <div class="visual">
                                    <i class="fa fa-bar-chart-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="{{ number_format(($user->loyalty_points_count ?? 0 ) * 10  / 1000,3) }}">{{ number_format(($user->loyalty_points_count ?? 0 ) * 10  / 1000,3) }}</span> KWD
                                    </div>
                                    <div class="desc">{{ __('Loyalty Points Balance') }}</div>
                                </div>
                            </a>
                        </div>
                        @endpermission
                    </div>
                    <div class="no-print">
                        <div class="tab-content">
                            <ul class="nav nav-tabs">
                                @permission('show_orders')
                                <li class="active">
                                    <a data-toggle="tab" href="#orders">{{ __('user::dashboard.users.create.form.orders') }}</a>
                                </li>
                                @endpermission
                                @permission('show_user_addresses')
                                <li class="">
                                    <a data-toggle="tab" href="#addresses">{{ __('user::dashboard.users.create.form.addresses') }}</a>
                                </li>
                                @endpermission
                                @permission('show_baqat_subscriptions')
                                <li class="">
                                    <a data-toggle="tab" href="#subscriptions">{{ __('user::dashboard.users.create.form.subscriptions') }}</a>
                                </li>
                                @endpermission
                                <li class="">
                                    <a data-toggle="tab" href="#general">{{ __('user::dashboard.users.create.form.general') }}</a>
                                </li>
                            </ul>
                            @permission('show_orders')
                            <div id="orders" class="tab-pane fade in active">
                                <div class="portlet-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="ordersDataTable">
                                            <thead>
                                            <tr>
                                                <th>
                                                    <a href="javascript:;" onclick="CheckAll()">
                                                        {{ __('apps::dashboard.general.select_all_btn') }}
                                                    </a>
                                                </th>
                                                <th>#</th>
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
                                        </table>
                                    </div>
                                    @include('order::dashboard.shared._bulk_order_actions', ['printPage' => 'orders'])
                                </div>
                            </div>
                            @endpermission

                            @permission('show_user_addresses')
                            <div id="addresses" class="tab-pane fade">
                                @permission('add_user_addresses')
                                <div class="table-toolbar">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="btn-group">
                                                <a class="btn sbold green" data-toggle="modal" href="#userCreateAddressModal"> {{ __('apps::dashboard.general.btn_add_address') }} </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endpermission

                                <div class="portlet-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="addressesDataTable">
                                            <thead>
                                            <tr>
                                                <th>
                                                    <a href="javascript:;" onclick="CheckAll()">
                                                        {{ __('apps::dashboard.general.select_all_btn') }}
                                                    </a>
                                                </th>
                                                <th>#</th>
                                                <th>{{ __('user::dashboard.users.datatable.address.state') }}</th>
                                                <th>{{ __('user::dashboard.users.datatable.address.username') }}</th>
                                                <th>{{ __('user::dashboard.users.datatable.address.email') }}</th>
                                                <th>{{ __('user::dashboard.users.datatable.address.mobile') }}</th>
                                                <th>{{ __('user::dashboard.users.datatable.address.block') }}</th>
                                                <th>{{ __('user::dashboard.users.datatable.address.building') }}</th>
                                                <th>{{ __('user::dashboard.users.datatable.created_at') }}</th>
                                                <th>{{ __('user::dashboard.users.datatable.options') }}</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <button type="submit" id="deleteChecked" class="btn red btn-sm"
                                                onclick="deleteAllChecked('{{ url(route('dashboard.user_addresses.deletes')) }}')">
                                            {{ __('apps::dashboard.datatable.delete_all_btn') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endpermission

                            @permission('show_baqat_subscriptions')
                            <div id="subscriptions" class="tab-pane fade">
                                <div class="portlet-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="subscriptionsDataTable">
                                            <thead>
                                            <tr>
                                                <th>
                                                    <a href="javascript:;" onclick="CheckAll()">
                                                        {{ __('apps::dashboard.general.select_all_btn') }}
                                                    </a>
                                                </th>
                                                <th>#</th>
                                                <th>{{__('baqat::dashboard.baqat_subscriptions.datatable.baqa')}}</th>
                                                <th>{{__('baqat::dashboard.baqat_subscriptions.datatable.price')}}</th>
                                                <th>{{__('baqat::dashboard.baqat_subscriptions.datatable.start_at')}}</th>
                                                <th>{{__('baqat::dashboard.baqat_subscriptions.datatable.end_at')}}</th>
                                                <th>{{__('baqat::dashboard.baqat_subscriptions.datatable.created_at')}}</th>
                                                <th>{{__('baqat::dashboard.baqat_subscriptions.datatable.options')}}</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <button type="submit" id="deleteChecked" class="btn red btn-sm"
                                                onclick="deleteAllChecked('{{ url(route('dashboard.baqat_subscriptions.deletes')) }}')">
                                            {{ __('apps::dashboard.datatable.delete_all_btn') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endpermission

                            <div id="general" class="tab-pane fade">
                                <div class="invoice-content-2 busered">
                                    <div class="row invoice-head">
                                        <div class="col-md-12 col-xs-12">
                                            <div class="row invoice-logo">
                                                <div class="col-xs-6">
                                                    @if ($user->image)
                                                        <img src="{{ url($user->image) }}" class="img-responsive"
                                                             style="width:20%" />
                                                    @endif
                                                    <span>
                                                        {{ $user->name }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-xs-6">
                                            <div class="company-address">
                                                <h6 class="uppercase">
                                                    #{{ $user['id'] }}
                                                </h6>
                                                <h6 class="uppercase">
                                                    {{ date('Y-m-d / H:i:s', strtotime($user->created_at)) }}</h6>

                                                <span class="bold">
                                                    {{ __('user::dashboard.users.datatable.mobile') }} :
                                                </span>
                                                @if ($user)
                                                    @if (locale() != 'ar')
                                                        {{ '+' . $user->calling_code . $user->mobile }}
                                                    @else
                                                        {{ $user->calling_code . $user->mobile . '+' }}
                                                    @endif
                                                @endif
                                                <br />
                                            </div>
                                        </div>

                                        <div class="row invoice-body">
                                            <div class="col-xs-12 table-responsive" style="margin-top: 20px">
                                                <table class="table table-bordered ">

                                                    <tbody>
                                                    <tr>
                                                        <td class="invoice-title uppercase" style="width: 200px">
                                                            {{ __('user::dashboard.users.datatable.name') }}
                                                        </td>
                                                        <td>
                                                            {{ $user->name ?? '-----' }}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="invoice-title uppercase" style="width: 200px">
                                                            {{ __('user::dashboard.users.datatable.email') }}
                                                        </td>
                                                        <td>
                                                            {{ $user->email ?? '-----' }}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="invoice-title uppercase" style="width: 200px">
                                                            {{ __('user::dashboard.users.datatable.is_verified') }}
                                                        </td>
                                                        <td>

                                                            @if ($user->is_verified == 1)
                                                                <span class="badge badge-success">
                                                                        {{ __('apps::dashboard.datatable.yes') }} </span>
                                                            @else
                                                                <span class="badge badge-danger">
                                                                        {{ __('apps::dashboard.datatable.no') }} </span>
                                                            @endif

                                                        </td>
                                                    </tr>

                                                    @if ($user->roles->count() > 0)
                                                        <tr>
                                                            <td class="invoice-title uppercase" style="width: 200px">
                                                                {{ __('user::dashboard.admins.update.form.roles') }}
                                                            </td>
                                                            <td>
                                                                @foreach ($user->roles as $role)
                                                                    <span class="badge badge-info">
                                                                            {{ $role->display_name }} </span>
                                                                @endforeach
                                                            </td>
                                                        </tr>

                                                    @endif

                                                    </tbody>
                                                    <thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-9 contentPrint">
                        @include('apps::dashboard.layouts._msg')
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-xs-4">
                        <a href="{{ url(route('dashboard.users.index')) }}" class="btn btn-lg red">
                            {{ __('apps::dashboard.general.back_btn') }}
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="userCreateAddressModal" tabindex="-1" role="userCreateAddressModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">{{ __('user::dashboard.users.create.form.address_details.titles.create') }}</h4>
                </div>
                @include('user::dashboard.addresses._create_modal')
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@stop


@section('scripts')

    @include('area::dashboard.shared._area_tree_js')
    @include('order::dashboard.shared._bulk_order_actions_js')

    <script>
        function tableGenerate(data = '') {

            var dataTable =
                $('#addressesDataTable').DataTable({
                    "createdRow": function(row, data, dataIndex) {
                        if (data["deleted_at"] != null) {
                            $(row).addClass('danger');
                        }
                    },
                    ajax: {
                        url: "{{ url(route('dashboard.user_addresses.datatable')) .'?user_id='. $user->id }}",
                        type: "GET",
                        data: {
                            req: data,
                        },
                    },
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/{{ ucfirst(LaravelLocalization::getCurrentLocaleName()) }}.json"
                    },
                    stateSave: true,
                    processing: true,
                    serverSide: true,
                    responsive: !0,
                    order: [
                        [1, "desc"]
                    ],
                    columns: [{
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
                    columnDefs: [{
                            targets: 0,
                            width: '30px',
                            className: 'dt-center',
                            orderable: false,
                            render: function(data, type, full, meta) {
                                return `<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                          <input type="checkbox" value="` + data + `" class="group-checkable" name="ids">
                                          <span></span>
                                        </label>
                                      `;
                            },
                        },
                        {
                            targets: -1,
                            responsivePriority: 1,
                            width: '17%',
                            title: '{{ __('user::dashboard.users.datatable.options') }}',
                            className: 'dt-center',
                            orderable: false,
                            render: function(data, type, full, meta) {

                                // Delete
                                var deleteUrl = '{{ route('dashboard.user_addresses.destroy', ':id') }}';
                                deleteUrl = deleteUrl.replace(':id', data);

                                return `
                                    @permission('delete_user_addresses')
                                        @csrf
                                        <a href="javascript:;" onclick="deleteRow('` + deleteUrl + `')" class="btn btn-sm red">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    @endpermission`;
                            },
                        },
                    ],
                    dom: 'Bfrtip',
                    lengthMenu: [
                        [10, 25, 50, 100, 500],
                        ['10', '25', '50', '100', '500']
                    ],
                    buttons: [{
                            extend: "pageLength",
                            className: "btn blue btn-outline",
                            text: "{{ __('apps::dashboard.datatable.pageLength') }}",
                            exportOptions: {
                                stripHtml: true,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: "print",
                            className: "btn blue btn-outline",
                            text: "{{ __('apps::dashboard.datatable.print') }}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: "pdf",
                            className: "btn blue btn-outline",
                            text: "{{ __('apps::dashboard.datatable.pdf') }}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: "excel",
                            className: "btn blue btn-outline ",
                            text: "{{ __('apps::dashboard.datatable.excel') }}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        },
                        {
                            extend: "colvis",
                            className: "btn blue btn-outline",
                            text: "{{ __('apps::dashboard.datatable.colvis') }}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        }
                    ]
                });
        }
        function ordersTableGenerate(data = '') {
            var dataTable =
                $('#ordersDataTable').DataTable({
                    'fnDrawCallback': function(data) {
                        $('#count_orders').attr('data-value',data.json.recordsTotal)
                        $('#sum_total_orders').attr('data-value',data.json.recordsTotalSum);
                        $('[data-counter="counterup"]').counterUp();
                    },
                    "createdRow": function(row, data, dataIndex) {
                        if (data["deleted_at"] != null) {
                            $(row).addClass('danger');
                        }

                        if (data["unread"] == false) {
                            $(row).addClass('danger');
                        }
                    },
                    ajax: {
                        url: "{{ url(route('dashboard.orders.datatable')) }}?user_id={{$user->id}}",
                        type: "GET",
                        data: {
                            req: data,
                        },
                    },
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/{{ ucfirst(LaravelLocalization::getCurrentLocaleName()) }}.json"
                    },
                    stateSave: true,
                    processing: true,
                    serverSide: true,
                    responsive: !0,
                    order: [
                        [1, "desc"]
                    ],
                    columns: [{
                        data: 'id',
                        className: 'dt-center'
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
                    columnDefs: [{
                        targets: 0,
                        width: '30px',
                        className: 'dt-center',
                        orderable: false,
                        render: function(data, type, full, meta) {
                            return `<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                          <input type="checkbox" value="` + data + `" class="group-checkable" name="ids">
                          <span></span>
                        </label>
                      `;
                        },
                    },
                        {
                            targets: -1,
                            responsivePriority: 1,
                            width: '13%',
                            title: '{{ __('order::dashboard.orders.datatable.options') }}',
                            className: 'dt-center',
                            orderable: false,
                            render: function(data, type, full, meta) {

                                // Show
                                var showUrl =
                                    "{{ route('dashboard.orders.show', [':id', 'current_orders']) }}";
                                showUrl = showUrl.replace(':id', data);

                                // Edit
                                var editUrl = '{{ route('dashboard.orders.edit', ':id') }}';
                                editUrl = editUrl.replace(':id', data);

                                // Delete
                                var deleteUrl = '{{ route('dashboard.orders.destroy', ':id') }}';
                                deleteUrl = deleteUrl.replace(':id', data);

                                var buttons = `
                                        @permission('show_orders')
                                            <a href="` + showUrl + `" class="btn btn-sm btn-warning" title="Show">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        @endpermission
                                        @permission('edit_orders')
                                        `;
                                var orderStatusArray = [8,5,9]; // is_ready | delivered | on_the_way
                                if (!orderStatusArray.includes(full.order_status_id)) {
                                    buttons += `<a href="` + editUrl + `" class="btn btn-sm blue" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>`;
                                }

                                `@endpermission
                                        @permission('delete_orders')
                                            @csrf<a href="javascript:;" onclick="deleteRow('` + deleteUrl + `')" class="btn btn-sm red">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        @endpermission`;

                                return buttons;

                            },
                        },
                    ],
                    dom: 'Bfrtip',
                    lengthMenu: [
                        [10, 25, 50, 100, 500],
                        ['10', '25', '50', '100', '500']
                    ],
                    buttons: [{
                        extend: "pageLength",
                        className: "btn blue btn-outline",
                        text: "{{ __('apps::dashboard.datatable.pageLength') }}",
                        exportOptions: {
                            stripHtml: false,
                            columns: ':visible',
                            columns: [1, 2, 3, 4, 5, 7, 8]
                        }
                    },
                        {
                            extend: "print",
                            className: "btn blue btn-outline",
                            text: "{{ __('apps::dashboard.datatable.print') }}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 7, 8]
                            }
                        },
                        {
                            extend: "pdf",
                            className: "btn blue btn-outline",
                            text: "{{ __('apps::dashboard.datatable.pdf') }}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 7, 8]
                            }
                        },
                        {
                            extend: "excel",
                            className: "btn blue btn-outline ",
                            text: "{{ __('apps::dashboard.datatable.excel') }}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 7, 8]
                            }
                        },
                        {
                            extend: "colvis",
                            className: "btn blue btn-outline",
                            text: "{{ __('apps::dashboard.datatable.colvis') }}",
                            exportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4, 5, 7, 8]
                            }
                        }
                    ]
                });
        }
        function subscriptionsTableGenerate(data = '') {

            var dataTable =
                $('#subscriptionsDataTable').DataTable({
                    "createdRow": function (row, data, dataIndex) {
                        if (data["deleted_at"] != null) {
                            $(row).addClass('danger');
                        }
                    },
                    ajax: {
                        url: "{{ url(route('dashboard.baqat_subscriptions.datatable')) }}?user_id={{$user->id}}",
                        type: "GET",
                        data: {
                            req: data,
                        },
                    },
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/{{ucfirst(LaravelLocalization::getCurrentLocaleName())}}.json"
                    },
                    stateSave: true,
                    processing: true,
                    serverSide: true,
                    responsive: !0,
                    order: [[1, "desc"]],
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
                            width: '30px',
                            className: 'dt-center',
                            orderable: false,
                            render: function (data, type, full, meta) {
                                return `<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                          <input type="checkbox" value="` + data + `" class="group-checkable" name="ids">
                          <span></span>
                        </label>
                      `;
                            },
                        },
                        {
                            targets: -1,
                            responsivePriority:1,
                            width: '13%',
                            title: '{{__('baqat::dashboard.baqat_subscriptions.datatable.options')}}',
                            className: 'dt-center',
                            orderable: false,
                            render: function (data, type, full, meta) {

                                // Show
                                var showUrl = "{{ route('dashboard.baqat_subscriptions.show', ':id') }}";
                                showUrl = showUrl.replace(':id', data);

                                // Edit
                                {{-- var editUrl = '{{ route("dashboard.baqat_subscriptions.edit", ":id") }}';
                                editUrl = editUrl.replace(':id', data); --}}

                                // Delete
                                var deleteUrl = '{{ route("dashboard.baqat_subscriptions.destroy", ":id") }}';
                                deleteUrl = deleteUrl.replace(':id', data);

                                return `
                                    @permission('show_baqat_subscriptions')
                                        <a href="` + showUrl + `" class="btn btn-sm btn-warning" title="Show">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    @endpermission
                                    {{-- @permission('edit_baqat_subscriptions')
                                        <a href="` + editUrl + `" class="btn btn-sm blue" title="Edit">
                                        <i class="fa fa-edit"></i>
                                        </a>
                                    @endpermission --}}

                                @permission('delete_baqat_subscriptions')
@csrf
                                <a href="javascript:;" onclick="deleteRow('` + deleteUrl + `')" class="btn btn-sm red">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    @endpermission`;
                            },
                        },
                    ],
                    dom: 'Bfrtip',
                    lengthMenu: [
                        [10, 25, 50, 100, 500],
                        ['10', '25', '50', '100', '500']
                    ],
                    buttons: [
                        {
                            extend: "pageLength",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.pageLength')}}",
                            eexportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4]
                            }
                        },
                        {
                            extend: "print",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.print')}}",
                            eexportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4]
                            }
                        },
                        {
                            extend: "pdf",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.pdf')}}",
                            eexportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4]
                            }
                        },
                        {
                            extend: "excel",
                            className: "btn blue btn-outline ",
                            text: "{{__('apps::dashboard.datatable.excel')}}",
                            eexportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4]
                            }
                        },
                        {
                            extend: "colvis",
                            className: "btn blue btn-outline",
                            text: "{{__('apps::dashboard.datatable.colvis')}}",
                            eexportOptions: {
                                stripHtml: false,
                                columns: ':visible',
                                columns: [1, 2, 3, 4]
                            }
                        }
                    ]
                });
        }

        jQuery(document).ready(function() {
            tableGenerate();
            ordersTableGenerate();
            subscriptionsTableGenerate();
        });
    </script>

@stop
