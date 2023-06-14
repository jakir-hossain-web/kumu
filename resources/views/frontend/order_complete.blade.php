@extends('frontend.master')

<style>
    .customer_mail_address{
        transition: .3s
    }
    .customer_mail_address:hover{
        color: #27b737;
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
                            <li class="breadcrumb-item active" aria-current="page">Order Complete</li>
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

                    <div class="p-4 d-inline-flex align-items-center justify-content-center circle bg-light-success text-success mx-auto mb-4"><i class="fa fa-shopping-bag fs-lg"></i></div>
                    <!-- Heading -->
                    <h2 class="mb-2 ft-bold">Your Order is Completed!</h2>
                    <!-- Text -->
                    <p class="ft-regular fs-md mb-5">Your order <span class="text-body text-success">{{$billing_info->order_id}}</span> has been completed. Your order details are already sended to <a href="https://accounts.google.com/ServiceLogin/signinchooser?service=mail&passive=1209600&osid=1&continue=https%3A%2F%2Fmail.google.com%2Fmail%2Fu%2F0%2F&followup=https%3A%2F%2Fmail.google.com%2Fmail%2Fu%2F0%2F&emr=1&ifkv=AWnogHc5VEIceqK-gTFvedV6mAZiZU3KwGIXwKRBNkRBddGOxagfTifqePtNg6AE9X9vcQ_p6oea&flowName=GlifWebSignIn&flowEntry=ServiceLogin" target="_blank" class="text-body text-dark"><u class="customer_mail_address">{{Auth::guard('customerlogin')->user()->email}}</u></a> . <span class="d-block">Thanks for shopping with us.</span></p>
                    
                    <!-- Button -->
                    <a class="btn btn-dark mr-2" href="{{route('customer.customer_order')}}">Order Details</a>
                    <a class="btn btn-dark ml-2" href="{{route('front.home')}}">Home Page</a>
                </div>
            </div>
            
        </div>
    </section>
    <!-- ======================= Order complete End ======================== -->
@endsection

@section('footer_script')
    @if (session('order_success'))
        <script>
            Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: "{{session('order_success')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif  
@endsection