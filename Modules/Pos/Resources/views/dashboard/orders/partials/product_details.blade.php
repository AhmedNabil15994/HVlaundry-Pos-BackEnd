<div id="item_details" class="bg-body drawer drawer-end" data-kt-drawer="true"
     data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'300px', 'lg': '600px'}"
     data-kt-drawer-direction="end" data-kt-drawer-toggle="#item_details_toggle" data-kt-drawer-close="#item_details_close">

    <div class="card shadow-none border-0 rounded-0 w-100">
        <!--begin::Header-->
        <div class="card-header" id="item_details_header">
            <h3 class="card-title fw-bold text-gray-900">Add Item</h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5" id="item_details_close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </button>
            </div>
        </div>
        <!--end::Header-->

        <!--begin::Body-->
        <div class="card-body position-relative" id="item_details_body">
            <!--begin::Content-->
            <div id="item_details_scroll" class="position-relative scroll-y me-n5 pe-5" data-kt-scroll="true" data-kt-scroll-height="auto"
                 data-kt-scroll-wrappers="#item_details_body" data-kt-scroll-dependencies="#item_details_header, #item_details_footer" data-kt-scroll-offset="5px">
                <div class="text-center">
                    <!--begin::Card-->
                    <div class="card cursor-pointer product-card active my-2 w-150px mh-150px" style="display: block;margin: auto" data-area="">
                        <!--begin::Body-->
                        <div class="card-body text-center p-5">
                            <!--begin::Food img-->
                            <img src="" class="rounded-3 mb-4 w-75px h-75px w-xxl-75px h-xxl-75px" alt="">
                            <!--end::Food img-->

                            <!--begin::Info-->
                            <div class="mb-2">
                                <!--begin::Title-->
                                <div class="text-center">
                                    <span class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-3 fs-xl-1 title"></span>
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Card-->
                    <h3 class="fw-bold text-gray-600 my-5">Select Service</h3>
                    <div class="row addonsRow">
{{--                        @foreach($addons as $key => $addon)--}}
{{--                        <div class="col-4">--}}
{{--                            <div class="card cursor-pointer addon-card {{$key == 0 ? 'active' : ''}} w-120px mh-120px" data-area="{{$addon->id}}">--}}
{{--                                <div class="card-body text-center p-0 pb-5">--}}
{{--                                    <img src="{{url($addon->image)}}" class="rounded-3 w-75px h-75px w-xxl-75px h-xxl-75px" alt="">--}}
{{--                                    <div class="mb-2">--}}
{{--                                        <div class="text-center">--}}
{{--                                            <span class="fw-semibold text-gray-600 cursor-pointer fs-4">{{$addon->title}}</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        @endforeach--}}
                    </div>
                    <h3 class="fw-bold text-gray-600 fs-4 mb-5 mt-5">Price Per Item</h3>
                    <div class="row">
                        <div class="col-4"></div>
                        <div class="col-4 row form-group">
                            <div class="col-2"></div>
                            <div class="col-6 p-0 m-0">
                                <input type="tel" class="form-control border-r-0 text-center" name="addon_price" value="0.000" disabled/>
                            </div>
                            <div class="col-4 p-0 m-0">
                                <input type="text" class="form-control border-r-0 text-center form-control-solid" disabled value="{{__('KD')}}">
                            </div>
                        </div>
                    </div>

                    <h3 class="fw-bold text-gray-600 fs-4 mb-5 mt-5">Quantity</h3>
                    <div class="row">
                        <div class="col-3"></div>
                        <div class="col-6 row form-group dialer mx-1">
                            <div class="col-3 pt-1">
                                <button type="button" class="btn btn-icon btn-light border-r-50 w-35px h-35px" data-type="decrease">
                                    <i class="ki-outline ki-minus fs-2x text-stylish"></i>
                                </button>
                            </div>
                            <div class="col-6 ">
                                <input type="text" min="1" step="1" name="qty" class="form-control text-center border-r-0" readonly value="1"/>
                            </div>
                            <div class="col-3 pt-1">
                                <button type="button" class="btn btn-icon btn-light border-r-50 w-35px h-35px" data-type="increase">
                                    <i class="ki-outline ki-plus fs-2x text-stylish"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="starch-data">
                        <h3 class="fw-bold text-gray-600 fs-4 mb-5 mt-5">Starch</h3>
                        @inject('starch_types','Modules\Catalog\Entities\StarchType')
                        <div class="d-flex flex-row fv-row">
                            @foreach($starch_types->orderBy('sort','asc')->get() as $type)
                                <div class="form-check form-check-custom d-block form-check-solid mb-5 col-3">
                                    <input class="form-check-input me-3 w-20px h-20px" name="starch" type="radio" value="{{$type->id}}" {{$type->id == 1 ? 'checked' : ''}}/>
                                    <label class="form-check-label">
                                        <div class="fw-semibold text-gray-800">{{$type->title}}</div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <h3 class="fw-bold text-gray-600 fs-4 mb-5 mt-5">Notes</h3>
                    <div class="row">
                        <div class="col-12 row form-group">
                            <textarea name="notes" class="form-control form-control-solid p-5 px-7 h-100px mh-100px min-h100px" placeholder="Type Your Notes Here"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Content-->
        </div>
        <!--end::Body-->

        <!--begin::Footer-->
        <div class="card-footer py-5 text-center" id="item_details_footer">
            <a href="#" class="btn btn-bg-body add_to_cart w-100" style="color: #FFF;background: #764fa8">
                <span class="title">Add Item</span>
                <i class="ki-duotone ki-arrow-right fs-3 text-white"><span class="path1"></span><span class="path2"></span></i>
            </a>
        </div>
        <!--end::Footer-->
    </div>
</div>
