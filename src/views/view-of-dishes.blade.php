@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="constructor__title">
            {{ $lang_static->getTranslate('gather-yourself') }}
        </div>
        <div class="constructor__body">
            <div class="constructor__head">
                <div class="constructor__head-btn active">
                    <span>{{ $lang_static->getTranslate('im-collecting') }}</span> {{ $lang_static->getTranslate('a-daily-set') }}
                </div>
                <div class="constructor__head-btn">
                    <span>{{ $lang_static->getTranslate('i-collect') }}</span> {{ $lang_static->getTranslate('1-meal') }}
                </div>
            </div>
            <form class="constructor__wrapper active" method="post" action="#">
                {{ csrf_field() }}


                <div class="constructor__box">
                    <div class="constructor__aside">
                        <ol type="1">
                            @if($packages)
                                @foreach($packages as $co => $package)
                                    <li @if(!$co) class="active" @endif >{{ $package->name }}</li>
                                @endforeach
                            @endif
                        </ol>
                    </div>

                    {!! $all_dishes !!}

                </div>
            </form>
            <div class="constructor__wrapper">
                <div class="constructor__box">
                    <div class="constructor__aside">
                        <ul>
                            @if($packages)
                                @foreach($packages as $co => $package)
                                    <li>
                                        <label class="main-radio">
                                            <input type="radio" name="constructorRadio" @if(!$co) checked @endif data-index="{{ $co }}">
                                            <span>{{ $package->name }}</span>
                                            <span></span>
                                        </label>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>


                    {!! $single_dishes !!}


                </div>
            </div>
        </div>
    </div>

@stop


@push('scripts')
    <script>

        (function(){

            var
            getTotalWeight = function(obj){
                var weight = 0;
                $.each(obj, function(key, item){
                    //if(!key) return;
                    var weight_str = $(item).attr('data-weight');
                    if( typeof weight_str  === 'string'){
                        weight_str = weight_str.replace(',', '.');
                    }
                    weight += ( Number( $(item).attr('data-count') ) * Number( weight_str ) );
                });
                return weight;
            },
            getTotalPrice = function(obj){
                var price = 0;
                // console.log(obj)
                $.each(obj, function(key, item){
                    //if(!key) return;
                    price += ( Number( $(item).attr('data-count') ) * Number( $(item).attr('data-price') ) );
                });
                return price;
            },
            //for selected needed block
            getNeededBlock = function(obj){
                var block = {};

                console.log(obj);

                //package id for choose needed block
                block.package_id = Number(obj.attr('data-package'));
                //tag name for choose needed block
                block.tag = obj.attr('data-all');
                //string for get needed block
                block.selector = block.tag+'#package_'+block.package_id+'.constructor__content.active';
                //console.log(block.selector);
                //select selected inputs
                block.inputs = $(block.selector + ' input:checked');
                //select all select tag in needed block
                block.select = $(block.selector + ' select');
                //count total weight
                block.weight = getTotalWeight(block.inputs) + getTotalWeight(block.select);
                //count total price
                block.price = getTotalPrice(block.inputs) + getTotalPrice(block.select);
                //set number weight to DOM
                block.setTotalWeight = function(){
                    $(block.selector + ' div.constructor__total span.js_total_weight').html(block.weight);
                };
                //set number price to DOM
                block.setTotalPrice = function(){
                    $(block.selector + ' div.constructor__total span.js_total_price').html(block.price);
                };

                return block;
            };

            //on click input checkbox
            $('.js_check_uncheck_dish').on('change', function(e){
                e.stopPropagation();
                var block = getNeededBlock($(this));
                block.setTotalWeight();
                block.setTotalPrice();

            });

            //on click input checkbox
            //Select init Start
            if ($(".main-select").length) {
                $(".main-select").selectmenu({
                    change: function( event, ui ) {
                        var select = $(this),
                            option =  select.find(':selected'),
                            parent = select.parent().parent(),
                            option_type = option.attr('data-type'),
                            option_count = option.attr('data-count'),
                            option_weight = option.attr('data-weight');

                        select.attr('data-type', option_type);
                        select.attr('data-count', option_count);
                        select.attr('data-weight', option_weight);
                        select.attr('data-price', option.attr('data-price'));
                        select.attr('name', option.attr('data-name'));

                        parent.find('div.constructor__row-type').html(option_type);
                        parent.find('div.constructor__row-count').html(option_count);
                        parent.find('div.constructor__row-weight').html(option_weight);

                        var block = getNeededBlock($(this));
                        block.setTotalWeight();
                        block.setTotalPrice();
                    }
                });
            }


        })();



    </script>
@endpush