@extends('frontend.master')

@section('content')

<!-- ======================= Shop Style 1 ======================== -->
    <section class="bg-cover" style="background:url({{asset('frontend/img/banner-2.png')}}) no-repeat;">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="text-left py-5 mt-3 mb-3">
                        <h1 class="ft-medium mb-3">Shop</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ======================= Shop Style 1 ======================== -->
    
    
    <!-- ======================= Filter Wrap Style 1 ======================== -->
    <section class="py-3 br-bottom br-top">
        @if (@$_GET['catagory'] != null)
            
        @endif
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            
                            @if (@$_GET['catagory'] == null || @$_GET['catagory'] == 'undefined')
                                <li class="breadcrumb-item"><a href="{{route('front.home')}}">Home</a></li>
                                <li class="breadcrumb-item active">Shop</li>

                                @else
                                <li class="breadcrumb-item"><a href="{{route('front.home')}}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{route('shop')}}">Shop</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    @php
                                        $bread_cum_cata = App\Models\Catagory::where('id', @$_GET['catagory'])->get()->first();
                                        print_r($bread_cum_cata->catagory_name);
                                    @endphp
                                </li>
                            @endif
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        
    </section>
    <!-- ============================= Filter Wrap ============================== -->
    
    
    <!-- ======================= All Product List ======================== -->
    <section class="middle">
        <div class="container">
            <div class="row">
                
                <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 p-xl-0">
                    <div class="search-sidebar sm-sidebar border">
                        <div class="search-sidebar-body">
                            <!-- Single Option -->
                            <div class="mt-2">
                                <div class="form-group px-3">
                                    <a href="{{route('shop')}}" class="btn form-control bg-dark text-white" id="reset_btn">Reset</a>
                                </div>
                            </div>
                            <div class="single_search_boxed">
                                <div class="widget-boxed-header">
                                    <h4><a href="#pricing" data-toggle="collapse" aria-expanded="false" role="button">Pricing</a></h4>
                                </div>
                                <div class="widget-boxed-body collapse show" id="pricing" data-parent="#pricing">
                                    <div class="row">
                                        <div class="col-lg-6 pr-1">
                                            <div class="form-group pl-3">
                                                <input type="number" class="form-control min" placeholder="Min" value="{{@$_GET['min']}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 pl-1">
                                            <div class="form-group pr-3">
                                                <input type="number" class="form-control max" placeholder="Max" value="{{@$_GET['max']}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group px-3">
                                                <button type="submit" class="btn form-control" id="submit_btn">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ============== catagoty ==================== -->
                            <div class="single_search_boxed">
                                <div class="widget-boxed-header">
                                    <h4><a href="#Categories" data-toggle="collapse" aria-expanded="false" role="button">Categories</a></h4>
                                </div>
                                <div class="widget-boxed-body collapse show" id="Categories" data-parent="#Categories">
                                    <div class="side-list no-border">
                                        <!-- Single Filter Card -->
                                        <div class="single_filter_card">
                                            <div class="card-body pt-0">
                                                <div class="inner_widget_link">
                                                    <ul class="no-ul-list">
                                                        @foreach ($catagories as $catagory)
                                                            <li>
                                                                <input id="category{{$catagory->id}}" class="catagory_id" name="catagory" type="radio" value="{{$catagory->id}}" {{@$_GET['catagory']==$catagory->id?'checked':''}}>
                                                                <label for="category{{$catagory->id}}" class="checkbox-custom-label">{{$catagory->catagory_name}}<span>{{App\Models\Product::where('catagory_id', $catagory->id)->count()}}</span></label>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ============== brand ==================== -->
                            <div class="single_search_boxed">
                                <div class="widget-boxed-header">
                                    <h4><a href="#brands" data-toggle="collapse" aria-expanded="false" role="button">Brands</a></h4>
                                </div>
                                <div class="widget-boxed-body collapse show" id="brands" data-parent="#brands">
                                    <div class="side-list no-border">
                                        <!-- Single Filter Card -->
                                        <div class="single_filter_card">
                                            <div class="card-body pt-0">
                                                <div class="inner_widget_link">
                                                    <ul class="no-ul-list">
                                                        <li>
                                                            <input id="brands1" class="checkbox-custom" name="brands" type="radio">
                                                            <label for="brands1" class="checkbox-custom-label">Sumsung<span>142</span></label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ============== color ==================== -->
                            <div class="single_search_boxed">
                                <div class="widget-boxed-header">
                                    <h4><a href="#colors" data-toggle="collapse" class="collapsed" aria-expanded="false" role="button">Colors</a></h4>
                                </div>
                                <div class="widget-boxed-body collapse" id="colors" data-parent="#colors">
                                    <div class="side-list no-border">
                                        <!-- Single Filter Card -->
                                        <div class="single_filter_card">
                                            <div class="card-body pt-0">
                                                <div class="text-left">
                                                    @foreach ($colors as $color)  
                                                        <div class="form-check form-option form-check-inline mb-1">
                                                            <input class="color_id" type="radio" name="color" id="color{{$color->id}}" value="{{$color->id}}" {{@$_GET['color']==$color->id?'checked':''}}>
                                                            <label title="{{$color->color_name}}" class="form-option-label rounded-circle" for="color{{$color->id}}">
                                                                @if ($color->id == 1)
                                                                    <span class="form-option-color rounded-circle" style="background: {{$color->color_code}}">N/A</span>
                                                                @endif
                                                                <span class="form-option-color rounded-circle" style="background: {{$color->color_code}}"></span>
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- ============== size ==================== -->
                            <div class="single_search_boxed">
                                <div class="widget-boxed-header">
                                    <h4><a href="#size" data-toggle="collapse" class="collapsed" aria-expanded="false" role="button">Size</a></h4>
                                </div>
                                <div class="widget-boxed-body collapse" id="size" data-parent="#size">
                                    <div class="side-list no-border">
                                        <!-- Single Filter Card -->
                                        <div class="single_filter_card">
                                            <div class="card-body pt-0">
                                                <div class="text-left pb-0 pt-2">
                                                    @foreach ($sizes as $size)
                                                        <div class="form-check form-option form-check-inline mb-2">
                                                            <input class="size_id" type="radio" name="size" id="size{{$size->id}}" value="{{$size->id}}" {{@$_GET['size']==$size->id?'checked':''}}>
                                                            <label class="form-option-label" for="size{{$size->id}}">{{$size->size_name}}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12">
                    
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="border mb-3 mfliud">
                                <div class="row align-items-center py-2 m-0">
                                    <div class="col-xl-3 col-lg-4 col-md-5 col-sm-12">
                                        <h6 class="mb-0">Searched Products Found</h6>
                                    </div>
                                    
                                    <div class="col-xl-9 col-lg-8 col-md-7 col-sm-12">
                                        <div class="filter_wraps d-flex align-items-center justify-content-end m-start">
                                            <div class="single_fitres mr-2 br-right">
                                                <select class="custom-select simple sort">
                                                    <option value="">Default Sorting</option>
                                                    <option value="1" {{@$_GET['sort']==1?'selected':''}}>Sort by price: Low - High price</option>
                                                    <option value="2" {{@$_GET['sort']==2?'selected':''}}>Sort by price: High - Low price</option>
                                                    <option value="3" {{@$_GET['sort']==3?'selected':''}}>Sort by name: A - Z</option>
                                                    <option value="4" {{@$_GET['sort']==4?'selected':''}}>Sort by name: Z - A</option>
                                                </select>
                                            </div>                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- row -->
                    <div class="row align-items-center rows-products">
                        <!-- =============== product =============== -->
                        @forelse ($products as $product)
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
                                        <a class="card-img-top d-block overflow-hidden" href="{{route('product.details', $product->slug)}}"><img class="card-img-top" src="{{asset('uploads/product/preview')}}/{{$product->preview}}" alt="..."></a>
                                    </div>
                                </div>
                                <div class="card-footer b-0 p-0 pt-2 bg-white">
                                    
                                    <div class="text-left">
                                        <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="{{route('product.details', $product->slug)}}">{{$product->product_name}}</a></h5>
                                        

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
                        @empty
                            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                <h3 class="text-center mt-5">No Product Found</h3>
                            </div>
                        @endforelse
                    </div>
                    <!-- row -->
                </div>
            </div>
        </div>
    </section>
    <!-- ======================= All Product List ======================== -->

@endsection


@section('footer_script')


@endsection 