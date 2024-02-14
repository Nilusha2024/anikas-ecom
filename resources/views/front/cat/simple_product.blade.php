<div class="col-sm-6 col-md-4 col-lg-3 col-6 kalpana" id="updatediv">
    
    <div class="item">
        <div class="products">
            <div class="product">
                <div class="product-image">
                    <div class="image {{ $simple_pro->stock == 0 ? "pro_img-box" : ""}}">

                        <a href="{{ route('show.product',['id' => $simple_pro->id, 'slug' => $simple_pro->slug]) }}" title="{{$simple_pro->product_name}}">

                            @if($simple_pro->thumbnail != '' && file_exists(public_path().'/images/simple_products/'.$simple_pro->thumbnail))

                            
                                <img class="lazy {{ $simple_pro->stock == 0 ? "filterdimage" : ""}}"
                                data-src="{{ url('images/simple_products/'.$simple_pro->thumbnail) }}"
                                alt="{{ $simple_pro->product_name }}">
                            
                                <img class="lazy hover-image {{ $simple_pro->stock == 0 ? "filterdimage" : ""}}"
                                data-src="{{ url('images/simple_products/'.$simple_pro->hover_thumbnail) }}"
                                alt="{{ $simple_pro->product_name }}">
                           

                            @else
                                <img class="lazy {{ $simple_pro->stock == 0 ? "filterdimage" : ""}}" title="{{ $simple_pro->product_name }}"
                                data-src="{{url('images/no-image.png')}}" alt="No Image" />

                            @endif

                        </a>
                    </div>
                    <!-- /.image -->

                    @if($simple_pro->featured=="1")
                        <div class="tag hot"><span>{{ __('staticwords.Hot') }}</span></div>
                    @elseif($simple_pro->offer_price != 0)
                        <div class="tag sale"><span>{{ __('staticwords.Sale') }}</span></div>
                    @else
                        <div class="tag new"><span>{{ __('staticwords.New') }}</span></div>
                    @endif
                </div>
                <!-- /.product-image -->

                <div class="product-info text-left">
                        <h3 class="name">
                            <a href="{{ route('show.product',['id' => $simple_pro->id, 'slug' => $simple_pro->slug]) }}">
                                
                                {{ $simple_pro->product_name }}

                            </a> 
                        </h3> 

                        @if(simple_product_rating($simple_pro->id) != 0)
                            <div class="pull-left star-right">
                                <div class="star-ratings-sprite"><span style="width:{{ simple_product_rating($simple_pro->id) }}%" class="star-ratings-sprite-rating"></span>
                                </div>
                            </div>
                        @else
                            <span class="font-size-10">{{ __('Rating Not Available') }}</span>
                        @endif

                        <div class="description"></div>
                        <div class="product-price"> <span class="price">

                                

                                @if($simple_pro->offer_price != 0)

                                    <span class="price">
                                        <i class="{{session()->get('currency')['value']}}"></i>
                                        {{sprintf("%.2f",$simple_pro->offer_price * $conversion_rate)}}
                                    </span>
                                    <span class="price-before-discount">
                                        <i class="{{session()->get('currency')['value']}}"></i>
                                        {{sprintf("%.2f",$simple_pro->price * $conversion_rate)}}
                                    </span>

                                @else

                                    <span class="price">
                                        <i class="{{session()->get('currency')['value']}}"></i>
                                        {{sprintf("%.2f",$simple_pro->price * $conversion_rate)}}
                                    </span>

                                @endif
                        </div>
                        <!-- /.product-price -->

            </div>
            <!-- /.product-info -->
            @if($simple_pro->stock != 0)

            <div class="cart clearfix animate-effect">
                <div class="action">
                    <ul class="list-unstyled">
                        <li class="add-cart-button btn-group">
                            <form method="POST" action="{{ $simple_pro->type == 'ex_product' ? $simple_pro->external_product_link : route('add.cart.simple',['pro_id' => $simple_pro->id, 'price' => $simple_pro->price, 'offerprice' => $simple_pro->offer_price]) }}">
                                @csrf

                                <input name="qty" type="hidden" value="{{ $simple_pro->min_order_qty }}" max="{{ $simple_pro->max_order_qty }}" class="qty-section">

                                <button class="btn btn-primary icon" type="submit"> <i class="fa fa-shopping-cart"></i>
                                </button>

                            </form>
                        </li>
                        @auth

                            @if($simple_pro->type != 'ex_product')
                                
                                    <li class="lnk wishlist active">
                                        <a class="text-dark add_in_wish_simple btn icon" data-proid="{{ $simple_pro->id }}" data-status="{{ inwishlist($simple_pro->id) }}" data-toggle="tooltip" data-placement="right"
                                            title="{{ inwishlist($simple_pro->id) == false ? __("staticwords.AddToWishList") :  __("staticwords.RemoveFromWishlist") }}" href="javascript:void(0)">
                                            <i class="fa fa-heart"></i>
                                        </a>
                                    </li>

                            @endif

                        @endauth
                    </ul>
                </div>
                <!-- /.action -->
            </div>
            @endif
            <!-- /.cart -->
        </div>
        <!-- /.product -->
        </div>
    </div>
    
</div>

