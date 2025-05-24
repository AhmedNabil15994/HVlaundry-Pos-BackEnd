<table class="table" style="margin-bottom: 0px;">
    <tbody>
        @foreach ($product->customAddons as $i => $addon)
            <tr>
                <td>
                    <img src="{{ asset($addon->image) }}" alt="{{ $addon->title }}" style="width: 50px; height: 50px;">
                    {{ $addon->title }}
                    <span>
                        ({{ number_format($addon->pivot->price, 3) }})
                    </span>
                </td>
                <td style="vertical-align: middle;">
                    <div style="display: inline-flex" class="cart-plus-minus count-cart">

                        <input type="hidden" class="product-id" value="{{ $product->id }}" />
                        <input type="hidden" class="product-title" value="{{ $product->title }}" />

                        <button type="button" class="btn btn-success plusBtn">+</button>

                        <input type="text" id="addonQtyCount-{{ $addon->id }}"
                            class="form-control product-addon-qty qtyCount" addonId="{{ $addon->id }}"
                            name="qty[{{ $product->id }}][{{ $addon->id }}]" addonTitle="{{ $addon->title }}"
                            @if ($order) value="{{ getProductAddonQtyInOrder($order->id, $product->id, $addon->id) }}"
                            @else
                            value="0" @endif
                            addonPrice="{{ $addon->pivot->price }}" />

                        <button type="button" style="right: 5px;" class="btn btn-success minusBtn">-</button>

                    </div>
                </td>
            </tr>
        @endforeach
        <tr class="main-strach">
            <td>
                <label for="starch">
                   {{  __('order::dashboard.orders.starch_status') }} :
                </label>
            </td>
            <td>
                @inject('starch_types','Modules\Catalog\Entities\StarchType')
                <select name="starch[{{ $product->id }}]" id="starch"  class="form-control select2-allow-clear product-starch">
                    @foreach($starch_types->orderBy('sort','asc')->get() as $type)
                    <option value="{{$type->id}}" {{(getProductStarchInOrder($order->id, $product->id)  == $type->id ) ? 'selected' : ''}}>  {{ $type->title }}</option>
                    @endforeach
                </select>
           </td>

        </tbody>
</table>
