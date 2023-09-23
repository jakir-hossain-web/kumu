@extends('frontend.master')
<style>
    .location_map{
        transition: .3s;
    }
    .location_map:hover{
        box-shadow: 0 0 7px 1px #000;
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
                            <li class="breadcrumb-item active" aria-current="page">Contact</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ======================= Top Breadcrubms ======================== -->

    <!-- ======================= Contact Page Detail ======================== -->
    <section class="middle">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="sec_title position-relative text-center">
                        <h2 class="off_title">Contact Us</h2>
                        <h3 class="ft-bold pt-3">Get In Touch</h3>
                    </div>
                </div>
            </div>
            
            <div class="row align-items-start justify-content-between">

                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                    <div class="card-wrap-body mb-4">
                        <h4 class="ft-medium mb-3 theme-cl">Contact with us</h4>
                        <h6 class="ft-medium mb-2">Pikter IT</h6>
                        <p class="lh-1">Multiplan Center, Level-3, Shop-351 (Sales Center) &</p>
                        <p class="lh-1">Lavel- 9, Shop-958 (Service Center),</p>
                        <p class="lh-1 mb-3">New Elephant Rd, Dhaka 1205.</p>
                        <p class="lh-1"><span class="text-dark ft-medium">Email:</span> pikterit@gmail.com</p>
                        <p class="lh-1"><span class="text-dark ft-medium">Contact no:</span> +8801623486100 & +8801623486101</p>
                    </div>
                    <iframe class="location_map" width="100%" height="385px" frameborder="0" style="border: 1px solid #e5e5e5; padding: 5px"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4343.276665358637!2d90.3874313555202!3d23.73861340351239!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8c78bd8bf49%3A0xc61f0775eabd493d!2sPikter%20IT!5e0!3m2!1sen!2sbd!4v1692106877334!5m2!1sen!2sbd">
                    </iframe>
                </div>

                
                
                <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12">
                    <div class="row">
                        <form action="{{route('contact_message')}}" method="POST">
                            @csrf
                            <h4 class="ft-medium mb-3 theme-cl">Send your message</h4>
                            <p class="lh-1">Here you can send your message, share your opinion, suggestion or ideas and place your complain or query.</p>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="small text-dark ft-medium">Your Name *</label>
                                        @error('name')
                                            <strong class="text-danger">{{$message}}</strong>
                                        @enderror
                                    <input type="text" class="form-control" name="name" value="{{old('name')!=null?old('name'):null}}">
                                </div>
                            </div>
                            
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="small text-dark ft-medium">Your Email *</label>
                                        @error('email')
                                            <strong class="text-danger">{{$message}}</strong>
                                        @enderror
                                    <input type="email" class="form-control" name="email" value="{{old('email')!=null?old('email'):null}}">
                                </div>
                            </div>
                            
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="small text-dark ft-medium">Your Mobile Number</label>
                                        @error('mobile')
                                            <strong class="text-danger">{{$message}}</strong>
                                        @enderror
                                    <input type="text" class="form-control" name="mobile" value="{{old('mobile')!=null?old('mobile'):null}}">
                                </div>
                            </div>
                            
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label class="small text-dark ft-medium">Your Message *</label>
                                        @error('message')
                                            <strong class="text-danger">{{$message}}</strong>
                                        @enderror
                                    <textarea class="form-control ht-80" name="message">{{old('message')!=null?old('message'):null}}</textarea>
                                </div>
                            </div>
                            
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-dark" name="message_btn">Send Your Message</button>
                                </div>
                            </div>
                            <p>* Mendatory Field.</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
	<!-- ======================= Contact Page End ======================== -->

@endsection

@section('footer_script')
    @if (session('customer_message_success'))
        <script>
            Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: "{{session('customer_message_success')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

@endsection