<div class="accordion-body p-5 py-5">
    @foreach($items as $item)
        <div class="cart-item my-5 row">
            <div class="addon mb-5 d-inline-flex col-8">
                @php
                    $classes = [1=>'primary',2=>'warning',3=>'success'];
                @endphp
                <div class="bg-light-{{$classes[$item['attributes']['custom_addons_models'][0]['addon']['id']]}} py-2 me-2 w-100px text-center">{{$item['attributes']['custom_addons_models'][0]['addon']['title']}}</div>
            </div>
            <div class="product">
                <div class="row mb-5">
                    <div class="col-4 name" style="display: grid;align-items: center;">
                        <div class="d-flex align-items-center">
                            <img class="w-50px h-50px rounded-3 me-3" src="{{url($item['attributes']['product']['image'])}}"
                                 alt="{{$item['attributes']['product']['title']}}" style="border: 1px solid #764fa8">
                            <span class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-6 me-1">
                                {{$item['attributes']['product']['title']}}
                            </span>
                        </div>
                    </div>
                    <div class="col-2 text-center" style="display: grid;align-items: center;">
                        <div class="qty">
                                <span class="bg-light-{{$classes[$item['attributes']['custom_addons_models'][0]['addon']['id']]}} py-2 d-block mb-1">
                                    x{{$item['attributes']['qty_details'][0]['qty']}}
                                </span>
                        </div>
                    </div>
                    <div class="col-4 text-center" style="display: grid;align-items: center;">
                        <div class="prices">
                            <span class="bg-light-{{$classes[$item['attributes']['custom_addons_models'][0]['addon']['id']]}} py-2 d-block mb-1">
                                <span class="price">{{number_format($item['attributes']['custom_addons_models'][0]['price'],3)}}</span> {{__('KD')}}
                            </span>
                        </div>
                    </div>
                    <div class="col-2" style="display: grid;align-items: center;">
                        <a href="#" data-product="{{$item['attributes']['product']['id'].'-'.$item['attributes']['custom_addons_models'][0]['addon']['id']}}" data-type="{{$item['attributes']['product_type']}}"
                           data-target="{{ route('dashboard.pos.orders.deleteItemFromCart') }}" class="removeCartItem text-center">
                            <i class="ki-outline ki-trash fs-2 text-stylish"></i>
                        </a>
                    </div>
                </div>
            </div>
            @php
                $starchObj = \Modules\Catalog\Entities\StarchType::find($item['attributes']['starch']);
            @endphp
            @if($starchObj)
            <div class="starch mb-5">
                <div class="bg-light-info py-2 w-100px text-center">{{  $starchObj->title ?? '' }}</div>
            </div>
            @endif
            <hr style="color: #ccc">
            <div class="notes">
                <label class="form-label">
                    <i class="ki-outline ki-note-2 fs-2x text-stylish" style="margin-right: 5px"></i>
                    <a href="#" class="text-stylish text-decoration instructions" data-notes="{{$item['attributes']['notes']}}"> General Instructions</a>
                </label>
            </div>
        </div>
        <hr class="mb-5">
    @endforeach
</div>
