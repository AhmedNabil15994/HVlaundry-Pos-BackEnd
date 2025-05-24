<div class="row mb-5">
    <h2 class="text-gray-500 my-5"> Customer Stats</h2>
    <div class="col-4">
        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
            <!--begin::Number-->
            <div class="d-flex align-items-center">
                <i class="ki-outline ki-bill fs-3x text-dark me-2"></i>
                <div class="fs-2 fw-bold counted" data-kt-countup="true"
                     data-kt-countup-value="{{$user->successOrders()->sum('total') ?? 0}}" data-kt-countup-prefix="{{__('KD')}}" data-kt-initialized="1">{{$user->successOrders()->sum('total') ?? '0.000'}} {{__('KD')}}</div>
            </div>
            <!--end::Number-->
            <!--begin::Label-->
            <div class="fw-semibold fs-4 text-gray-500 mx-12">Expenses</div>
            <!--end::Label-->
        </div>
    </div>
    <div class="col-4">
        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
            <!--begin::Number-->
            <div class="d-flex align-items-center">
                <i class="ki-outline ki-cheque fs-3x text-dark me-2"></i>
                <div class="fs-2 fw-bold counted" data-kt-countup="true"
                     data-kt-countup-value="{{$user->orders()->count() ?? 0}}" data-kt-initialized="1">{{$user->orders()->count() ?? 0}}</div>
            </div>
            <!--end::Number-->
            <!--begin::Label-->
            <div class="fw-semibold fs-4 text-gray-500 mx-12">Total Orders</div>
            <!--end::Label-->
        </div>
    </div>
    <div class="col-4">
        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
            <!--begin::Number-->
            <div class="d-flex align-items-center">
                <i class="ki-outline ki-time fs-3x text-dark me-2"></i>
                <div class="fs-2 fw-bold counted" data-kt-countup="false" data-kt-initialized="1">{{$user->successOrders()->latest('id')->first() ? date('d M Y',strtotime($user->successOrders()->latest('id')->first()->created_at)) : '-----'}}</div>
            </div>
            <!--end::Number-->
            <!--begin::Label-->
            <div class="fw-semibold fs-4 text-gray-500 mx-12">Last Order Date</div>
            <!--end::Label-->
        </div>
    </div>
</div>
<div class="row mb-5">
    <h2 class="text-gray-500 my-5"> Customer Wallet</h2>
    <div class="col-6">
        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
            <!--begin::Number-->
            <div class="d-flex align-items-center">
                <i class="ki-outline ki-wallet fs-3x text-dark me-2"></i>
                <div class="fs-2 fw-bold counted" data-kt-countup="true"
                     data-kt-countup-value="{{$user->subscriptions_balance}}" data-kt-countup-prefix="{{__('KD')}}" data-kt-initialized="1">{{$user->subscriptions_balance}} {{__('KD')}}</div>
            </div>
            <!--end::Number-->
            <!--begin::Label-->
            <div class="fw-semibold fs-4 text-gray-500 mx-12">Subscription Balance</div>
            <!--end::Label-->
        </div>
    </div>
    <div class="col-6">
        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
            <!--begin::Number-->
            <div class="d-flex align-items-center">
                <i class="ki-outline ki-ocean fs-3x text-dark me-2"></i>
                <div class="fs-2 fw-bold counted" data-kt-countup="true"
                     data-kt-countup-value="{{$user->loyalty_points_count}}" data-kt-initialized="1">{{$user->loyalty_points_count}}</div>
            </div>
            <!--end::Number-->
            <!--begin::Label-->
            <div class="fw-semibold fs-4 text-gray-500 mx-12">Loyalty Points</div>
            <!--end::Label-->
        </div>
    </div>

</div>
<div class="row mx-0 col-8">
    <h2 class="text-gray-500 my-5 px-0"> Customer Details</h2>
    <div class="border border-dashed border-gray-300 rounded p-5 row mx-0">
        <div class="row">
            <div class="col-9">
                <h4 class="text-gray-900 my-5 mb-10"><i class="ki-outline ki-user-square fs-2 text-dark me-2"></i> Basic Info</h4>
            </div>
            <div class="col-3 text-right">
                <a href="#" class="btn btn-icon btn-info edit_customer border-r-50" data-area="{{$user->id}}"><i class="ki-outline ki-pencil fs-2x me-2 mx-1"></i></a>
            </div>
        </div>
        <div class="d-flex col-6 align-items-center mb-5">
            <i class="ki-outline ki-user fs-2 text-dark me-2"></i>
            <div class="fs-6 fw-bold ">{{$user->name}}</div>
        </div>
        <div class="d-flex col-6 align-items-center mb-5">
            <i class="ki-outline ki-send fs-2 text-dark me-2"></i>
            <div class="fs-6 fw-bold ">{{$user->email}}</div>
        </div>
        <div class="d-flex col-6 align-items-center mb-5">
            <i class="ki-outline ki-phone fs-2 text-dark me-2"></i>
            <div class="fs-6 fw-bold ">{{$user->mobile}}</div>
        </div>

        <h4 class="text-gray-900 my-5 mb-10"><i class="ki-outline ki-map fs-2 text-dark me-2"></i> Default Address</h4>

        <div class="d-flex row align-items-center mb-5">
            @php  $defaultAddress = count($user->default_address) ? $user->default_address[0] : null; @endphp
            @if($defaultAddress)
            <div class="row">
                <div class="col-4 mb-5">
                    <div class="fs-6 fw-bold text-gray-700">Country : {{$defaultAddress->state->city->country->title}}</div>
                </div>
                <div class="col-4 mb-5">
                    <div class="fs-6 fw-bold text-gray-700">State: {{$defaultAddress->state->title}}</div>
                </div>
                <div class="col-4 mb-5">
                    <div class="fs-6 fw-bold text-gray-700">Street: {{$defaultAddress->street}}</div>
                </div>
                <div class="col-4 mb-5">
                    <div class="fs-6 fw-bold text-gray-700">Building: {{$defaultAddress->building}}</div>
                </div>
                <div class="col-4 mb-5">
                    <div class="fs-6 fw-bold text-gray-700">Block: {{$defaultAddress->block}}</div>
                </div>
                <div class="col-4 mb-5">
                    <div class="fs-6 fw-bold text-gray-700">Gada: {{$defaultAddress->avenue}}</div>
                </div>
                <div class="col-4 mb-5">
                    <div class="fs-6 fw-bold text-gray-700">Floor: {{$defaultAddress->floor}}</div>
                </div>
                <div class="col-4 mb-5">
                    <div class="fs-6 fw-bold text-gray-700">Flat: {{$defaultAddress->flat}}</div>
                </div>
                <div class="col-4 mb-5">
                    <div class="fs-6 fw-bold text-gray-700">Automated Number: {{$defaultAddress->automated_number}}</div>
                </div>
                <div class="col-12 mb-5">
                    <div class="fs-6 fw-bold text-gray-700">Additional Address: {{$defaultAddress->address}}</div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>


@include('pos::dashboard.customers.partials.edit_customer')


@push('extra_scripts')
    <script>
        "use strict";

        // On document ready
        KTUtil.onDOMContentLoaded(function () {


        });
    </script>
@endpush
