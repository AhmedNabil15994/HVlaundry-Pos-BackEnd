@extends('pos::dashboard.layouts.app')

@section('title' , __('apps::dashboard.navbar.pos_system') . ' -- '.'Subscriptions')
@section('page_name' , 'Subscriptions')


@section('content')
    <!--begin::Row-->
    <div class="d-flex flex-column gap-7 gap-lg-10">
        <!--begin::Order summary-->
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <!--begin::Order details-->
            <div class="card card-flush py-4 flex-row-fluid">
                <!--begin::Card header-->
                <div class="card-header">
                    <div class="card-title">
                        <h2>Package Details</h2>
                    </div>
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                            <tbody class="fw-semibold text-gray-600">
                            <tr>
                                <td class="text-muted">
                                    <div class="d-flex align-items-center">
                                        <i class="ki-outline ki-information-4 text-stylish fs-2 me-2"></i>
                                        ID
                                    </div>
                                </td>
                                <td class="fw-bold text-end">{{$subscription->baqa->id}}</td>
                            </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline ki-notification-2 text-stylish fs-2 me-2"></i>
                                            Title
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">{{$subscription->baqa->title}}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline ki-subtitle text-stylish fs-2 me-2"></i>
                                            Description
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">{{$subscription->baqa->description}}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline ki-time text-stylish fs-2 me-2"></i>
                                            Duration By Days
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">{{$subscription->baqa->duration_by_days}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Order details-->

            <!--begin::Customer details-->
            <div class="card card-flush py-4  flex-row-fluid">
                <!--begin::Card header-->
                <div class="card-header">
                    <div class="card-title">
                        <h2>Customer Details</h2>
                    </div>
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                            <tbody class="fw-semibold text-gray-600">
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline ki-profile-circle text-stylish fs-2 me-2"></i>
                                            Customer
                                        </div>
                                    </td>

                                    <td class="fw-bold text-end">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <!--begin::Name-->
                                            <a href="{{route('dashboard.pos.customers.show',['id'=>$subscription->user_id])}}" class="text-gray-600 text-hover-primary">
                                                {{$subscription->user->name}}
                                            </a>
                                            <!--end::Name-->
                                        </div>
                                    </td>
                                </tr>
                                @if($subscription->user->email)
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline ki-sms text-stylish fs-2 me-2"></i>
                                            Email
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">
                                        <a href="{{route('dashboard.pos.customers.show',['id'=>$subscription->user_id])}}" class="text-gray-600 text-hover-primary">
                                            {{$subscription->user->email}}
                                        </a>
                                    </td>
                                </tr>
                                @endif
                                @if($subscription->user->mobile)
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline text-stylish ki-phone fs-2 me-2"></i>
                                            Phone
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">+{{$subscription->user->mobile}}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Customer details-->
            <!--begin::Documents-->
            <div class="card card-flush py-4  flex-row-fluid">
                <!--begin::Card header-->
                <div class="card-header">
                    <div class="card-title">
                        <h2>Transactions</h2>
                    </div>
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-bordered mb-0 fs-6 gy-5 min-w-300px">
                            <tbody class="fw-semibold text-gray-600">
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline text-stylish ki-calendar fs-2 me-2"></i>
                                            Date Added
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">{{date('m/d/Y',strtotime($subscription->created_at))}}</td>
                                </tr>
                                @if($subscription->transaction)
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline text-stylish ki-devices fs-2 me-2"></i>
                                            Payment ID
                                            <span class="ms-1" data-bs-toggle="tooltip" aria-label="View the invoice generated by this order."
                                                  data-bs-original-title="View the invoice generated by this order." data-kt-initialized="1">
                                                <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end"><a href="#" class="text-gray-600 text-hover-primary">#{{$subscription->transaction->payment_id}}</a></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline text-stylish ki-credit-cart fs-2 me-2"></i>
                                            Method
                                            <span class="ms-1" data-bs-toggle="tooltip" aria-label="View the shipping manifest generated by this order."
                                                  data-bs-original-title="View the shipping manifest generated by this order." data-kt-initialized="1">
                                                <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end"><a href="#" class="text-gray-600 text-hover-primary">{{$subscription->transaction->method}}</a></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline text-stylish ki-financial-schedule fs-2 me-2"></i>
                                            Transaction ID
                                            <span class="ms-1" data-bs-toggle="tooltip" aria-label="Reward value earned by customer when purchasing this order"
                                                  data-bs-original-title="Reward value earned by customer when purchasing this order" data-kt-initialized="1">
                                                <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">{{$subscription->transaction->tran_id}}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Documents-->
        </div>
        <!--end::Order summary-->

        <!--begin::Tab content-->
        <div class="tab-content">
            <!--begin::Tab pane-->
            <div class="tab-pane fade show active" id="kt_ecommerce_sales_order_summary" role="tab-panel">
                <!--begin::Orders-->
                <div class="d-flex flex-column gap-7 gap-lg-10">
                    <!--begin::Product List-->
                    <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Subscription #{{$subscription->id}}</h2>
                            </div>
                        </div>
                        <!--end::Card header-->

                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                    <thead>
                                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="min-w-175px">Package</th>
                                            <th class="min-w-100px text-end">Start At</th>
                                            <th class="min-w-70px text-end">End At</th>
                                            <th class="min-w-100px text-end">Type</th>
                                            <th class="min-w-100px text-end">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Title-->
                                                    <div class="ms-5">
                                                        <a href="#" class="fw-bold text-gray-600 text-hover-primary">{{$subscription->baqa->title}}</a>
                                                        <div class="fs-7 text-muted"></div>
                                                    </div>
                                                    <!--end::Title-->
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                {{$subscription->start_at}}
                                            </td>
                                            <td class="text-end">
                                                {{$subscription->end_at}}
                                            </td>
                                            <td class="text-end">
                                                {{ __('baqat::dashboard.baqat_subscriptions.show.items.type_info.' . $subscription->type) }}
                                            </td>
                                            <td class="text-end">
                                                {{$subscription->price}} {{__('KD')}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-end">
                                                Subtotal
                                            </td>
                                            <td class="text-end">
                                                {{$subscription->price}} {{__('KD')}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-end">
                                                VAT (0%)
                                            </td>
                                            <td class="text-end">
                                                {{number_format( $subscription->price * 0 ,3)}} {{__('KD')}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="fs-3 text-gray-900 text-end">
                                                Total
                                            </td>
                                            <td class="text-gray-900 fs-3 fw-bolder text-end">
                                                {{$subscription->price}} {{__('KD')}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Product List-->
                </div>
                <!--end::Orders-->
            </div>
            <!--end::Tab pane-->
        </div>
        <!--end::Tab content-->
    </div>
    <!--end::Row-->
@endsection

@section('extra')

@endsection

@push('styles')

@endpush

@push('scripts')

@endpush
