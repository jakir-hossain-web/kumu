@extends('frontend.master')

<style>
    .kkk{
        display: flex;
    }
</style>

@section('content')
    <!-- ======================= Top Breadcrubms ======================== -->
    <div class="gray py-3">
        <div class="container">
            <div class="row">
                <div class="colxl-12 col-lg-12 col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('front.home')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Top Selling Product</li>
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
                                @foreach ($catagories as $catagory)
                                    <li><a href="{{route('catagory_product', $catagory->id)}}"><img width="30" src="{{asset('uploads/catagory')}}/{{$catagory->catagory_image}}" alt="">&nbsp; &nbsp; {{$catagory->catagory_name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- ====== Top selling product ====== -->
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 bg-info">
                    <div class="top-seller-title"><h4 class="ft-medium">Top Selling Product</h4></div>
                    <div class="row kkk">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-9 ftr-content bg-danger">
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
                        <div class="col-lg-8 bg-primary">
                            <h1>hello</h1>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </section>


@endsection

@section('footer_script')



@endsection