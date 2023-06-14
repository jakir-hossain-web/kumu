@extends('frontend.master')

<style>
    .custom-select {
        color: #495057 !important;
        transition: .2s;
    }
    .custom-select:hover {
        border: 1px solid #000026 !important;
    }
    ul.dahs_navbar li a:hover{
        transition: .3s;
    }
    ul.dahs_navbar li a:hover{
        color: #ee1c47;
    }
    .order_main{
        transition: .2s;
    }
    .order_main:hover{
        border: 1px solid #c8c9c9 !important;
    }
    .order_top{
        position: relative;
        transition: .2s;
    }
    .order_main:hover .order_top{
        background: #c8c9c9;
        cursor: pointer;
        border: 1px solid #c8c9c9 !important;
    }
    .order_main:hover .arrow_down{
        color: #616163;
    }
    .Download_invoice_main{
        position: absolute;
        top: 50%;
        right: 130px;
        transform: translate(-0%, -50%);
    }
    .order_top_arrow{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .order_top_arrow .arrow_down{
        transition: .2s;
        color: #a1a2a5;
    }
    .order_middle{
        display: none;
        position: relative;
        overflow-y: hidden;
    }
    .order_btn_calculation{
        position: absolute;
        bottom: 50%;
        right: 0;
        padding: 20% 30px;
        transform: translateY(50%);
        background: #f4f5f7;
        border: 1px solid #e9ecef;
    }
    .order_btn_calculation h5{
        color:  #636872;
    }
    .order_top{
        border: 1px solid #e9ecef;
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
                        <li class="breadcrumb-item active">My Order</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->
<!-- ======================= Profile Detail ======================== -->
<section class="middle">
    <div class="container">
        <div class="row align-items-start justify-content-between">
        
            <div class="col-12 col-md-12 col-lg-4 col-xl-4 text-center miliods">
                <div class="d-block border rounded mfliud-bot">
                    <div class="dashboard_author px-2 py-5">
                        <div class="dash_auth_thumb circle p-1 border d-inline-flex mx-auto mb-2">
                            @if ($customer_info->profile_image == null)
                                <img class="img-fluid circle" width="100" src="{{ Avatar::create($customer_info->name)->toBase64() }}" alt="Profile Image"/>
                                @else
                                <img class="img-fluid circle" width="100" src="{{asset('uploads/customer')}}/{{$customer_info->profile_image}}" alt="Profile Image">
                            @endif
                        </div>

                        <div class="dash_caption">
                            <h4 class="fs-md ft-medium mb-0 lh-1">{{$customer_info->name}}</h4>
                            <span class="text-muted smalls">{{$customer_info->country_id!=null?$customer_info->rel_to_country->name:''}}</span>

                        </div>
                    </div>
                    
                    <div class="dashboard_author">
                        <h4 class="px-3 py-2 mb-0 lh-2 gray fs-sm ft-medium text-muted text-uppercase text-left">Dashboard Navigation</h4>
                        <ul class="dahs_navbar">
                            <li><a href="{{route('customer.customer_order')}}" class="active"><i class="lni lni-shopping-basket mr-2"></i>My Order</a></li>
                            <li><a href="{{route('customer.customer_wish')}}"><i class="lni lni-heart mr-2"></i>Wishlist</a></li>
                            <li><a href="{{route('customer.profile')}}"><i class="lni lni-user mr-2"></i>Profile Info</a></li>
                            <li><a href="{{route('customer.logout')}}"><i class="lni lni-power-switch mr-2"></i>Log Out</a></li>
                        </ul>
                    </div>
                    
                </div>
            </div>

            {{-- =========== order list start ============= --}}
            <div class="col-12 col-md-12 col-lg-8 col-xl-8 text-center">
                @forelse (App\Models\Order::where('customer_id', Auth::guard('customerlogin')->id())->orderBy('created_at','desc')->get() as $order)
                    <div class="ord_list_wrap border mb-4 order_main">

                        {{-- ======== customer order top ======== --}}
                        <div class="ord_list_head gray  px-3 py-3 order_top">
                            <div class="order_top_top d-flex align-items-center justify-content-between">
                                <div class="olh_flex">
                                    <p class="m-0 p-0"><span class="text-muted">Order Number</span></p>
                                    <h6 class="mb-0 ft-medium">{{$order->order_id}}</h6>
                                </div>

                                <div class="col-xl-2 col-lg-2 col-md-2 col-12 ml-auto">
                                    <p class="mb-1 p-0"><span class="text-muted">Status</span></p>
                                    <div class="delv_status">
                                        <span class="ft-medium rounded px-3 py-1">
                                            @if ($order->order_status == 1)
                                                <span class="badge text-white" style="background: #0B2A97">{{'Placed'}}</span>
                                                @elseif ($order->order_status == 2)
                                                <span class="badge text-white bg-success">{{'Confirmed'}}</span>
                                                @elseif ($order->order_status == 3)
                                                <span class="badge text-white bg-warning">{{'Processing'}}</span>
                                                @elseif ($order->order_status == 4)
                                                <span class="badge text-white" style="background: #A02CFA">{{'On Delivery'}}</span>
                                                @elseif ($order->order_status == 5)
                                                <span class="badge text-white bg-info">{{'Delivered'}}</span>
                                                @else
                                                <span class="badge text-white bg-danger">{{'Canceled'}}</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>    
                            </div>	

                            <div class="order_top_arrow m-auto">
                                <i class="fa fa-chevron-down arrow" style="font-size: 25px;"></i>
                                <i class="fa fa-chevron-up arrow d-none" style="font-size: 25px;"></i>
                            </div>	

                            <div class="Download_invoice_main">
                                <a href="{{route('Download_invoice', substr($order->order_id,1))}}" class="Download_invoice_btn badge text-white p-2" style="background: #0B2A97; font-size:14px">Download Invoice</a>
                            </div>
                        </div>

                        {{-- ======== customer order middle ======== --}}
                        <div class="ord_list_body text-left order_middle">
                            @foreach (App\Models\OrderProduct::where('customer_id', Auth::guard('customerlogin')->id())->where('order_id', $order->order_id)->get() as $order_product)
                                <div class="row align-items-center m-0 py-4 br-bottom">
                                    <div class="col-xl-5 col-lg-5 col-md-5 col-12">
                                        <div class="cart_single d-flex align-items-start mfliud-bot">
                                            <div class="cart_selected_single_thumb">
                                                <a href="#"><img src="{{asset('uploads/product/preview')}}/{{$order_product->rel_to_product->preview}}" width="75" class="img-fluid rounded" alt=""></a>
                                            </div>
                                            <div class="cart_single_caption pl-3">
                                                <p class="mb-0"><span class="text-muted small">{{$order_product->rel_to_product->rel_to_catagory->catagory_name}}</span></p>
                                                
                                                <h4 class="product_title fs-sm ft-medium mb-1 lh-1">{{$order_product->rel_to_product->product_name}}</h4>

                                                <p class="mb-2"><span class="text-dark medium">Size: {{$order_product->rel_to_size->size_name}}</span>, <span class="text-dark medium">Color: {{$order_product->rel_to_color->color_name}}</span></p>

                                                <h4 class="fs-sm ft-bold mb-0 lh-1">&#2547; {{number_format(round($order_product->after_discount))}}/- ({{$order_product->quantity}})</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach  
                            
                            <div class="order_btn_calculation" style="width: 35%">
                                <h5 class="mb-0 fs-sm">
                                    <div class="d-flex justify-content-between">
                                        <div style="padding-left: 22px">Sub Total:</div> 
                                        <div>&#2547; {{number_format(round($order->sub_total - $order->sales_discount))}}/-</div>
                                    </div>
                                </h5>
                                <h5 class="mb-0 fs-sm">
                                    <div class="d-flex justify-content-between">
                                        <div>(+) Delivery Charge:</div> 
                                        <div>&#2547;  {{number_format(round($order->delivery_charge))}}/-</div>
                                    </div>
                                </h5>
                                    <h5 class="mb-0 fs-sm">
                                    <div class="d-flex justify-content-between">
                                        <div style="padding-left: 2px"> (--) Coupon Discount:</div> 
                                        <div>&#2547; {{number_format(round($order->coupon_discount))}}/-</div>
                                    </div>
                                </h5>
                            </div>
                        </div>

                        {{-- ======== customer order bottom ======== --}}
                        <div class="ord_list_footer d-flex align-items-center justify-content-between br-top px-3 order_bottom">
                            <div class="col-xl-12 col-lg-12 col-md-12 pl-0 py-2 olf_flex d-flex align-items-center justify-content-between">
                                <div class="olf_flex_inner ">
                                    <p class="m-0 p-0"><span class="text-muted medium text-left">Order Date: {{$order->created_at->format('d-M-Y')}}</span></p>
                                </div>
                                <div class="payment_method">
                                    @if ($order->payment_method == 1)
                                        <p class="bg-light-success text-success rounded px-3 py-1 m-0 p-0">Cash On Delivery</p>

                                        @elseif ($order->payment_method == 2)
                                        <p class="bg-light-success text-success rounded px-3 py-1 m-0 p-0">SSL Commerce</p>

                                        @else
                                        <p class="bg-light-success text-success rounded px-3 py-1 m-0 p-0">Stripe Payment</p>
                                    @endif
                                </div>

                                <div class="olf_inner_right" style="width: 30%">
                                    <h5 class="mb-0 fs-sm ft-bold">
                                        <div class="d-flex justify-content-between">
                                            <div>Total Amount:</div> 
                                            <div>&#2547; {{number_format(round($order->total))}}/-</div>
                                        </div>
                                    </h5>
                                </div>
                            </div>
                        </div>

                    </div>
                    @empty
                        <h1 class="alert alert-danger ">No Order Placed Yet!</h1>
                @endforelse
            </div>
            {{-- =========== order list end ============= --}}

            
        </div>
    </div>
</section>
<!-- ======================= Dashboard Detail End ======================== -->

@endsection


@section('footer_script')

    {{-- ======= my order item slidetoggle ======= --}}
    <script>
        $('.order_top').click(function(){
            $(this).nextAll('.order_middle').slideToggle();
            $(this).find('.arrow').toggleClass('d-none');
        })
    </script>


    @if (session('customer_profile_update'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('customer_profile_update')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif
	
@endsection 