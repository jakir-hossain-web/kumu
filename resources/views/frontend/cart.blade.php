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
                            <li class="breadcrumb-item active" aria-current="page">Cart</li>
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
                        <h2 class="off_title">Shopping Cart</h2>
                        <h3 class="ft-bold pt-3">Shopping Cart</h3>
                    </div>
                </div>
            </div>
            <div class="alert_part text-center mb-3">
                @if ($active_btn == 'active')
                    @if ($discount == 0)
                        <div class="alert alert-danger" style="font-size: 20px">{{$coupon_message}}</div>
                    @else
                            <div class="alert alert-success" style="font-size: 19px">{{'Coupon Applied Successfully!'}}</div>
                    @endif
                @endif
            </div>
            @if (App\Models\Cart::where('customer_id', Auth::guard('customerlogin')->id())->count() == 0)
                <h1 class="text-center mb-5">No product add to cart yet!</h1>
                @else
                
                <div class="row justify-content-between">
                    <div class="col-12 col-lg-7 col-md-12">
                        <form action="{{route('cart.update')}}" method="POST">
                        @csrf
                        <div class="scart_top col-lg-12">
                            <div class="scart_top_left">
                                @php
                                    $sub_total=0;
                                    $total=0;
                                @endphp
                                @foreach ($carts as $cart)
                                    <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x mb-4">     
                                        <li class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-3">
                                                    <!-- Image -->
                                                    <a href="{{route('product.details', $cart->rel_to_product->slug)}}"><img src="{{asset('uploads/product/preview')}}/{{$cart->rel_to_product->preview}}" alt="Product Image" class="img-fluid"></a>
                                                </div>
                                                <div class="col d-flex align-items-center justify-content-between">
                                                    <div class="cart_single_caption pl-2">
                                                        <a href="{{route('product.details', $cart->rel_to_product->slug)}}">
                                                        <h4 class="product_title fs-md ft-medium mb-1 lh-1">{{$cart->rel_to_product->product_name}}</h4></a>
                                                        <p class="mb-1 lh-1"><span class="text-dark">Size: {{$cart->rel_to_size->size_name}}</span></p>
                                                        <p class="mb-3 lh-1"><span class="text-dark">Color: {{$cart->rel_to_color->color_name}}</span></p>
                                                        <h4 class="fs-md ft-medium mb-3 lh-1">&#2547; 
                                                            {{number_format($cart->rel_to_product->after_discount)}}/-</h4>
                                                        @php
                                                            $quantity = App\Models\Inventory::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->first()->quantity;
                                                        @endphp
                                                        <select class="mb-2 custom-select w-auto" name="quantity[{{$cart->id}}]">
                                                            @for ($i=1; $i<=$quantity; $i++)
                                                                <option {{$cart->quantity == $i?'selected':''}} value="{{$i}}">{{$i}}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    <div class="fls_last"><a href="{{route('cart.remove', $cart->id)}}" class="close_slide gray" onMouseOver="this.style.color='#db0000'" onMouseOut="this.style.color='#000'"><i class="ti-close"></i></a></div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    @php
                                        $sub_total += $cart->rel_to_product->price*$cart->quantity;
                                        $total += $cart->rel_to_product->after_discount*$cart->quantity;
                                    @endphp
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="row scart_bottom mb-10 mb-md-0 col-lg-12 d-flex justify-content-between align-items-end">
                            <div class="scart_top_right col-12 col-md-auto mfliud align">
                                <button type="submit" class="btn stretched-link borders">Update Cart</button>
                            </div>
                            </form>

                            <div class="col-12 col-md-7 col-lg-6">

                                <!-- Coupon  -->
                                <form class="mb-7 mb-md-0" action="{{route('cart')}}" method="GET">
                                    @csrf
                                    <label class="fs-sm ft-medium text-dark">Coupon code:</label>
                                    <div class="row form-row">
                                        <div class="col">
                                            <input type="hidden" name="total" value="{{$total}}">
                                            <input class="form-control" type="text" placeholder="Enter coupon code*" name="coupon_name">
                                        </div>
                                        
                                        <div class="col-auto">
                                            <button class="btn btn-dark" type="submit" name="coupon_btn" value="active">Apply</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-12 col-md-12 col-lg-4">
                        <div class="card mb-4 gray mfliud">
                            <div class="card-body">
                            <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x">
                                <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                    <span>Subtotal</span> <span class="ml-auto text-dark ft-medium">&#2547; {{number_format(round($sub_total))}}/-</span>
                                </li>
                                <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                    <span>Sales Discount</span> <span class="ml-auto text-dark ft-medium">&#2547; {{number_format(round($sub_total-$total))}}/-</span>
                                </li>
                                <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                    <span>Coupon Discount</span> <span class="ml-auto text-dark ft-medium">&#2547; {{number_format(round($discount))}}/-</span>
                                </li>
                                <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                                    <span>Total</span> <span class="ml-auto text-dark ft-medium">&#2547; {{number_format(round($total-$discount))}}/-</span>
                                </li>
                                <li class="list-group-item fs-sm text-center">
                                Shipping cost calculated at Checkout *
                                </li>
                            </ul>
                            </div>
                        </div>
                        @php
                            $sales_discount = $sub_total-$total;
                            $grant_total = $total-$discount;
                            session([
                            'sub_total'=>$sub_total,
                            'sales_discount'=>$sales_discount,
                            'discount'=>$discount,
                            'total'=>$total,
                            'grant_total'=>$grant_total,
                            ])
                        @endphp
                        
                        <a class="btn btn-block btn-dark mb-3" href="{{route('checkout')}}">Proceed to Checkout</a>
                        
                        <a class="btn-link text-dark ft-medium" href="{{route('front.home')}}">
                            <i class="ti-back-left mr-2"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            @endif
            
        </div>
    </section>
@endsection

@section('footer_script')

    @if (session('cart_remove'))
        <script>
            Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: "{{session('cart_remove')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

    @if (session('Cart_update'))
        <script>
            Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: "{{session('Cart_update')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

    @if (session('cart_empty'))
			<script>
				Swal.fire({
				position: 'center',
				icon: 'warning',
				title: "{{session('cart_empty')}}",
				showConfirmButton: false,
				timer: 2000
				})
			</script>
		@endif

    {{-- ========= Remove GET Looping on Page Refresh ======= --}}
    <script>    
        if(typeof window.history.pushState == 'function') {
            window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF'];?>');
        }
    </script>

    {{-- ========= Coupon success message slide animation ======= --}}
    <script>
        $(".alert-success").fadeTo(3000, 500).slideUp(1000, function(){
            $(".alert-success").alert('close');
        });
    </script>

@endsection