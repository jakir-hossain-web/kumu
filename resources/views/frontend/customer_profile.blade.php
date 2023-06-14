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
                        <li class="breadcrumb-item active">Profile</li>
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
                            <li><a href="{{route('customer.customer_order')}}"><i class="lni lni-shopping-basket mr-2"></i>My Order</a></li>
                            <li><a href="{{route('customer.customer_wish')}}"><i class="lni lni-heart mr-2"></i>Wishlist</a></li>
                            <li><a href="{{route('customer.profile')}}" class="active"><i class="lni lni-user mr-2"></i>Profile Info</a></li>
                            <li><a href="{{route('customer.logout')}}"><i class="lni lni-power-switch mr-2"></i>Log Out</a></li>
                        </ul>
                    </div>
                    
                </div>
            </div>
            
            <div class="col-12 col-md-12 col-lg-8 col-xl-8">

                <!-- profile update -->
                <div class="row align-items-center">
                    <form class="row m-0" action="{{route('customer.profile_udpate')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="small text-dark ft-medium">Name *</label>
                                <input type="text" class="form-control" value="{{$customer_info->name}}" name="name"/>
                                @error('name')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="small text-dark ft-medium">Email Address *</label>
                                <input type="email" class="form-control" value="{{$customer_info->email}}" name="email"/>
                                @error('email')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror

                                @if (session('duplicate_email'))
                                    <strong class="text-danger" >{{session('duplicate_email')}}</strong>
                                @endif
                            </div>
                        </div>
                   
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="small text-dark ft-medium">Mobile Number *</label>
                                <input type="text" class="form-control" value="{{$customer_info->mobile!=null?$customer_info->mobile:null}}" name="mobile"/>
                                @error('mobile')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="small text-dark ft-medium">Old Password **</label>
                                <input type="password" class="form-control" placeholder="Old Password" name="old_password" autocomplete="new-password"/>
                                @error('old_password')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror

                                @if (session('wrong_old_password'))
                                    <strong class="text-danger" >{{session('wrong_old_password')}}</strong>
                                @endif
                            </div>
                        </div>

                         <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="small text-dark ft-medium">Country *</label>
                                <select class="custom-select country_id" name="country_id">
                                    <option value="" >--- Select Country ---</option>
                                    @foreach ($countries as $country) 
                                        <option value="{{$country->id}}" {{$customer_info->country_id==$country->id?'selected':''}}>{{$country->name}}</option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="small text-dark ft-medium">New Password **</label>
                                <input type="password" class="form-control" placeholder="New Password" name="password"/>
                                @error('password')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="small text-dark ft-medium">City *</label>
                                <select class="custom-select city_id" name="city_id">
                                    <option value="">-- Select City --</option>
                                    @foreach (App\Models\City::where('country_id', $customer_info->country_id)->get() as $city) 
                                        <option value="{{$city->id}}" 
                                            {{$customer_info->city_id != null &&$customer_info->city_id==$city->id?'selected' :''}}>
                                            {{$city->name}}
                                        </option>
                                    @endforeach
                                </select>
                                @error('city_id')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="small text-dark ft-medium">Confirm Password **</label>
                                <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation"/>
                                @error('password_confirmation')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror

                                @if (session('password_not_match'))
                                    <strong class="text-danger" >{{session('password_not_match')}}</strong>
                                @endif
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="small text-dark ft-medium">Address *</label>
                                <input type="text" class="form-control" value="{{$customer_info->address!=null?$customer_info->address:null}}" name="address"/>
                                @error('address')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="small text-dark ft-medium">Profile Image</label>
                                <input type="file" class="form-control" name="profile_image"/>
                                @error('profile_image')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-dark">Update Profile</button>
                            </div>
                        </div>
                        <div>
                            <p style="margin: -5px 9px;"><span style="color: red">*</span> Mendatory field.</p>
                            <p><span style="color: red">**</span> Mendatory only when password will be changed.</p>
                        </div>
                    </form>
                </div>
                <!-- row -->
            </div>
            
        </div>
    </div>
</section>
<!-- ======================= Dashboard Detail End ======================== -->

@endsection


@section('footer_script')

    <script>
        $('country_id').click(function(){
            $(this).css('border', '1px solid red');
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

    <script>

        let input_border = document.querySelector('.city_id')

        input_border.addEventListener('click', function(){
            input_border.style.border = '1px solid #000'
        })


    </script>
	
@endsection 