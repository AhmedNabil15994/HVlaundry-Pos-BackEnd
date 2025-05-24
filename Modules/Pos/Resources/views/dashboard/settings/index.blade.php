@extends('pos::dashboard.layouts.app')

@section('title' , __('apps::dashboard.navbar.pos_system'))
@section('page_name' , 'System Settings')

@section('content')
    <div class="card mt-5 w-100">
        <div class="card-header py-5">
            <h3 class="card-title w-100">System Settings</h3>
            <div class="card-body">
                <form action="{{URL::current()}}" method="post">
                    @csrf
                    <div class="border border-dashed border-gray-300 rounded min-w-700px p-5">
                    <div class="d-flex flex-column col-12 mb-7 fv-row">
                        <label class="required fs-6 fw-semibold mb-2">{{ __('setting::dashboard.settings.form.fast_delivery_hours_preparation_time') }}</label>
                        <input type="number" min="0" class="form-control form-control-solid" placeholder="" name="other[working_times][delivery][preparation_time][fast_delivery]" value="{{ config('setting.other.working_times.delivery.preparation_time.fast_delivery') }}" />
                    </div>
                    <div class="d-flex flex-column col-12 mb-7 fv-row">
                        <label class="required fs-6 fw-semibold mb-2">{{ __('setting::dashboard.settings.form.usual_delivery_hours_preparation_time') }}</label>
                        <input type="number" min="0" class="form-control form-control-solid" placeholder="" name="other[working_times][delivery][preparation_time][usual_delivery]" value="{{ config('setting.other.working_times.delivery.preparation_time.usual_delivery') }}" />
                    </div>
                    <div class="row col-12 mb-7">
                        <h4 class="card-title w-100 mb-10">{{ __('setting::dashboard.settings.form.loyalty_points.title') }}</h4>
                        <div class="col-5 mb-7 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">{{ __('setting::dashboard.settings.form.loyalty_points.fils_count') }}</label>
                            <input type="number" min="0" class="form-control form-control-solid" placeholder="" name="other[loyalty_points][from][fils_count]" value="{{ config('setting.other.loyalty_points.from.fils_count') }}" />
                        </div>
                        <div class="col-2 mb-7 fv-row">
                            <div class="fs-6 fw-bold text-gray-700 text-center">==</div>
                        </div>
                        <div class="col-5 mb-7 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">{{ __('setting::dashboard.settings.form.loyalty_points.points_count') }}</label>
                            <input type="number" min="0" class="form-control form-control-solid" placeholder="" name="other[loyalty_points][from][points_count]" value="{{ config('setting.other.loyalty_points.from.points_count') }}" />
                        </div>
                    </div>
                    <div class="row col-12 mb-7">
                        <h4 class="card-title w-100 mb-10">{{ __('setting::dashboard.settings.form.loyalty_points.balance_title') }}</h4>
                        <div class="col-5 mb-7 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">{{ __('setting::dashboard.settings.form.loyalty_points.points_count') }}</label>
                            <input type="number" min="0" class="form-control form-control-solid" placeholder="" name="other[loyalty_points][to][points_count]" value="{{ config('setting.other.loyalty_points.to.points_count') }}" />
                        </div>
                        <div class="col-2 mb-7 fv-row">
                            <div class="fs-6 fw-bold text-gray-700 text-center">==</div>
                        </div>
                        <div class="col-5 mb-7 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">{{ __('setting::dashboard.settings.form.loyalty_points.fils_count') }}</label>
                            <input type="number" min="0" class="form-control form-control-solid" placeholder="" name="other[loyalty_points][to][fils_count]" value="{{ config('setting.other.loyalty_points.to.fils_count') }}" />
                        </div>
                    </div>
                    <div class="d-flex flex-column col-12 mb-7 fv-row">
                        <label class="required fs-6 fw-semibold mb-2">Order Default Customer</label>
                        <select name="order_default_customer_id" class="form-control" data-control="select2" data-placeholder="Select a Customer...">
                        @foreach($users as $user)
                            <option value="{{$user->id}}" {{$user->id == config('setting.order_default_customer_id') ? 'selected' : ''}}>{{$user->name . " \r\n " . $user->mobile}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="row col-12 " style="text-align: {{locale() == 'ar' ? 'left' : 'right'}}">
                        <div class="col-8"></div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-md">Update Settings</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection
