@extends('frontend.master')

@section('content')
    <!-- ======================= Top Breadcrubms ======================== -->
    <div class="gray py-3">
        <div class="container">
            <div class="row">
                <div class="colxl-12 col-lg-12 col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('front.home')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Catagory Product</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ======================= Top Breadcrubms ======================== -->
    <section class="middle">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                    <div class="killore-new-block-link border mb-3 mt-3">
                        <div class="px-3 py-3 ft-medium fs-md text-dark gray">Top Categories</div>
                        
                        <div class="killore--block-link-content">
                            <ul>
                                @foreach ($catagories_all as $catagory_all)
                                    <li><a href="{{route('catagory_product', $catagory_all->id)}}"><img width="30" src="{{asset('uploads/catagory')}}/{{$catagory_all->catagory_image}}" alt="">&nbsp; &nbsp; {{$catagory_all->catagory_name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
                    <div class="row justify-content-center">
                        @php
                            $catagory = App\Models\Catagory::find($catagories);
                        @endphp
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="sec_title position-relative text-center">
                                <h2 class="off_title">{{$catagory->catagory_name}}</h2>
                                <h3 class="ft-bold pt-3">{{$catagory->catagory_name}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center rows-products">			
                        <!-- Single -->
                        @php
                            $products = App\Models\Product::where('catagory_id', $catagories)->get();
                        @endphp
                        @foreach ($products as $product)
                            <div class="col-xl-4 col-lg-4 col-md-6 col-6">
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
                                                <h5 class="fs-md mb-0 lh-1 mb-1"><a href="{{route('product.details', $product->slug)}}">{{$product->product_name}}</a></h5>
                                                

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
                </div>
            </div>  
        </div>
    </section>


@endsection

@section('footer_script')



@endsection