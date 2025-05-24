@extends('pos::dashboard.layouts.app')

@section('title' , __('apps::dashboard.navbar.pos_system') . ' -- '.'Subscriptions')
@section('page_name' , 'Subscriptions')


@section('content')
    <!--begin::Row-->
    <div class="d-flex flex-column gap-7 gap-lg-10">
        <div class="d-flex flex-wrap flex-stack gap-5 gap-lg-10">
            <!--begin:::Tabs-->
            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-lg-n2 me-auto" role="tablist">
                <!--begin:::Tab item-->
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_ecommerce_sales_order_summary" aria-selected="true" role="tab">Order Summary</a>
                </li>
                <!--end:::Tab item-->

                <!--begin:::Tab item-->
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_ecommerce_sales_order_history" aria-selected="false" tabindex="-1" role="tab">Order History</a>
                </li>
                <!--end:::Tab item-->
            </ul>
            <!--end:::Tabs-->

            <!--begin::Button-->
            <a href="{{URL::previous()}}" class="btn btn-icon btn-light btn-active-secondary btn-sm ms-auto me-lg-n7">
                <i class="ki-outline ki-left fs-2"></i>
            </a>
            <!--end::Button-->

            <!--begin::Button-->
            <a href="{{route('dashboard.pos.orders.create')}}" class="btn btn-primary btn-sm">
                <i class="ki-outline ki-plus-square fs-3"></i> Add New Order
            </a>
            <!--end::Button-->
        </div>
        <!--begin::Order summary-->
        <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
            <!--begin::Order details-->
            <div class="card card-flush py-4 flex-row-fluid">
                <!--begin::Card header-->
                <div class="card-header">
                    <div class="card-title">
                        <h2>Order Details (#{{$order->id}})</h2>
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
                                    <td class="fw-bold text-end">{{date('m/d/Y',strtotime($order->created_at))}}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline text-stylish ki-status fs-2 me-2"></i>
                                            Order Status
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end"><span class="order_status p-3 px-5 " style="background: {{$order->orderStatus->color}}">{{$order->orderStatus->title}}</span></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline text-stylish ki-courier-express fs-2 me-2"></i>
                                            Fast Delivery ?
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">{{$order->is_fast_delivery ? 'Yes' : 'No'}}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline text-stylish ki-user fs-2 me-2"></i>
                                            Created By ?
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">{{ucwords($order->order_added_by)}}</td>
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
                                            <i class="ki-outline text-stylish ki-profile-circle fs-2 me-2"></i>
                                            Customer
                                        </div>
                                    </td>

                                    <td class="fw-bold text-end">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <!--begin::Name-->
                                            <a href="{{route('dashboard.pos.customers.show',['id'=>$order->user_id])}}" class="text-gray-600 text-hover-primary">
                                                {{$order->user->name}}
                                            </a>
                                            <!--end::Name-->
                                        </div>
                                    </td>
                                </tr>
                                @if($order->user->email)
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline text-stylish ki-sms fs-2 me-2"></i>
                                            Email
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">
                                        <a href="{{route('dashboard.pos.customers.show',['id'=>$order->user_id])}}" class="text-gray-600 text-hover-primary">
                                            {{$order->user->email}}
                                        </a>
                                    </td>
                                </tr>
                                @endif
                                @if($order->user->mobile)
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline text-stylish ki-phone fs-2 me-2"></i>
                                            Phone
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">+{{$order->user->mobile}}</td>
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
                                            <i class="ki-outline text-stylish ki-wallet fs-2 me-2"></i>
                                            Payment Method
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">
                                        {{$order->transactions ? ucfirst($order->transactions->method) : __('order::dashboard.orders.show.invoices.not_paid')}}
                                    </td>
                                </tr>
                                @if($order->payment_status_id == 2)
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline text-stylish ki-devices fs-2 me-2"></i>
                                            Payment Confirmation
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">
                                        <a href="#" class="text-gray-600 text-hover-primary">
                                            {{ $order->payment_confirmed_at ? date('m/d/Y  h:i:s A', strtotime($order->payment_confirmed_at)) : '---' }}
                                        </a>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="text-muted">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-outline text-stylish ki-delivery fs-2 me-2"></i>
                                            Driver
                                        </div>
                                    </td>
                                    <td class="fw-bold text-end">
                                        {{$order->driver ? $order->driver->driver->name : '---'}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Documents-->    </div>
        <!--end::Order summary-->
        @php
            $pickup_times = count($order->orderTimes->receiving_data) == 2 ? explode('-',$order->orderTimes->receiving_data['receiving_time']) : null;
            $delievery_times = count($order->orderTimes->delivery_data) == 2 ? explode('-',$order->orderTimes->delivery_data['delivery_time']) : null;
        @endphp
        <!--begin::Tab content-->
        <div class="tab-content">
            <!--begin::Tab pane-->
            <div class="tab-pane fade show active" id="kt_ecommerce_sales_order_summary" role="tab-panel">
                <!--begin::Orders-->
                <div class="d-flex flex-column gap-7 gap-lg-10">
                    <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
                        <!--begin::Payment address-->
                        <div class="card card-flush py-4 flex-row-fluid position-relative">
                            <!--begin::Background-->
                            <div class="position-absolute top-0 end-0 bottom-0 opacity-10 d-flex align-items-center me-5">
                                <i class="ki-solid ki-two-credit-cart" style="font-size: 14em">
                                </i>
                            </div>
                            <!--end::Background-->

                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Pick Up Details</h2>
                                </div>
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <div class="fw-bold mb-3 text-muted">
                                    <i class="ki-outline ki-calendar fs-1 text-stylish"></i>
                                    {{$pickup_times ? date('m/d/Y',strtotime($order->orderTimes->receiving_data['receiving_date'])) : '-----'}}
                                </div>
                                <div class="fw-bold mb-3 text-muted">
                                    <i class="ki-outline ki-timer fs-1 text-stylish"></i>
                                    {{$pickup_times ? date('A h:i',strtotime($pickup_times[0])) . ' - ' . date('A h:i',strtotime($pickup_times[1])) : '-----'}}
                                </div>
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Payment address-->
                        <!--begin::Shipping address-->
                        <div class="card card-flush py-4 flex-row-fluid position-relative">
                            <!--begin::Background-->
                            <div class="position-absolute top-0 end-0 bottom-0 opacity-10 d-flex align-items-center me-5">
                                <i class="ki-solid ki-delivery" style="font-size: 13em">
                                </i>
                            </div>
                            <!--end::Background-->

                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Delivery Details</h2>
                                </div>
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <div class="fw-bold mb-3 text-muted">
                                    <i class="ki-outline ki-calendar fs-1 text-stylish"></i>
                                    {{$delievery_times ? date('m/d/Y',strtotime($order->orderTimes->delivery_data['delivery_date'])) : '-----'}}
                                </div>
                                <div class="fw-bold mb-3 text-muted">
                                    <i class="ki-outline ki-timer fs-1 text-stylish"></i>
                                    {{$delievery_times ? date('A h:i',strtotime($delievery_times[0])) . ' - ' . date('A h:i',strtotime($delievery_times[1])) : '-----'}}
                                </div>
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Shipping address-->
                        @if ($order->orderAddress != null)
                        <!--begin::Shipping address-->
                        <div class="card card-flush py-4 flex-row-fluid position-relative">
                            <!--begin::Background-->
                            <div class="position-absolute top-0 end-0 bottom-0 opacity-10 d-flex align-items-center me-5">
                                <i class="ki-solid ki-map" style="font-size: 13em">
                                </i>
                            </div>
                            <!--end::Background-->

                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Address Details</h2>
                                </div>
                            </div>
                            <!--end::Card header-->

                            <!--begin::Card body-->
                            <div class="card-body pt-0">

                                <div class="fw-bold">
                                    <div class="px-3 row">
                                        <div class="col-1">
                                            <i class="ki-outline ki-map fs-1 text-stylish"></i>
                                        </div>
                                        <div class="col-11">
                                            <div class="note well text-muted">
                                                @if (!is_null($order->orderAddress->state))
                                                    <span class="bold uppercase">
                                                        {{ $order->orderAddress->state->city->title }}
                                                        /
                                                        {{ $order->orderAddress->state->title }}
                                                    </span>
                                                @endif
                                                <br />
                                                @if ($order->orderAddress->governorate)
                                                    <span class="bold">{{ __('order::dashboard.orders.show.address.governorate') }}:</span>
                                                    {{ $order->orderAddress->governorate }}
                                                    <br />
                                                @endif

                                                @if ($order->orderAddress->block)
                                                    <span class="bold">{{ __('order::dashboard.orders.show.address.block') }}:</span>
                                                    {{ $order->orderAddress->block }}
                                                    <br />
                                                @endif

                                                @if ($order->orderAddress->district)
                                                    <span class="bold">{{ __('order::dashboard.orders.show.address.district') }}:</span>
                                                    {{ $order->orderAddress->district }}
                                                    <br />
                                                @endif

                                                @if ($order->orderAddress->street)
                                                    <span class="bold">{{ __('order::dashboard.orders.show.address.street') }}:</span>
                                                    {{ $order->orderAddress->street }}
                                                    <br />
                                                @endif

                                                @if ($order->orderAddress->building)
                                                    <span class="bold">{{ __('order::dashboard.orders.show.address.building') }}:</span>
                                                    {{ $order->orderAddress->building }}
                                                    <br />
                                                @endif

                                                @if ($order->orderAddress->floor)
                                                    <span class="bold">{{ __('order::dashboard.orders.show.address.floor') }}:</span>
                                                    {{ $order->orderAddress->floor }}
                                                    <br />
                                                @endif

                                                @if ($order->orderAddress->flat)
                                                    <span class="bold">{{ __('order::dashboard.orders.show.address.flat') }}: </span>
                                                    {{ $order->orderAddress->flat }}
                                                    <br />
                                                @endif

                                                <span class="bold">{{ __('order::dashboard.orders.show.address.details') }}:</span>
                                                {{ $order->orderAddress->address ?? '---' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Shipping address-->
                        @endif
                    </div>

                    <!--begin::Product List-->
                    <div class="card card-flush py-4 flex-row-fluid overflow-hidden">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Order #{{$order->id}}</h2>
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
                                        <th class="min-w-175px">Product</th>
                                        <th class="min-w-70px text-end">Qty</th>
                                        <th class="min-w-100px text-end">Unit Price</th>
                                        <th class="min-w-100px text-end">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                    @php $count = 0; @endphp
                                    @foreach($orderProducts as $key => $addons)
                                        <tr>
                                            <td>
                                                @if(!empty($addons))
                                                    <div class="d-flex align-items-center mb-5">
                                                        <!--begin::Thumbnail-->
                                                        <a href="#" class="symbol symbol-50px">
                                                            <span class="symbol-label" style="background-image:url({{asset($addons[0]->addon->image)}});"></span>
                                                        </a>
                                                        <!--end::Thumbnail-->
                                                        <!--begin::Title-->
                                                        <div class="ms-5">
                                                            <a href="#" class="fw-bold text-gray-600 text-hover-primary">
                                                                <b>
                                                                    {{$addons[0]->addon->getTranslations('title')['en']}}<br>
                                                                    {{$addons[0]->addon->getTranslations('title')['ar']}}<br>
                                                                </b>
                                                            </a>
                                                        </div>
                                                        <!--end::Title-->
                                                    </div>
                                                @endif
                                                @foreach($addons as $singleAddon)
                                                    @if(!empty($singleAddon))
                                                        <div class="d-flex align-items-center mb-5 mx-3">
                                                            <!--begin::Thumbnail-->
                                                            <a href="#" class="symbol symbol-50px">
                                                                <span class="symbol-label" style="background-image:url({{asset($singleAddon->orderProduct->product->image)}});"></span>
                                                            </a>
                                                            <!--end::Thumbnail-->

                                                            <!--begin::Title-->
                                                            <div class="ms-5">
                                                                <a href="#" class="fw-bold text-gray-600 text-hover-primary">
                                                                    <b>
                                                                        {{$singleAddon->orderProduct->product->getTranslations('title')['en']}}<br>
                                                                        {{$singleAddon->orderProduct->product->getTranslations('title')['ar']}}
                                                                        @if($singleAddon->orderProduct->starchType)
                                                                            <br>{{$singleAddon->orderProduct->starchType->title ?? ''}} Starch
                                                                        @endif
                                                                    </b>
                                                                </a>
                                                            </div>
                                                            <!--end::Title-->
                                                        </div>
                                                    @endif
                                                @endforeach

                                            </td>
                                            <td class="text-right">
                                                @foreach($addons as $singleAddon)
                                                    @if(!empty($singleAddon))
                                                        <br>
                                                        <p class="m-5">{{$singleAddon->qty}}</p>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="text-right">
                                                @foreach($addons as $singleAddon)
                                                    @php $count++; @endphp
                                                    @if(!empty($singleAddon))
                                                        <br>
                                                        <p class="m-5">{{number_format($singleAddon->total / $singleAddon->qty,3)}}</p>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="text-right">
                                                @foreach($addons as $singleAddon)
                                                    @if(!empty($singleAddon))
                                                        <br>
                                                        <p class="m-5">{{$singleAddon->total}}</p>
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                        <tr>
                                            <td colspan="3" class="text-end">
                                                Subtotal
                                            </td>
                                            <td class="text-end">
                                                {{$order->subtotal . ' ' .__('KD')}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end">
                                                Delivery Fees
                                            </td>
                                            <td class="text-end">
                                                {{$order->shipping . ' ' .__('KD')}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end">
                                                Discount
                                            </td>
                                            <td class="text-end">
                                                {{($order->orderCoupons ? $order->calcDiscount() : $order->off) . ' ' .__('KD')}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="fs-3 text-gray-900 text-end">
                                                Total
                                            </td>
                                            <td class="text-gray-900 fs-3 fw-bolder text-end">
                                                {{$order->total . ' ' .__('KD')}}
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

            <!--begin::Tab pane-->
            <div class="tab-pane fade" id="kt_ecommerce_sales_order_history" role="tab-panel">
                <!--begin::Orders-->
                <div class="d-flex flex-column gap-7 gap-lg-10">
                    <!--begin::Order history-->
                    <div class="card card-flush py-4 flex-row-fluid">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Order History</h2>
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
                                        <th class="min-w-100px">Date Added</th>
                                        <th class="min-w-70px">Order Status</th>
                                        <th class="min-w-175px">Updated By</th>
                                    </tr>
                                    </thead>
                                    <tbody class="fw-semibold text-gray-600">
                                        @foreach ($order->orderStatusesHistory()->orderBy('pivot_created_at', 'desc')->get() as $k => $history)
                                        <tr id="orderHistory-{{ optional($history->pivot)->id }}">
                                            <td>
                                                {{ date('m/d/Y',strtotime(optional($history->pivot)->created_at)) }}
                                            </td>
                                            <td>
                                                {{ $history->title ?? '' }}
                                            </td>
                                            <td>
                                                {{ is_null(optional($history->pivot)->user_id) ? '---' : \Modules\User\Entities\User::find(optional($history->pivot)->user_id)->name ?? null }}
                                            </td>
                                        </tr>
                                      @endforeach
                                    </tbody>
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Order history-->
                    <!--begin::Order data-->
                    <div class="card card-flush py-4 flex-row-fluid">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>{{__('order::dashboard.orders.show.invoices.terms')}}</h2>
                            </div>
                        </div>
                        <!--end::Card header-->

                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="table-responsive fw-bold fs-3">
                                <p class="pre-line">{{$termsPage->getTranslation('seo_description', 'ar')}}</p>
                                <p class="pre-line">{{$termsPage->getTranslation('seo_description', 'en')}}</p>
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Order data-->
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
