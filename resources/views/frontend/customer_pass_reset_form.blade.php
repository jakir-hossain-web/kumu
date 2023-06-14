@extends('frontend.master')

@section('content')

<style>
    .return_pass_reset {
        color: #0d6efd;
        transition: .3s;
        font-weight: 500;
    }
    .return_pass_reset:hover {
        color: #043988;
    }
</style>
	<!-- ======================= Top Breadcrubms ======================== -->
	<div class="gray py-3">
		<div class="container">
			<div class="row">
				<div class="colxl-12 col-lg-12 col-md-12">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{route('front.home')}}">Home</a></li>
							<li class="breadcrumb-item active" aria-current="page">Password Reset Form</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>

    <!-- ======================= Login Detail ======================== -->
    <section class="middle">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                
                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                    <div class="mb-4 text-center">
                        {{-- ========= all session message start ======== --}}

                        @if (session('password_reset_link_not_found'))
                            <div class="alert alert-danger" style="font-size: 20px">
                                {{session('password_reset_link_not_found')}}
                                <a class="return_pass_reset" href="{{route('customer.password_reset')}}">
                                    <i class="fa fa-angle-double-right ml-3" style="font-size:17px;"></i>
                                    Reset Password
                                </a>
                            </div>
                        @endif 

                        {{-- ========= all session message end ======== --}}
                    </div>
                    <div class="mb-3">
                        <h3>Password Reset Form</h3>
                    </div>
                    <form class="border p-3 rounded" action="{{route('customer.password_reset_confirm')}}" method="POST">
                        @csrf	
                        <input type="hidden" name="token" value="{{$token}}">			
                        <div class="form-group">
                            <label>Password *</label>
                            <input type="password" name="password" class="form-control" placeholder="Password*">
                            @error('password')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label>Confirm Password *</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password*">
                            @error('password_confirmation')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror

                            @if (session('confirm_password_not_match'))
                                <strong class="text-danger">{{session('confirm_password_not_match')}}</strong>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Reset Password</button>
                        </div>

                        <div class="form-group">
                            <p style="font-size: 16px; text-align: justify;"><span style="font-size: 18px; font-width: 700; color:#0B2A97">Password Formate:</span> Password must contain minimum 08 Character and minimum 01 Uppercase, 01 Lowercase, 01 Number & 01 Special Character must be used.</p>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </section>
			<!-- ======================= Login End ======================== -->
@endsection

@section('footer_script')
    {{-- @if (session('pass_reset_success'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('pass_reset_success')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif   --}}
@endsection