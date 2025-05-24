@foreach($products as $product)
    <div class="card cursor-pointer product-card p-3 m-2 w-150px mh-150px d-inline-block" data-title="{{$product->title}}" data-area="{{$product->id}}" data-target="{{implode(',',$product->categories()->pluck('categories.id')->toArray())}}">
        <div class="card-body text-center">
            <img src="{{url($product->image)}}" class="rounded-3 mb-1 w-100px h-100px w-xxl-100px h-xxl-100px" alt="">
            <div class="mb-2">
                <div class="text-center">
                    <span class="fw-bold text-gray-800 cursor-pointer fs-3 fs-xl-1 title">{{$product->title}}</span>
                </div>
            </div>
        </div>
    </div>
@endforeach
