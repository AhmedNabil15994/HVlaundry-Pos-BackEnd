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
                            {{ __('coupon::dashboard.coupons.routes.index') }}
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
                    enctype="multipart/form-data" action="{{ route('dashboard.coupons.store') }}">
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

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('coupon::dashboard.coupons.form.discount_type') }}
                                            </label>
                                            <div class="col-md-9">
                                                <div class="mt-radio-inline">
                                                    <label class="mt-radio mt-radio-outline">
                                                        {{ __('coupon::dashboard.coupons.form.percentage') }}
                                                        <input type="radio" name="discount_type" value="percentage"
                                                            onclick="toggleCouponValueType('percentage')" checked>
                                                        <span></span>
                                                    </label>
                                                    <label class="mt-radio mt-radio-outline">
                                                        {{ __('coupon::dashboard.coupons.form.value') }}
                                                        <input type="radio" name="discount_type" value="value"
                                                            onclick="toggleCouponValueType('value')">
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group discount_type" id="value" style="display: none">
                                            <label class="col-md-2">
                                                {{ __('coupon::dashboard.coupons.form.discount_value') }}
                                                ( {{ __('apps::frontend.general.kwd') }} )
                                            </label>
                                            <div class="col-md-9">
                                                <input type="number" name="discount_value" class="form-control"
                                                    data-name="discount_value">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="discount_type" id="percentage">

                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{ __('coupon::dashboard.coupons.form.discount_percentage') }} %
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="number" min="0" max="100"
                                                        name="discount_percentage" class="form-control"
                                                        data-name="discount_percentage">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{ __('coupon::dashboard.coupons.form.max_discount_percentage_value') }}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="number" name="max_discount_percentage_value"
                                                        class="form-control" data-name="max_discount_percentage_value">
                                                    <div class="help-block"></div>
                                                </div>
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

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('coupon::dashboard.coupons.form.free_delivery') }}
                                            </label>
                                            <div class="col-md-9">
                                                <input type="checkbox" class="make-switch" id="free_delivery"
                                                    data-size="small" name="free_delivery">
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="tab-pane fade in" id="use">
                                    {{-- <h3 class="page-title">{{ __('coupon::dashboard.coupons.form.tabs.use') }}</h3> --}}
                                    <div class="col-md-10">


                                        {{-- <div class="form-group"> --}}
                                        {{-- <label class="col-md-2"> --}}
                                        {{-- {{__('coupon::dashboard.coupons.form.max_users')}} --}}
                                        {{-- </label> --}}
                                        {{-- <div class="col-md-9"> --}}
                                        {{-- <input type="number" name="max_users" class="form-control" data-name="max_users"> --}}
                                        {{-- <div class="help-block"></div> --}}
                                        {{-- </div> --}}
                                        {{-- </div> --}}

                                        {{-- <div class="form-group"> --}}
                                        {{-- <label class="col-md-2"> --}}
                                        {{-- {{__('coupon::dashboard.coupons.form.user_max_uses')}} --}}
                                        {{-- </label> --}}
                                        {{-- <div class="col-md-9"> --}}
                                        {{-- <input type="number" name="user_max_uses" class="form-control" data-name="user_max_uses"> --}}
                                        {{-- <div class="help-block"></div> --}}
                                        {{-- </div> --}}
                                        {{-- </div> --}}

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

                                        <div class="form-group">
                                            {{-- <label class="col-md-2">
                                                {{__('coupon::dashboard.coupons.form.tabs.custom')}}
                                            </label> --}}
                                            <div class="col-md-9">
                                                <div class="mt-radio-inline">
                                                    <label class="mt-radio mt-radio-outline">
                                                        {{ __('coupon::dashboard.coupons.form.all_products') }}
                                                        <input type="radio" name="coupon_flag" value=""
                                                            onclick="toggleCouponFlag('')" checked>
                                                        <span></span>
                                                    </label>

                                                    <label class="mt-radio mt-radio-outline">
                                                        {{ __('coupon::dashboard.coupons.form.categories') }}
                                                        <input type="radio" name="coupon_flag" value="categories"
                                                            onclick="toggleCouponFlag('categories')">
                                                        <span></span>
                                                    </label>
                                                    <label class="mt-radio mt-radio-outline">
                                                        {{ __('coupon::dashboard.coupons.form.products') }}
                                                        <input type="radio" name="coupon_flag" value="products"
                                                            onclick="toggleCouponFlag('products')">
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group" id="categoriesSection" style="display: none">
                                            <label class="col-md-2">
                                                {{ __('coupon::dashboard.coupons.form.categories') }}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="category_ids[]" multiple id="single"
                                                    class="form-control select2" data-name="category_ids[]">

                                                    @foreach ($mainCategories as $category)
                                                        <option value="{{ $category['id'] }}">
                                                            {{ $category->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <div class="form-group" id="productsSection" style="display: none">
                                            <label class="col-md-2">
                                                {{ __('coupon::dashboard.coupons.form.products') }}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="product_ids[]" multiple id="single"
                                                    class="form-control select2" data-name="product_ids[]">

                                                    @foreach ($products as $product)
                                                        <option value="{{ $product['id'] }}">
                                                            {{ $product->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>

                                        <hr>

                                        {{-- <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('coupon::dashboard.coupons.form.tabs.coupon_users_types') }}
                                            </label>
                                            <div class="col-md-9">
                                                <div class="mt-checkbox-inline">
                                                    <label class="mt-checkbox mt-checkbox-outline">
                                                        {{ __('coupon::dashboard.coupons.form.user_type.user') }}
                                                        <input type="checkbox" name="user_type[]" value="user"
                                                            id="userCouponType" checked>
                                                        <span></span>
                                                    </label>
                                                    <label class="mt-checkbox mt-checkbox-outline">
                                                        {{ __('coupon::dashboard.coupons.form.user_type.guest') }}
                                                        <input type="checkbox" name="user_type[]" value="guest" checked>
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div> --}}

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
                                            
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{ __('coupon::dashboard.coupons.form.users_count') }}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="number" min="1" name="users_count" class="form-control"
                                                        data-name="users_count">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{ __('coupon::dashboard.coupons.form.states') }}
                                            </label>
                                            <div class="col-md-9">
                                                <select name="states[]" multiple="multiple" class="form-control select2"
                                                    data-name="states[]" id="couponStatesSelect"
                                                    data-placeholder="{{ __('coupon::dashboard.coupons.form.all_states') }}">
                                                    @foreach ($activeCitiesWithStates as $city)
                                                        <optgroup label="{{ $city->title }}">
                                                            @foreach ($city->states as $state)
                                                                <option value="{{ $state['id'] }}">
                                                                    {{ $state->title }}
                                                                </option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                                <div class="help-block"></div>
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
                                    <a href="{{ url(route('dashboard.coupons.index')) }}" class="btn btn-lg red">
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
