@extends('frontend.master')

<style>
    .catagory_hover{
        transition: .3s;
    }
    .catagory_border{
        border: 1px solid #cecdcd !important;
        border-radius: 50%;
        transition: .3s;
    }
    .cats_side_wrap:hover .catagory_hover{
        color: #000 !important;
        font-weight: 700;
    }
    .cats_side_wrap:hover .catagory_border{
        border: 1px solid #3d3d3d !important;
        box-shadow: 0px 1px 5px 0px #000;
    }
    .view_all {
        height: 550px;
        overflow-y: scroll;
        scrollbar-width: none;  /* Firefox */
    }
    .top_product_head{
        background: #ebecec;
        padding-top: 10px;
        padding-bottom: 5px;
        text-align: center;
        margin-bottom: 5px;
    }
    .top_selled_rated_recent_product{
        margin-bottom: 70px;
    }

</style>

@section('content')

<!-- ======================= Category & Slider ======================== -->
<section class="p-0">
    <div class="container">
        <div class="row">
        
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                <div class="killore-new-block-link border mb-3 mt-3">
                    <div class="px-3 py-3 ft-medium fs-md text-dark gray">Top Categories</div>
                    
                    <div class="killore--block-link-content">
                        <ul>
                            @foreach ($catagories as $catagory)
                                <li><a href="{{route('catagory_product', $catagory->id)}}"><img width="30" src="{{asset('uploads/catagory')}}/{{$catagory->catagory_image}}" alt="">&nbsp; &nbsp; {{$catagory->catagory_name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
                <div class="home-slider auto-slider mb-3 mt-3">


                    <!-- Slide -->
                    @foreach ($banner_products as $banner_product)
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="home-slider-container">
                                        <!-- Slide Title -->
                                        @php
                                            // get last word of from String =======
                                            $slide_product_name = $banner_product->product_name;
                                            $explode_text = explode(' ',$slide_product_name);
                                            $last_word = array_pop($explode_text); 

                                            // Remove Last Word from String ========
                                            $remove_last_word = substr($slide_product_name, 0, strrpos($slide_product_name, " "));
                                        @endphp
                                        
                                        <div class="home-slider-desc d-flex justify-content-around">
                                            <div class="home-slider-title mb-4" style="margin-top: 50px">
                                                <h5 class="fs-sm ft-ragular mb-4">New Collection</h5>
                                                <a href="{{route('product.details', $banner_product->slug)}}">
                                                    <h1 class="mb-4 ft-bold">{{$remove_last_word}} <span style="color: #f33066">{{$last_word}}</span></h1>
                                                </a>
                                                <span class="trending">{{$banner_product->key_features}}</span>
                                                <div style="margin-top: 50px">
                                                    <a href="{{route('product.details', $banner_product->slug)}}" class="btn btn-white stretched-link hover-black">Buy Now<i class="lni lni-arrow-right ml-2"></i></a>
                                                </div>
                                            </div>
                                            <div>
                                                <img width="350" src="{{asset('uploads/product/preview')}}/{{$banner_product->preview}}" alt="">
                                            </div>
                                        </div>                                       
                                        <!-- Slide Title / End -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            
        </div>
    </div>
</section>
<!-- ======================= Category & Slider ======================== -->

<!-- ======================= Product List ======================== -->
<section class="middle">
    <div class="container">
    
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center">
                    <h2 class="off_title">Trendy Products</h2>
                    <h3 class="ft-bold pt-3">Our Trending Products</h3>
                </div>
            </div>
        </div>
        
        <div class="row align-items-center rows-products">			
            <!-- Single -->
            

            @foreach ($products as $product)
                <div class="col-xl-3 col-lg-4 col-md-6 col-6 ">
                    <div class="product_grid card b-0">
                        @if ($product->discount)
                            <div class="badge bg-info text-white position-absolute ab-left text-upper" style="font-size: 13px">-{{$product->discount}}%</div>
                            <div class="badge position-absolute ft-regular ab-right text-upper" onMouseOver="this.style.background='#cc164a'" onMouseOut="this.style.background='#f33066'" style="background: #f33066">
                                <a href="{{route('wish.store_again', $product->id)}}" style="color: #fff"><i class="far fa-heart fs-lg"></i></a>
                            </div>
                            
                            @else
                            <div class="badge bg-success text-white position-absolute ab-left text-upper" style="font-size: 13px">New</div>
                            <div class="badge position-absolute ft-regular ab-right text-upper" onMouseOver="this.style.background='#cc164a'" onMouseOut="this.style.background='#f33066'" style="background: #f33066">
                                <a href="{{route('wish.store_again', $product->id)}}" style="color: #fff"><i class="far fa-heart fs-lg"></i></a>
                            </div>
                        @endif
                        <div class="card-body p-0">
                            <div class="shop_thumb position-relative">
                                <a class="card-img-top d-block overflow-hidden" href="{{route('product.details', $product->slug)}}">
                                    <img class="card-img-top" src="{{asset('uploads/product/preview')}}/{{$product->preview}}" alt="...">
                                </a>
                            </div>
                        </div>
                        <div class="card-footer b-0 p-0 pt-2 bg-white d-flex align-items-start justify-content-between">
                            <div class="text-left">
                                <div class="text-left">
                                    <div class="elso_titl"><span class="small">{{$product->rel_to_catagory->catagory_name}}</span></div>
                                    <h5 class="fs-md mb-0 lh-1 mb-1 product_name_hover"><a href="{{route('product.details', $product->slug)}}">{{$product->product_name}}</a></h5>

                                    {{-- ======= rating start ======= --}}
                                    @php
                                        $review_count = App\Models\OrderProduct::where('product_id', $product->id)->whereNotNull('review')->count();

                                         $review_sum = App\Models\OrderProduct::where('product_id', $product->id)->whereNotNull('review')->sum('star');
                                    @endphp

                                    @if ($review_count != 0)                                   
                                        @php
                                            $average_rating = round($review_sum/$review_count);
                                        @endphp

                                        <div class="star-rating align-items-center d-flex justify-content-left mb-2 p-0">
                                            @for ($i=1; $i<=$average_rating; $i++)
                                                <i class="fas fa-star filled"></i>
                                            @endfor
                                            @for ($i=1; $i<=5-$average_rating; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                        </div>
                                        @else
                                        <div class="star-rating align-items-center d-flex justify-content-left mb-2 p-0">
                                            @for ($i=1; $i<=5; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                        </div>
                                    @endif
                                    {{-- ======= rating end ======= --}}

                                    <div class="elis_rty">
                                        @if ($product->discount)
                                            <span class="ft-medium text-muted line-through fs-md mr-2">&#2547; {{$product->price}}/-</span>
                                        @endif
                                        <span class="ft-bold text-dark fs-sm">&#2547; {{$product->after_discount}}/-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="position-relative text-center">
                    <a href="{{route('shop')}}" class="btn stretched-link borders">Explore More<i class="lni lni-arrow-right ml-2"></i></a>
                </div>
            </div>
        </div>
        
    </div>
</section>
<!-- ======================= Product List ======================== -->

<!-- ======================= Brand Start ============================ -->
<section class="py-3 br-top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="smart-brand">
                    
                    <div class="single-brnads">
                        <img src="assets/img/shop-logo-1.png" class="img-fluid" alt="" />
                    </div>
                    
                    <div class="single-brnads">
                        <img src="assets/img/shop-logo-2.png" class="img-fluid" alt="" />
                    </div>
                    
                    <div class="single-brnads">
                        <img src="assets/img/shop-logo-3.png" class="img-fluid" alt="" />
                    </div>
                    
                    <div class="single-brnads">
                        <img src="assets/img/shop-logo-4.png" class="img-fluid" alt="" />
                    </div>
                    
                    <div class="single-brnads">
                        <img src="assets/img/shop-logo-5.png" class="img-fluid" alt="" />
                    </div>
                    
                    <div class="single-brnads">
                        <img src="assets/img/shop-logo-6.png" class="img-fluid" alt="" />
                    </div>
                    
                    <div class="single-brnads">
                        <img src="assets/img/shop-logo-1.png" class="img-fluid" alt="" />
                    </div>
                    
                    <div class="single-brnads">
                        <img src="assets/img/shop-logo-2.png" class="img-fluid" alt="" />
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ======================= Brand Start ============================ -->

<!-- ======================= Tag Wrap Start ============================ -->
<section class="bg-cover" style="background:url({{asset('frontend/img/e-middle-banner.png')}}) no-repeat;">
    <div class="ht-60"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12">
                <div class="tags_explore text-center">
                    <h2 class="mb-0 text-white ft-bold">Big Sale Up To 70% Off</h2>
                    <p class="text-light fs-lg mb-4">Exclussive Offers For Limited Time</p><p>
                    <a href="#" class="btn btn-lg bg-white px-5 text-dark ft-medium">Explore Your Order</a>
                </p></div>
            </div>
        </div>
    </div>
    <div class="ht-60"></div>
</section>
<!-- ======================= Tag Wrap Start ============================ -->

<!-- ======================= All Category ======================== -->
<section class="middle">
    <div class="container">
    
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center">
                    <h2 class="off_title">Popular Categories</h2>
                    <h3 class="ft-bold pt-3">Trending Categories</h3>
                </div>
            </div>
        </div>
        
        <div class="row align-items-center justify-content-center">
            @foreach ($catagories as $catagory)
                <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6 col-4">
                    <div class="cats_side_wrap text-center mx-auto mb-3">
                        <div class="sl_cat_01">
                            <div class="d-inline-flex align-items-center justify-content-center p-4  mb-2  catagory_border">
                                <a href="{{route('catagory_product', $catagory->id)}}" class="d-block">
                                    <img src="{{asset('uploads/catagory')}}/{{$catagory->catagory_image}}" class="img-fluid" width="40" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="sl_cat_02">
                            <h6 class="m-0 ft-medium fs-sm">
                                <a href="{{route('catagory_product', $catagory->id)}}" class="catagory_hover">{{$catagory->catagory_name}}</a>
                            </h6>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
    </div>
</section>
<!-- ======================= All Category ======================== -->

<!-- ======================= Customer Review ======================== -->
<section class="gray">
    <div class="container">
    
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center">
                    <h2 class="off_title">Testimonials</h2>
                    <h3 class="ft-bold pt-3">Client Reviews</h3>
                </div>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12">
                <div class="reviews-slide px-3">
                    
                    <!-- single review -->
                    <div class="single_review">
                        <div class="sng_rev_thumb"><figure><img src="assets/img/team-1.jpg" class="img-fluid circle" alt="" /></figure></div>
                        <div class="sng_rev_caption text-center">
                            <div class="rev_desc mb-4">
                                <p class="fs-md">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.</p>
                            </div>
                            <div class="rev_author">
                                <h4 class="mb-0">Mark Jevenue</h4>
                                <span class="fs-sm">CEO of Addle</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- single review -->
                    <div class="single_review">
                        <div class="sng_rev_thumb"><figure><img src="assets/img/team-2.jpg" class="img-fluid circle" alt="" /></figure></div>
                        <div class="sng_rev_caption text-center">
                            <div class="rev_desc mb-4">
                                <p class="fs-md">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.</p>
                            </div>
                            <div class="rev_author">
                                <h4 class="mb-0">Henna Bajaj</h4>
                                <span class="fs-sm">Aqua Founder</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- single review -->
                    <div class="single_review">
                        <div class="sng_rev_thumb"><figure><img src="assets/img/team-3.jpg" class="img-fluid circle" alt="" /></figure></div>
                        <div class="sng_rev_caption text-center">
                            <div class="rev_desc mb-4">
                                <p class="fs-md">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.</p>
                            </div>
                            <div class="rev_author">
                                <h4 class="mb-0">John Cenna</h4>
                                <span class="fs-sm">CEO of Plike</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- single review -->
                    <div class="single_review">
                        <div class="sng_rev_thumb"><figure><img src="assets/img/team-4.jpg" class="img-fluid circle" alt="" /></figure></div>
                        <div class="sng_rev_caption text-center">
                            <div class="rev_desc mb-4">
                                <p class="fs-md">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.</p>
                            </div>
                            <div class="rev_author">
                                <h4 class="mb-0">Madhu Sharma</h4>
                                <span class="fs-sm">Team Manager</span>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ======================= Customer Review ======================== -->

<!-- ======================= Top product list ============================ -->
<section class="space min">
    <div class="container">
        <div class="row top_selled_rated_recent_product">

            <!-- ====== Top selling product ====== -->
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12" style="border-right: 1px solid #d2d2d2;">
                <div class="top-seller-title top_product_head"><h4 class="ft-medium">Top Selling Product</h4></div>
                
                <div class="ftr-content view_all">
                    @foreach ($top_selling_products as $top_product)
                        <div class="product_grid row">
                            <div class="col-xl-4 col-lg-5 col-md-5 col-4">
                                <div class="shop_thumb position-relative">
                                    <a class="card-img-top d-block overflow-hidden" href="{{route('product.details', $top_product->rel_to_product->slug)}}"><img class="card-img-top" src="{{asset('uploads/product/preview')}}/{{$top_product->rel_to_product->preview}}" alt="..."></a>
                                </div>
                            </div>
                            <div class="col-xl-8 col-lg-7 col-md-7 col-8 pl-0">
                                <div class="text-left mfliud">
                                    <div class="elso_titl"><span class="small">{{$top_product->rel_to_product->rel_to_catagory->catagory_name}}</span></div>
                                    <h5 class="fs-md mb-0 lh-1 mb-1 ft-medium"><a href="{{route('product.details', $top_product->rel_to_product->slug)}}">{{$top_product->rel_to_product->product_name}}</a></h5>
                                    

                                    {{-- ======= rating start ======= --}}
                                    @php
                                        $review_count = App\Models\OrderProduct::where('product_id', $top_product->rel_to_product->id)->whereNotNull('review')->count();

                                         $review_sum = App\Models\OrderProduct::where('product_id', $top_product->rel_to_product->id)->whereNotNull('review')->sum('star');
                                    @endphp

                                    @if ($review_count != 0)                                   
                                        @php
                                            $average_rating = round($review_sum/$review_count);
                                        @endphp

                                        <div class="star-rating align-items-center d-flex justify-content-left mb-2 p-0">
                                            @for ($i=1; $i<=$average_rating; $i++)
                                                <i class="fas fa-star filled"></i>
                                            @endfor
                                            @for ($i=1; $i<=5-$average_rating; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                        </div>
                                        @else
                                        <div class="star-rating align-items-center d-flex justify-content-left mb-2 p-0">
                                            @for ($i=1; $i<=5; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                        </div>
                                    @endif
                                    {{-- ======= rating end ======= --}}

                                    <div class="elis_rty">
                                        @if ($top_product->rel_to_product->discount)
                                            <div>
                                                <span class="ft-medium text-muted line-through fs-md mr-2">&#2547; {{$top_product->rel_to_product->price}}/-</span>
                                            </div>
                                        @endif
                                        <div>
                                            <span class="ft-bold text-dark fs-sm">&#2547; {{$top_product->rel_to_product->after_discount}}/-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- ====== Top rated product ====== -->
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12" style="border-right: 1px solid #d2d2d2">
                <div class="ftr-title top_product_head"><h4 class="ft-medium">Top Rated Products</h4></div>
                <div class="ftr-content view_all">
                    @foreach ($top_rated_products as $top_rated_product)
                        <div class="product_grid row">
                            <div class="col-xl-4 col-lg-5 col-md-5 col-4">
                                <div class="shop_thumb position-relative">
                                    <a class="card-img-top d-block overflow-hidden" href="{{route('product.details', $top_rated_product->rel_to_product->slug)}}"><img class="card-img-top" src="{{asset('uploads/product/preview')}}/{{$top_rated_product->rel_to_product->preview}}" alt="..."></a>
                                </div>
                            </div>
                            <div class="col-xl-8 col-lg-7 col-md-7 col-8 pl-0">
                                <div class="text-left mfliud">
                                    <div class="elso_titl"><span class="small">{{$top_rated_product->rel_to_product->rel_to_catagory->catagory_name}}</span></div>
                                    <h5 class="fs-md mb-0 lh-1 mb-1 ft-medium"><a href="{{route('product.details', $top_rated_product->rel_to_product->slug)}}">{{$top_rated_product->rel_to_product->product_name}}</a></h5>
                                    

                                    {{-- ======= rating start ======= --}}
                                    @php
                                        $review_count = App\Models\OrderProduct::where('product_id', $top_rated_product->rel_to_product->id)->whereNotNull('review')->count();

                                         $review_sum = App\Models\OrderProduct::where('product_id', $top_rated_product->rel_to_product->id)->whereNotNull('review')->sum('star');
                                    @endphp

                                    @if ($review_count != 0)                                   
                                        @php
                                            $average_rating = round($review_sum/$review_count);
                                        @endphp

                                        <div class="star-rating align-items-center d-flex justify-content-left mb-2 p-0">
                                            @for ($i=1; $i<=$average_rating; $i++)
                                                <i class="fas fa-star filled"></i>
                                            @endfor
                                            @for ($i=1; $i<=5-$average_rating; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                        </div>
                                        @else
                                        <div class="star-rating align-items-center d-flex justify-content-left mb-2 p-0">
                                            @for ($i=1; $i<=5; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                        </div>
                                    @endif
                                    {{-- ======= rating end ======= --}}

                                    <div class="elis_rty">
                                        @if ($top_rated_product->rel_to_product->discount)
                                            <div>
                                                <span class="ft-medium text-muted line-through fs-md mr-2">&#2547; {{$top_rated_product->rel_to_product->price}}/-</span>
                                            </div>
                                        @endif
                                        <div>
                                            <span class="ft-bold text-dark fs-sm">&#2547; {{$top_rated_product->rel_to_product->after_discount}}/-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- ====== Recent product ====== -->
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 ">
                <div class="ftr-title top_product_head"><h4 class="ft-medium">Recent Products</h4></div>
                <div class="ftr-content view_all">
                    @foreach ($recent_products as $recent_product)
                        <div class="product_grid row">
                            <div class="col-xl-4 col-lg-5 col-md-5 col-4">
                                <div class="shop_thumb position-relative">
                                    <a class="card-img-top d-block overflow-hidden" href="{{route('product.details', $recent_product->slug)}}"><img class="card-img-top" src="{{asset('uploads/product/preview')}}/{{$recent_product->preview}}" alt="..."></a>
                                </div>
                            </div>
                            <div class="col-xl-8 col-lg-7 col-md-7 col-8 pl-0">
                                <div class="text-left mfliud">
                                    <div class="elso_titl"><span class="small">{{$recent_product->rel_to_catagory->catagory_name}}</span></div>
                                    <h5 class="fs-md mb-0 lh-1 mb-1 ft-medium"><a href="{{route('product.details', $recent_product->slug)}}">{{$recent_product->product_name}}</a></h5>
                                    

                                    {{-- ======= rating start ======= --}}
                                    @php
                                        $review_count = App\Models\OrderProduct::where('product_id', $recent_product->id)->whereNotNull('review')->count();

                                         $review_sum = App\Models\OrderProduct::where('product_id', $recent_product->id)->whereNotNull('review')->sum('star');
                                    @endphp

                                    @if ($review_count != 0)                                   
                                        @php
                                            $average_rating = round($review_sum/$review_count);
                                        @endphp

                                        <div class="star-rating align-items-center d-flex justify-content-left mb-2 p-0">
                                            @for ($i=1; $i<=$average_rating; $i++)
                                                <i class="fas fa-star filled"></i>
                                            @endfor
                                            @for ($i=1; $i<=5-$average_rating; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                        </div>
                                        @else
                                        <div class="star-rating align-items-center d-flex justify-content-left mb-2 p-0">
                                            @for ($i=1; $i<=5; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                        </div>
                                    @endif
                                    {{-- ======= rating end ======= --}}

                                    <div class="elis_rty">
                                        @if ($recent_product->discount)
                                            <div>
                                                <span class="ft-medium text-muted line-through fs-md mr-2">&#2547; {{$recent_product->price}}/-</span>
                                            </div>
                                        @endif
                                        <div>
                                            <span class="ft-bold text-dark fs-sm">&#2547; {{$recent_product->after_discount}}/-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
        </div>
        
    </div>
</section>
<!-- ======================= Top product list ============================ -->
@endsection

@section('footer_script')

    @if (session('wish_again_success'))
        <script>
            Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: "{{session('wish_again_success')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

    @if (session('product_just_deleted'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'info',
            title: 'Sorry',
            text:  "{{session('product_just_deleted')}}",
            confirmButtonText:'Refresh',
            confirmButtonColor:'#000000cc',
            background: '#0000009d',
            color: '#ffffff'
            })
        </script>
    @endif

    @if (session('github_login_register_success'))
        <script>
            Swal.fire({
			position: 'top-end',
            icon: 'success',
            title: "{{session('github_login_register_success')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

    @if (session('gmail_login_register_success'))
        <script>
            Swal.fire({
			position: 'top-end',
            icon: 'success',
            title: "{{session('gmail_login_register_success')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif
	
@endsection 

