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
							<li class="breadcrumb-item active" aria-current="page">Password Reset Request</li>
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

                        @if (session('mail_not_found'))
                            <div class="alert alert-danger" style="font-size: 20px">{{session('mail_not_found')}}</div>
                        @endif 

                        @if (session('pass_reset_req'))
                            <div class="alert alert-success" style="font-size: 20px">{{session('pass_reset_req')}}</div>
                        @endif 

                        {{-- ========= all session message end ======== --}}
                    </div>
                    <div class="mb-3">
                        <h3>Password Reset Request</h3>
                    </div>
                    <form class="border p-3 rounded" action="{{route('customer.password_reset_request')}}" method="POST">
                        @csrf				
                        <div class="form-group">
                            <label>Your Email Address*</label>
                            <input type="email" name="email" class="form-control" placeholder="Email*">
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Send Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
			<!-- ======================= Login End ======================== -->
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