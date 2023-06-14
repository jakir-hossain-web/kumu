@extends('frontend.master')

<style>
    .select2-container .select2-selection--single {
        height: 52px !important;
    }
    .select2-container--default .select2-selection--single {
        border: 1px solid #e5e5e5 !important;
        border-radius: 0 !important;
        transition: .2s;
    }
    .select2-container--default .select2-selection--single:hover {
        border: 1px solid #000026 !important;
        border-radius: 0 !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #495057 !important;
        font-size: 1rem !important;
        line-height: 52px !important;
        padding-left: 15px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 52px !important;
        padding-right: 30px !important;
    }
    ul.dahs_navbar li a{
        transition: .3s;
    }
    ul.dahs_navbar li a:hover{
        color: #ee1c47;
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
                            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ======================= Top Breadcrubms ======================== -->

    <!-- ======================= Product Detail ======================== -->
    <section class="middle">
        <div class="container">
        
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="text-center d-block mb-5">
                        <h2>Checkout</h2>
                    </div>
                </div>
            </div>
            
            <div class="row justify-content-between">
                <div class="col-12 col-lg-7 col-md-12">
                    <form action="{{route('order.store')}}" method="POST">
                        @csrf
                        <h5 class="mb-4 ft-medium">Billing Details</h5>
                        <div class="row mb-2">
                            
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Full Name *</label>
                                    <input type="text" name="name" class="form-control" placeholder="First Name" />
                                    @error('name')
                                        <strong class="text-danger">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Email *</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email" />
                                    @error('email')
                                        <strong class="text-danger">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Company</label>
                                    <input type="text" name="company" class="form-control" placeholder="Company Name (optional)" />
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Mobile Number *</label>
                                    <input type="text" name="mobile" class="form-control" placeholder="Mobile Number" />
                                    @error('mobile')
                                        <strong class="text-danger">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Address *</label>
                                    <input type="text" name="address" class="form-control" placeholder="Address" />
                                    @error('address')
                                        <strong class="text-danger">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Country *</label>
                                    <select class="custom-select country_id" name="country_id">
                                        <option value="">--- Select Country ---</option>
                                        @foreach ($countries as $country) 
                                            <option value="{{$country->id}}">{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('country_id')
                                        <strong class="text-danger">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="text-dark">City / Town *</label>
                                    <select class="custom-select city_id" name="city_id">
                                        <option value="">-- Select City --</option>
                                    </select>
                                    @error('city_id')
                                        <strong class="text-danger">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="text-dark">ZIP / Postcode *</label>
                                    <input type="text" name="zip" class="form-control" placeholder="Zip / Postcode" />
                                </div>
                            </div>
                            
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="text-dark">Additional Information</label>
                                    <textarea class="form-control ht-50" name="notes"></textarea>
                                </div>
                            </div>
                            
                        </div>
                        
                    
                </div>
                
                <!-- Sidebar -->
                <div class="col-12 col-lg-4 col-md-12">
                    <div class="d-block mb-3">
                        <h5 class="mb-4">Order Items ({{App\Models\Cart::where('customer_id', Auth::guard('customerlogin')->id())->count()}})</h5>
                        <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x mb-4">
                            @foreach ($carts as $cart)
                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-3">
                                            <!-- Image -->
                                            <a href="{{route('product.details', $cart->rel_to_product->slug)}}"><img src="{{asset('uploads/product/preview')}}/{{$cart->rel_to_product->preview}}" alt="product image" class="img-fluid"></a>
                                        </div>
                                        <div class="col d-flex align-items-center">
                                            <div class="cart_single_caption pl-2">
                                                <a href="{{route('product.details', $cart->rel_to_product->slug)}}">
                                                    <h4 class="product_title fs-md ft-medium mb-1 lh-1">{{$cart->rel_to_product->product_name}}</h4>
                                                </a>
                                                <p class="mb-1 lh-1"><span class="text-dark">Size: {{$cart->rel_to_size->size_name}}</span></p>
                                                <p class="mb-3 lh-1"><span class="text-dark">Color: {{$cart->rel_to_color->color_name}}</span></p>
                                                <h4 class="fs-md ft-medium mb-3 lh-1">&#2547; {{number_format($cart->rel_to_product->after_discount)}}/- <span style="color: #7c7979">{{' '.'('.$cart->quantity.')'}}</span></h4>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <div class="mb-4">
                        <div class="form-group">
                            <h6>Delivery Location</h6>
                            <ul class="no-ul-list">
                                @foreach ($charges as $charge)
                                    <li>
                                        <input id="c1{{$charge->delivery_charge}}" class="radio-custom charge" name="charge" type="radio" value="{{$charge->delivery_charge}}">
                                        <label for="c1{{$charge->delivery_charge}}" class="radio-custom-label">{{$charge->delivery_type}}</label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="form-group">
                            <h6>Select Payment Method</h6>
                            <ul class="no-ul-list">
                                <li>
                                    <input id="c3" class="radio-custom" name="payment_method" value="1" type="radio">
                                    <label for="c3" class="radio-custom-label">Cash on Delivery</label>
                                </li>
                                <li>
                                    <input id="c4" class="radio-custom" name="payment_method" value="2" type="radio">
                                    <label for="c4" class="radio-custom-label">Pay With SSLCommerz</label>
                                </li>
                                <li>
                                    <input id="c5" class="radio-custom" name="payment_method" value="3" type="radio">
                                    <label for="c5" class="radio-custom-label">Pay With Stripe</label>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div>
                        <input type="hidden" name="sub_total" value="{{round(session('sub_total'))}}">
                        <input type="hidden" name="sales_discount" value="{{round(session('sales_discount'))}}">
                        <input type="hidden" name="coupon_discount" value="{{round(session('discount'))}}">
                    </div>
                    
                    <div class="card mb-4 gray">
                        <div class="card-body">
                        <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x">
                            <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                <span>Sub Total</span> <span class="ml-auto text-dark ft-medium">&#2547; {{number_format(round(session('sub_total')))}}/-</span>
                            </li>

                            <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                <span>Sales Discount</span> <span class="ml-auto text-dark ft-medium">&#2547; {{number_format(round(session('sales_discount')))}}/-</span>
                            </li>

                            <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                <span>Coupon Discount</span> <span class="ml-auto text-dark ft-medium">&#2547; {{number_format(round(session('discount')))}}/-</span>
                            </li>

                            <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                <span>Delivery Charge</span> <span class="ml-auto text-dark ft-medium" id="charge">&#2547; {{number_format(round(session(0)))}}/-</span>
                            </li>

                            <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                <span>Total</span> <span class="ml-auto text-dark ft-medium" id="final_total">&#2547; {{number_format(round(session('grant_total')))}}/-</span>
                            </li>
                        </ul>
                        </div>
                    </div>

                    <input type="hidden" class="grant_total" value="{{session('grant_total')}}">
                    
                        <button type="submit" class="btn btn-block btn-dark mb-3" id="order_btn">Place Your Order</button>
                    </form>
                </div>
                
            </div>
            
        </div>
    </section>
    <!-- ======================= Product Detail End ======================== -->

@endsection

@section('footer_script')

    <script>
        $('.charge').click(function(){
            var delivery_charge = $(this).val();
            var grant_total = $('.grant_total').val();
            var final_total = $.number(parseInt(grant_total)+parseInt(delivery_charge));

            $('#charge').html('\u09F3'+ ' ' + delivery_charge + '/-');
            $('#final_total').html('\u09F3'+ ' ' + final_total + '/-');
        })
    </script>

    <script>
        // ===== select2 js code ======
        $(document).ready(function() {
            $('.country_id').select2();
        });
    </script>

    <script>
        $('.country_id').change(function(){
            var country_id = $(this).val();
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:'/getCity',
                type:'POST',
                data:{'country_id':country_id},
                success:function(data){
                    $('.city_id').html(data);
                    $('.city_id').select2();
                }
            })
        })
    </script>


@endsection