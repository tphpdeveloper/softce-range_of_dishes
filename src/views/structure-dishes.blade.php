<{{ isset($single_dishes) ? 'form method="post" action="#"' : 'div' }} id="package_{{ $package->id }}" class="constructor__content {{ isset($active) ? 'active' : '' }}">
    @if(isset($single_dishes))
        {{ csrf_field() }}
    @endif

    <div class="constructor__row constructor__row--head">
        <div class="constructor__row-name">

        </div>

        @if($attributes)
            @php
                $type = ['type', 'count', 'weight'];
            @endphp
            @foreach($attributes as $co => $attribute)
                <div class="constructor__row-{{ $type[$co] }}">
                    {{ $attribute->name }}
                </div>
            @endforeach
        @endif
    </div>

    @if($package->products)
        @php
        $total_weight = 0;
        $total_price = 0;

        @endphp
        @foreach($package->products as $product)
            @php
                $count_variant = $product->variants->count();
                $structure_attribute = [];
            @endphp
            @foreach($attributes as $attribute)
                @foreach($product->attributeValue as $attributeValue)
                    @if($attribute->id == $attributeValue->attribute->id)
                        @php
                            $structure_attribute[] = $attributeValue->name;
                        @endphp
                    @endif
                @endforeach
            @endforeach

            <div class="constructor__row"  >
                <div class="constructor__row-name">
                    @if($count_variant)
                        <select name="{{ $product->slug }}"
                                required
                                class="main-select"
                                @foreach($structure_attribute as $co => $name_value)
                                    data-{{ $type[$co] }}="{{ $name_value }}"
                                @endforeach
                                data-price="{{ $product->price }}"
                                data-package="{{ $package->id }}"
                                data-all="{{ isset($single_dishes) ? 'form' : 'div' }}"
                            >

                            <option value="{{ $product->slug }}"
                                    @foreach($structure_attribute as $co => $name_value)
                                        data-{{ $type[$co] }}="{{ $name_value }}"
                                    @endforeach
                                    data-price="{{ $product->price }}"
                                    data-name="{{ $product->slug }}"
                                >
                                {{ $product->name }}
                            </option>


                            @foreach($product->variants as $variant)

                                @php
                                    $structure_variant_attribute = [];
                                @endphp
                                @foreach($attributes as $attribute)
                                    @foreach($variant->attributeValue as $attributeValue)
                                        @if($attribute->id == $attributeValue->attribute->id)
                                            @php
                                                $structure_variant_attribute[] = $attributeValue->name;
                                            @endphp
                                        @endif
                                    @endforeach
                                @endforeach

                                <option value="{{ $variant->slug }}"
                                        @foreach($structure_variant_attribute as $co => $name_value)
                                            data-{{ $type[$co] }}="{{ $name_value }}"
                                        @endforeach
                                        data-price="{{ $variant->price }}"
                                        data-name="{{ $variant->slug }}"
                                    >
                                    {{ $variant->name }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <label class="main-checkbox">
                            <input
                                type="checkbox"
                                checked
                                name="{{ $product->slug }}"
                                data-package="{{ $package->id }}"
                                data-all="{{ isset($single_dishes) ? 'form' : 'div' }}"
                                @foreach($structure_attribute as $co => $name_value)
                                        data-{{ $type[$co] }}="{{ $name_value }}"
                                @endforeach
                                class="js_check_uncheck_dish"
                                data-price="{{ $product->price }}"
                                >
                            <span></span>
                        </label>
                        <span class="text">{{ $product->name }}</span>
                    @endif
                </div>


                @foreach($structure_attribute as $co => $name_value)
                    @if(($co + 1) == count($structure_attribute))
                        @php
                            if(strpos($name_value, ',')){
                                $name_value = str_replace(',', '.', $name_value);
                            }

                            $total_weight += ( $name_value * $structure_attribute[$co - 1] );
                            $total_price += ( $product->price * $structure_attribute[$co - 1] );
                        @endphp
                    @endif

                    <div class="constructor__row-{{ $type[$co] }}">
                        {{ $name_value }}
                    </div>
                @endforeach
            </div>

        @endforeach
    @endif


    <div class="constructor__total">
        <div class="constructor__total-weight">
            <div class="name">
                {{ isset($lang_static) ? $lang_static->getTranslate('total-weight') : 'Вес всего' }}
            </div>
            <div class="num">
                <span class="js_total_weight"> {{ MultipleCurrency::setNumberFormat()->price($total_weight) }}</span> гр
            </div>
        </div>
        <div class="constructor__total-price">
            <div class="name">
                {{  isset($lang_static) ? $lang_static->getTranslate('total-price') : 'Итого цена'  }}
            </div>
            <div class="num">
                <span class="js_total_price">{{ MultipleCurrency::setNumberFormat()->price($total_price) }}</span> грн
            </div>
        </div>
        <button type="button" class="button button--second js-next-step">
            <span>
                {{  $name_button  }}
            </span>
        </button>
    </div>
</{{ !isset($single_dishes) ? 'div' : 'form' }}>