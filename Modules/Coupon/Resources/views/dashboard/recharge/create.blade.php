@extends('apps::dashboard.layouts.app')
@section('title', __('coupon::dashboard.coupons.routes.create'))
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
                        <a href="{{ url(route('dashboard.coupons.index')) }}">
                            {{ __('coupon::dashboard.coupons.routes.recharge_coupons') }}
                        </a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">{{ __('coupon::dashboard.coupons.routes.create') }}</a>
                    </li>
                </ul>
            </div>

            <h1 class="page-title"></h1>

            <div class="row">
                <form id="form" role="form" class="form-horizontal form-row-seperated" method="post"
                    enctype="multipart/form-data" action="{{ route('dashboard.recharge_coupons.store') }}">
                    @csrf
                    <div class="col-md-12">

                        {{-- RIGHT SIDE --}}
                        <div class="col-md-3">
                            <div class="panel-group accordion scrollable" id="accordion2">
                                <div class="panel panel-default">
                                    {{-- <div class="panel-heading">
                                        <h4 class="panel-title"><a class="accordion-toggle"></a></h4>
                                    </div> --}}
                                    <div id="collapse_2_1" class="panel-collapse in">
                                        <div class="panel-body">
                                            <ul class="nav nav-pills nav-stacked">
                                                <li class="active">
                                                    <a href="#global_setting" data-toggle="tab">
                                                        {{ __('coupon::dashboard.coupons.form.tabs.general') }}
                                                    </a>
                                                </li>

                                                <li class="">
                                                    <a href="#use" data-toggle="tab">
                                                        {{ __('coupon::dashboard.coupons.form.tabs.use') }}
                                                    </a>
                                                </li>

                                                <li class="">
                                                    <a href="#custom" data-toggle="tab">
                                                        {{ __('coupon::dashboard.coupons.form.tabs.custom') }}
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- PAGE CONTENT --}}
                        <div class="col-md-9">
                            <div class="tab-content">

                                {{-- CREATE FORM --}}

                                <div class="tab-pane active fade in" id="global_setting">
                                    {{-- <h3 class="page-title">{{__('coupon::dashboard.coupons.form.tabs.general')}}</h3> --}}
                                    <div class="col-md-10">

                                        <div>
                                            <div class="tabbable">
                                                <ul class="nav nav-tabs bg-slate nav-tabs-component">
                                                    @foreach (config('translatable.locales') as $code)
                                                        <li class=" @if ($code == app()->getLocale()) active @endif">
                                                            <a href="#colored-rounded-tab-seo-{{ $code }}"
                                                                data-toggle="tab" aria-expanded="false">
                                                                {{ __('apps::dashboard.locale.' . $code) }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>

                                            <div class="tab-content">
                                                @foreach (config('translatable.locales') as $code)
                                                    <div class="tab-pane @if ($code == app()->getLocale()) active @endif"
                                                        id="colored-rounded-tab-seo-{{ $code }}">
                                                        <div class="form-group">
                                                            <label class="col-md-2">
                                                                {{ __('coupon::dashboard.coupons.form.title') }} -
                                                                {{ $code }}
                                                            </label>
                                                            <div class="col-md-9">
                                                                <input type="text" name="title[{{ $code }}]"
                                                                    class="form-control"
                                                                    data-name="title.{{ $code }}">
                                                                <div class="help-block"></div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                @endforeach
                                            </div>
                                            <hr>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('coupon::dashboard.coupons.form.code') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="text" name="code" class="form-control" data-name="code">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group balance" id="value">
                                            <label class="col-md-2">
                                                {{ __('coupon::dashboard.coupons.datatable.balance') }}
                                                ( {{ __('apps::frontend.general.kwd') }} )
                                            </label>
                                            <div class="col-md-9">
                                                <input type="number" name="balance" class="form-control"
                                                    data-name="balance">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('coupon::dashboard.coupons.form.status') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="test"
                                                    data-size="small" name="status">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade in" id="use">
                                    {{-- <h3 class="page-title">{{ __('coupon::dashboard.coupons.form.tabs.use') }}</h3> --}}
                                    <div class="col-md-10">

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('coupon::dashboard.coupons.form.start_at') }}
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group input-medium date time date-picker"
                                                    data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                    <input type="text" id="offer-form" class="form-control"
                                                        name="start_at" data-name="start_at">
                                                    <span class="input-group-btn">
                                                        <button class="btn default" type="button">
                                                            <i class="fa fa-calendar"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('coupon::dashboard.coupons.form.expired_at') }}
                                            </label>
                                            <div class="col-md-9">
                                                <div class="input-group input-medium date time date-picker"
                                                    data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                                    <input type="text" id="offer-form" class="form-control"
                                                        name="expired_at" data-name="expired_at">
                                                    <span class="input-group-btn">
                                                        <button class="btn default" type="button">
                                                            <i class="fa fa-calendar"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                                <div class="tab-pane fade in" id="custom">
                                    {{-- <h3 class="page-title">{{ __('coupon::dashboard.coupons.form.tabs.custom') }}</h3> --}}
                                    <div class="col-md-10">
                                        <div id="couponUsersSection">
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{ __('coupon::dashboard.coupons.form.users') }}
                                                    <i class="fa fa-question-circle tooltips"
                                                        data-original-title="{{ __('coupon::dashboard.coupons.form.coupon_users_hint') }}"></i>
                                                </label>
                                                <div class="col-md-9">
                                                    <select name="user_ids[]" multiple="multiple"
                                                        class="form-control select2 coupon-users-select"
                                                        data-name="user_ids[]" id="couponUsersSelect"
                                                        data-placeholder="{{ __('coupon::dashboard.coupons.form.all_users') }}">
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user['id'] }}">
                                                                {{ $user->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{ __('coupon::dashboard.coupons.form.user_max_uses') }}
                                                    <i class="fa fa-question-circle tooltips"
                                                        data-original-title="{{ __('coupon::dashboard.coupons.form.tooltips.user_max_uses_tooltip') }}"></i>
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="number" name="user_max_uses" class="form-control"
                                                        data-name="user_max_uses">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                {{-- END CREATE FORM --}}
                            </div>
                        </div>

                        {{-- PAGE ACTION --}}
                        <div class="col-md-12">
                            <div class="form-actions">
                                @include('apps::dashboard.layouts._ajax-msg')
                                <div class="form-group">
                                    <button type="submit" id="submit" class="btn btn-lg blue">
                                        {{ __('apps::dashboard.general.add_btn') }}
                                    </button>
                                    <a href="{{ url(route('dashboard.recharge_coupons.index')) }}" class="btn btn-lg red">
                                        {{ __('apps::dashboard.general.back_btn') }}
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@stop


@section('scripts')

    <script>
        $(function() {

            {{-- $("#couponUsersSelect").select2({
                placeholder: "{{ __('coupon::dashboard.coupons.form.select2_coupon_users_placeholder') }}",
            }); --}}

        });

        function toggleCouponValueType(type) {
            if (type == 'percentage') {
                $('#percentage').show();
                $('#value').hide();
            } else {
                $('#value').show();
                $('#percentage').hide();
            }
        }

        function toggleCouponFlag(flag) {
            switch (flag) {
                case 'vendors':
                    $('#categoriesSection').hide();
                    $('#productsSection').hide();
                    break;

                case 'categories':
                    $('#categoriesSection').show();
                    $('#productsSection').hide();
                    break;

                case 'products':
                    $('#categoriesSection').hide();
                    $('#productsSection').show();
                    break;

                case '':
                    $('#categoriesSection').hide();
                    $('#productsSection').hide();
                    break;

                default:
                    break;
            }
        }

        $("#userCouponType").change(function() {
            if (this.checked) {
                $('#couponUsersSection').show();
            } else {
                $('#couponUsersSection').hide();
            }
        });
    </script>

@endsection
