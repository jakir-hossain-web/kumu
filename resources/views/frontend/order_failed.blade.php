@extends('frontend.master')

<style>
    .view_cart{
        transition: .3s;
        color: rgb(105, 105, 105);
    }
    .view_cart:hover{
        color: #000;
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
                            <li class="breadcrumb-item active" aria-current="page">Order Failed</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ======================= Top Breadcrubms ======================== -->
    
    <!-- ======================= Order complete start ======================== -->
    <section class="middle">
        <div class="container">
        
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8 col-xl-6 text-center">

                    @php
                        $billing_info = App\Models\BillingDetails::where('customer_id', Auth::guard('customerlogin')->id())->latest()->first();
                    @endphp

                    <!-- Icon -->
                    {{-- <div class="p-4 d-inline-flex align-items-center justify-content-center circle bg-light-success text-success mx-auto mb-4"><i class="lni lni-heart-filled fs-lg"></i></div> --}}

                    <div class="p-4 d-inline-flex align-items-center justify-content-center circle bg-light-danger text-danger mx-auto mb-4"><i class="fa fa-ban fs-lg"></i></div>
                    <!-- Heading -->
                    <h2 class="mb-2 ft-bold">Your Order is Failed!</h2>
                    <!-- Text -->
                    <p class="ft-regular fs-md mb-5">Your order has been Failed. To shop again please click on <a class="view_cart" href="{{route('cart')}}">VIEW CART.</a> <span class="d-block">Thanks for shopping with us.</span></p>
                    
                    <!-- Button -->
                    <a class="btn btn-dark mr-2" href="{{route('cart')}}">View Cart</a>
                    <a class="btn btn-dark ml-2" href="{{route('front.home')}}">Home Page</a>
                </div>
            </div>
            
        </div>
    </section>
    <!-- ======================= Order complete End ======================== -->
@endsection

@section('footer_script')
    {{-- @if (session('order_success'))
        <script>
            Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: "{{session('order_success')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif   --}}
@endsection