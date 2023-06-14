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
							<li class="breadcrumb-item active" aria-current="page">404 page</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>

    <!-- ======================= Login Detail ======================== -->
    <section class="middle">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8 col-xl-6 text-center">
                    <div class="mb-5">
                        <div>
                            <i class="fa fa-exclamation-circle text-danger mb-4" style="font-size: 70px"></i>
                        </div>
                         <!-- Heading -->
                        <h1 class="mb-2 ft-bold" style="font-size: 50px">404!</h1>
                        <!-- Text -->
                        <p class="ft-regular fs-md mb-5">Your order has been Failed. To shop again please click on</p>
                    </div>
                    <a class="btn btn-dark" href="{{route('front.home')}}">Home Page</a>
                </div>
            </div>
        </div>
    </section>
    <!-- ======================= Login End ======================== -->
@endsection

@section('footer_script')


@endsection