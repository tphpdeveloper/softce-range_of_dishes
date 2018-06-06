<{{ isset($single_dishes) ? 'form method=post action='. route('add.dishes') : 'div' }} id="package_{{ $package->id }}" class="constructor__content {{ isset($active) ? 'active' : '' }}">
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
                        <select name="package[{{ $package->id }}][{{ $product->slug }}]"
                                required
                                class="main-select"
                                @foreach($structure_attribute as $co => $name_value)
                                    data-{{ $type[$co] }}="{{ $name_value }}"
                                @endforeach
                                data-price="{{ $product->price_discount }}"
                                data-package="{{ $package->id }}"
                                data-all="{{ isset($single_dishes) ? 'form' : 'div' }}"
                            >

                            <option @foreach($structure_attribute as $co => $name_value)
                                        data-{{ $type[$co] }}="{{ $name_value }}"
                                        @if($type[$co] == 'count')
                                            value="{{ $name_value }}"
                                        @endif
                                    @endforeach
                                    data-price="{{ $product->price_discount }}"
                                    data-name="package[{{ $package->id }}][{{ $product->slug }}]"
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

                                <option @foreach($structure_variant_attribute as $co => $name_value)
                                            data-{{ $type[$co] }}="{{ $name_value }}"
                                            @if($type[$co] == 'count')
                                                value="{{ $name_value }}"
                                            @endif
                                        @endforeach
                                        data-price="{{ $variant->price_discount }}"
                                        data-name="package[{{ $package->id }}][{{ $variant->slug }}]"
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
                                name="package[{{ $package->id }}][{{ $product->slug }}]"
                                data-package="{{ $package->id }}"
                                data-all="{{ isset($single_dishes) ? 'form' : 'div' }}"
                                @foreach($structure_attribute as $co => $name_value)
                                        data-{{ $type[$co] }}="{{ $name_value }}"
                                    @if($type[$co] == 'count')
                                        value="{{ $name_value }}"
                                    @endif
                                @endforeach
                                class="js_check_uncheck_dish"
                                data-price="{{ $product->price_discount }}"
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
                            $total_price += ( $product->price_discount * $structure_attribute[$co - 1] );
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
        <button type="{{ isset($single_dishes) || isset($button_type) ? 'submit' : 'button' }}" class="button button--second  {{ isset($single_dishes) || isset($button_type) ? '' : 'js-next-step' }}">
            <span>
                {{  $name_button  }}
            </span>
        </button>
    </div>
</{{ !isset($single_dishes) ? 'div' : 'form' }}>