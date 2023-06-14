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
							<li class="breadcrumb-item active" aria-current="page">Registration & Login</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>

    <!-- ======================= Login Detail ======================== -->
			<section class="middle">
				<div class="container">
					<div class="text-center mb-3">
						<h3>
							@if (session('customer_register_success'))
								<div class="alert alert-success">{{session('customer_register_success')}}</div>
							@endif

							@if (session('customer_register_duplicate'))
								<div class="alert alert-danger">{{session('customer_register_duplicate')}}</div>
							@endif

							@if (session('customer_email_verify_success'))
								<div class="alert alert-success">{{session('customer_email_verify_success')}}</div>
							@endif

							@if (session('email_not_verified'))
								<div class="alert alert-danger">{{session('email_not_verified')}}</div>
							@endif

							@if (session('pass_reset_success'))
								<div class="alert alert-success">{{session('pass_reset_success')}}</div>
							@endif

							@if (session('email_verify_link_not_found'))
                            	<div class="alert alert-danger">{{session('email_verify_link_not_found')}}</div>
                        	@endif 

							@if (session('customer_error_login'))
								<div class="alert alert-danger">{{session('customer_error_login')}}</div>
							@endif

							@if (session('cartlogin'))
								<div class="alert alert-danger">{{session('cartlogin')}}</div>
							@endif

							@if (session('wishlogin'))
								<div class="alert alert-danger">{{session('wishlogin')}}</div>
							@endif
						</h3>
					</div>
					<div class="row align-items-start justify-content-between">
					
						<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
							<div class="mb-3">
								<h3>Login</h3>
							</div>
							<form class="border p-3 rounded" action="{{route('customer.login')}}" method="POST">
								@csrf				
								<div class="form-group">
									<label>Email *</label>
									<input type="email" name="email" class="form-control" placeholder="Email*">
								</div>
								
								<div class="form-group">
									<label>Password *</label>
									<input type="password" name="password" class="form-control" placeholder="Password*">
								</div>
								
								<div class="form-group">
									<div class="d-flex align-items-center justify-content-between">
										<div class="eltio_k2">
											<a href="{{route('customer.password_reset')}}">Lost Your Password?</a>
										</div>	
									</div>
								</div>
								
								<div class="form-group">
									<button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Login</button>
								</div>
								<div class="form-group">
									<a href="{{route('login.github')}}" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Login with Github</a>
								</div>
								<div class="form-group">
									<a href="{{route('login.google')}}" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Login with Gmail</a>
								</div>
							</form>
						</div>
						
                <!-- ======================= Registration Detail ======================== -->
						<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mfliud">
							<div class="mb-3">
								<h3>Register</h3>
							</div>
							<form class="border p-3 rounded" action="{{route('customer.register')}}" method="POST">
								@csrf
								<div class="row">
									<div class="form-group col-md-12">
										<label>Full Name *</label>
										<input type="text" name="name" class="form-control" placeholder="Full Name">
										@error('name')
											<strong class="text-danger">{{$message}}</strong>
										@enderror
									</div>
								</div>
								
								<div class="form-group">
									<label>Email *</label>
									<input type="email" name="email" class="form-control" placeholder="Email*">
									@error('email')
										<strong class="text-danger">{{$message}}</strong>
									@enderror
								</div>
								
								<div class="row">
									<div class="form-group col-md-6">
										<label>Password *</label>
										<input type="password" name="password" class="form-control" placeholder="Password*">
										@error('password')
											<strong class="text-danger">{{$message}}</strong>
										@enderror
									</div>
									
									<div class="form-group col-md-6">
										<label>Confirm Password *</label>
										<input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password*">
										
										@error('password_confirmation')
											<strong class="text-danger">{{$message}}</strong>
										@enderror

										@if (session('confirm_password_not_match'))
											<strong class="text-danger">{{session('confirm_password_not_match')}}</strong>
										@endif
										
									</div>

								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Create An Account</button>
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
			confirmButtonText:'Please Login',
			})
		</script>
	@endif  --}}

@endsection