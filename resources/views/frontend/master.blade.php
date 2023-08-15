<!DOCTYPE html>
<html lang="zxx">
<head>
		<meta charset="utf-8" />
		<meta name="author" content="Themezhub" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		
        <title>Kumo- Fashion eCommerce HTML Template</title>
		 
        <!-- Custom CSS -->
        <link href="{{asset('frontend/css/plugins/animation.css')}}" rel="stylesheet">
        <link href="{{asset('frontend/css/plugins/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('frontend/css/plugins/flaticon.css')}}" rel="stylesheet">
        <link href="{{asset('frontend/css/plugins/font-awesome.css')}}" rel="stylesheet">
        <link href="{{asset('frontend/css/plugins/iconfont.css')}}" rel="stylesheet">
        <link href="{{asset('frontend/css/plugins/ion.rangeSlider.min.css')}}" rel="stylesheet">
        <link href="{{asset('frontend/css/plugins/light-box.css')}}" rel="stylesheet">
        <link href="{{asset('frontend/css/plugins/line-icons.css')}}" rel="stylesheet">
        <link href="{{asset('frontend/css/plugins/slick-theme.css')}}" rel="stylesheet">
        <link href="{{asset('frontend/css/plugins/slick.css')}}" rel="stylesheet">
        <link href="{{asset('frontend/css/plugins/snackbar.min.css')}}" rel="stylesheet">
        <link href="{{asset('frontend/css/plugins/themify.css')}}" rel="stylesheet">
        <link href="{{asset('frontend/css/styles.css')}}" rel="stylesheet">

		{{-- ====== select2 plugin css link ====== --}}
		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


		{{-- ====== remove number input arrow sign ====== --}}
		<style>
			/* Chrome, Safari, Edge, Opera */
			input::-webkit-outer-spin-button,
			input::-webkit-inner-spin-button {
			-webkit-appearance: none;
			margin: 0;
			}

			/* Firefox */
			input[type=number] {
			-moz-appearance: textfield;
			}

			.color_id:checked ~ .form-option-label {
				border-color: #121212;
				color: #121212;
			}

			.size_id:checked ~ .form-option-label {
				border-color: #121212;
				color: #121212;
			}

			#loader{
				position: fixed;
				width: 100%;
				height: 100vh;
				background: #FFFFFF url("/frontend/img/loader/shopping.gif") no-repeat center;
				background-size: 1000px;
				z-index: 999;
				/* display: none; */
			}

			/* ====== single product hover effect (box-shadow) ======= */
			.product_grid, .product_grid.card {
				padding: 20px !important;
				transition: .3s;
			}

			.product_grid:hover {
				box-shadow: 0px 5px 10px -3px #000 !important;
			}

			#search_input{
				border: 1px solid #c0bfbf !important;
				/* border-radius: 50px; */
			}

			#search_btn{
				background: #031424;
				transition: .3s;
			}

			#search_btn:hover .custom_search_icon{
				color: #ee1c47;
			}

			.check_individual_div{
				position: relative;
			}
			.check_wish{
				position: absolute;
				top: 45px ;
				left: 0;
			}
			.check_cart{
				position: absolute;
				top: 45px ;
				left: 0;
			}

			/* ===== social share css start ===== */
			.social-btn-sp #social-links {
                margin: 0 auto;
                max-width: 500px;
            }

            .social-btn-sp #social-links ul li {
                display: inline-block;
            }          

            .social-btn-sp #social-links ul li a {
				padding: 5px 10px;
				margin-right: 10px;
				margin-left: 4px;
				font-size: 22px;
				color: #616060;
				border-radius: .25rem;
                border: 1px solid #b3b3b3;
				transition: .3s;
            }

            .social-btn-sp #social-links ul li a:hover{
				color: #151515;
                border: 1px solid #151515;
            }
			/* ===== social share css end ===== */

		</style>


		
    </head>
	
    <body>

		<!--Start of Tawk.to Script-->
			<script type="text/javascript">
				var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
				(function(){
				var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
				s1.async=true;
				s1.src='https://embed.tawk.to/6463b7d974285f0ec46bd322/1h0iocb1u';
				s1.charset='UTF-8';
				s1.setAttribute('crossorigin','*');
				s0.parentNode.insertBefore(s1,s0);
				})();
			</script>
		<!--End of Tawk.to Script-->
	
		 <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
       <div class="preloader"></div>
	   <div id="loader"></div>
		
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper">
		
            <!-- ============================================================== -->
            <!-- Top header  -->
            <!-- ============================================================== -->
			<!-- Top Header -->
			<div class="py-2 br-bottom">
				<div class="container">
					<div class="row">
						
						<div class="col-xl-7 col-lg-6 col-md-6 col-sm-12 hide-ipad">
							<div class="top_second"><p class="medium text-muted m-0 p-0"><i class="lni lni-phone fs-sm"></i></i> Hotline <a href="#" class="medium text-dark text-underline">0(800) 123-456</a></p></div>
						</div>
						
						<!-- Right Menu -->
						<div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">

							<!-- user profile -->
							<div class="currency-selector dropdown js-dropdown float-right mr-3">
								@auth ('customerlogin')
									<div class="dropdown" style="cursor: pointer">
										<a class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											{{Auth::guard('customerlogin')->user()->name}}
										</a>
										<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
											<a class="dropdown-item" href="{{route('customer.profile')}}">Profile</a>
											<a class="dropdown-item" href="{{route('customer.logout')}}">Logout</a>
										</div>
										@php
											 $auth_user = App\Models\CustomerLogin::find(Auth::guard('customerlogin')->id());
											 $user_name = $auth_user->name;
											 $user_image = $auth_user->profile_image;
										@endphp
										<span style="margin-left: 10px">
											<a href="{{route('customer.profile')}}">
											@if ($user_image == null)
												<img style="width: 35px" src="{{ Avatar::create($user_name)->toBase64() }}"/>
												@else
												<img style="width: 35px; border-radius:50%" src="{{asset('uploads/customer')}}/{{$user_image}}" alt="Profile Image">
											@endif
											</a>											
										</span>
									</div>
								@else
									<a href="{{route('customer.login.register')}}" class="text-muted medium"><i class="lni lni-user mr-1"></i>Sign In / Register</a>
								@endauth								
							</div>

							<!-- Choose Language -->
							{{-- <div class="language-selector-wrapper dropdown js-dropdown float-right mr-3">
								<a class="popup-title" href="javascript:void(0)" data-toggle="dropdown" title="Language" aria-label="Language dropdown">
									<span class="hidden-xl-down medium text-muted">Language:</span>
									<span class="iso_code medium text-muted">English</span>
									<i class="fa fa-angle-down medium text-muted"></i>
								</a>
								<ul class="dropdown-menu popup-content link">
									<li class="current"><a href="javascript:void(0);" class="dropdown-item medium text-muted"><img src="assets/img/1.jpg" alt="en" width="16" height="11" /><span>English</span></a></li>
									<li><a href="javascript:void(0);" class="dropdown-item medium text-muted"><img src="assets/img/2.jpg" alt="fr" width="16" height="11" /><span>Français</span></a></li>
								</ul>
							</div> --}}
							
							
						</div>
						
					</div>
				</div>
			</div>
			
			<div class="headd-sty header">
				<div class="container">
					<div class="row">
						<div class="col-xl-12 col-lg-12 col-md-12">
							<div class="headd-sty-wrap d-flex align-items-center justify-content-between py-3">
								<div class="headd-sty-left d-flex align-items-center">
									<div class="headd-sty-01">
										<a class="nav-brand py-0" href="{{route('front.home')}}">
											<img src="{{asset('frontend/img/logo.png')}}" class="logo" alt="" />
										</a>
									</div>
									<div class="headd-sty-02 ml-3">
										<div class="input-group">
											<input type="text" id="search_input" value="{{@$_GET['keyword']}}" class="form-control custom-height b-0" placeholder="Search your products..." />
											<div class="input-group-append">
												<div class="input-group-text">
													<button id="search_btn" class="btn text-white custom-height px-3 " type="button"><i class="fas fa-search custom_search_icon"></i></button>
												</div>
											</div>
										</div>										
									</div>
								</div>
								<div class="headd-sty-last">
									<ul class="nav-menu nav-menu-social align-to-right align-items-center d-flex">
										<li>
											<div class="call d-flex align-items-center text-left">
												<i class="lni lni-phone fs-xl"></i>
												<span class="text-muted small ml-3">Call Us Now:<strong class="d-block text-dark fs-md">0(800) 123-456</strong></span>
											</div>
										</li>
										<li>
											<a href="#" onclick="openWishlist()">
												<i class="far fa-heart fs-lg"></i><span class="dn-counter bg-success">{{App\Models\Wish::where('customer_id', Auth::guard('customerlogin')->id())->count()}}</span>
											</a>
										</li>
										<li>
											<a href="#" onclick="openCart()">
												<div class="d-flex align-items-center justify-content-between">
													<i class="fas fa-shopping-basket fs-lg"></i><span class="dn-counter theme-bg">{{App\Models\Cart::where('customer_id', Auth::guard('customerlogin')->id())->count()}}</span>
												</div>
											</a>
										</li>
									</ul>	
								</div>
								<div class="mobile_nav">
									<ul>
										<li>
										<a href="#" onclick="openSearch()">
											<i class="lni lni-search-alt"></i>
										</a>
									</li>
									<li>
										<a href="#" data-toggle="modal" data-target="#login">
											<i class="lni lni-user"></i>
										</a>
									</li>
									<li>
										<a href="#" onclick="openWishlist()">
											<i class="lni lni-heart"></i><span class="dn-counter">2</span>
										</a>
									</li>
									<li>
										<a href="#" onclick="openCart()">
											<i class="lni lni-shopping-basket"></i><span class="dn-counter">0</span>
										</a>
									</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
            <!-- Start Navigation -->
			<div class="headerd header-dark head-style-2">
				<div class="container">
					<nav id="navigation" class="navigation navigation-landscape">
						<div class="nav-header">
							<div class="nav-toggle"></div>
							<div class="nav-menus-wrapper">
								<ul class="nav-menu">
									<li><a href="{{route('front.home')}}" class="pl-0">Home</a></li>
									<li><a href="{{route('shop')}}">Shop</a></li>
									<li><a href="{{route('about_us')}}">About Us</a></li>
									<li><a href="{{route('contact')}}">Contact</a></li>
								</ul>
							</div>
						</div>
					</nav>
				</div>
			</div>
			<!-- End Navigation -->
			<div class="clearfix"></div>
			<!-- ============================================================== -->
			<!-- Top header  -->
			<!-- ============================================================== -->
			
			@yield('content')
			
			<!-- ======================= Customer Features ======================== -->
			<section class="px-0 py-3 br-top">
				<div class="container">
					<div class="row">
						
						<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
							<div class="d-flex align-items-center justify-content-start py-2">
								<div class="d_ico">
									<i class="fas fa-shopping-basket"></i>
								</div>
								<div class="d_capt">
									<h5 class="mb-0">Free Shipping</h5>
									<span class="text-muted">Capped at $10 per order</span>
								</div>
							</div>
						</div>
						
						<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
							<div class="d-flex align-items-center justify-content-start py-2">
								<div class="d_ico">
									<i class="far fa-credit-card"></i>
								</div>
								<div class="d_capt">
									<h5 class="mb-0">Secure Payments</h5>
									<span class="text-muted">Up to 6 months installments</span>
								</div>
							</div>
						</div>
						
						<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
							<div class="d-flex align-items-center justify-content-start py-2">
								<div class="d_ico">
									<i class="fas fa-shield-alt"></i>
								</div>
								<div class="d_capt">
									<h5 class="mb-0">15-Days Returns</h5>
									<span class="text-muted">Shop with fully confidence</span>
								</div>
							</div>
						</div>
						
						<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
							<div class="d-flex align-items-center justify-content-start py-2">
								<div class="d_ico">
									<i class="fas fa-headphones-alt"></i>
								</div>
								<div class="d_capt">
									<h5 class="mb-0">24x7 Fully Support</h5>
									<span class="text-muted">Get friendly support</span>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</section>
			<!-- ======================= Customer Features ======================== -->
			
			<!-- ============================ Footer Start ================================== -->
			<footer class="dark-footer skin-dark-footer style-2">
				<div class="footer-middle">
					<div class="container">
						<div class="row">
							
							<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
								<div class="footer_widget">
									<img src="assets/img/logo-light.png" class="img-footer small mb-2" alt="" />
									
									<div class="address mt-3">
										3298 Grant Street Longview, TX<br>United Kingdom 75601	
									</div>
									<div class="address mt-3">
										1-202-555-0106<br>help@shopper.com
									</div>
									<div class="address mt-3">
										<ul class="list-inline">
											<li class="list-inline-item"><a href="#"><i class="lni lni-facebook-filled"></i></a></li>
											<li class="list-inline-item"><a href="#"><i class="lni lni-twitter-filled"></i></a></li>
											<li class="list-inline-item"><a href="#"><i class="lni lni-youtube"></i></a></li>
											<li class="list-inline-item"><a href="#"><i class="lni lni-instagram-filled"></i></a></li>
											<li class="list-inline-item"><a href="#"><i class="lni lni-linkedin-original"></i></a></li>
										</ul>
									</div>
								</div>
							</div>
							
							<div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
								<div class="footer_widget">
									<h4 class="widget_title">Supports</h4>
									<ul class="footer-menu">
										<li><a href="#">Contact Us</a></li>
										<li><a href="#">About Page</a></li>
										<li><a href="#">Size Guide</a></li>
										<li><a href="#">FAQ's Page</a></li>
										<li><a href="#">Privacy</a></li>
									</ul>
								</div>
							</div>
									
							<div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
								<div class="footer_widget">
									<h4 class="widget_title">Shop</h4>
									<ul class="footer-menu">
										<li><a href="#">Men's Shopping</a></li>
										<li><a href="#">Women's Shopping</a></li>
										<li><a href="#">Kids's Shopping</a></li>
										<li><a href="#">Furniture</a></li>
										<li><a href="#">Discounts</a></li>
									</ul>
								</div>
							</div>
					
							<div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
								<div class="footer_widget">
									<h4 class="widget_title">Company</h4>
									<ul class="footer-menu">
										<li><a href="#">About</a></li>
										<li><a href="#">Blog</a></li>
										<li><a href="#">Affiliate</a></li>
										<li><a href="#">Login</a></li>
									</ul>
								</div>
							</div>
							
							<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
								<div class="footer_widget">
									<h4 class="widget_title">Subscribe</h4>
									<p>Receive updates, hot deals, discounts sent straignt in your inbox daily</p>
									<div class="foot-news-last">
										<div class="input-group">
										  <input type="text" class="form-control" placeholder="Email Address">
											<div class="input-group-append">
												<button type="button" class="input-group-text b-0 text-light"><i class="lni lni-arrow-right"></i></button>
											</div>
										</div>
									</div>
									<div class="address mt-3">
										<h5 class="fs-sm text-light">Secure Payments</h5>
										<div class="scr_payment"><img src="assets/img/card.png" class="img-fluid" alt="" /></div>
									</div>
								</div>
							</div>
								
						</div>
					</div>
				</div>
				
				<div class="footer-bottom">
					<div class="container">
						<div class="row align-items-center">
							<div class="col-lg-12 col-md-12 text-center">
								<p class="mb-0">© 2021 Kumo. Designd By <a href="https://themezhub.com/">ThemezHub</a>.</p>
							</div>
						</div>
					</div>
				</div>
			</footer>
			<!-- ============================ Footer End ================================== -->
			
			<!--================ Wishlist ==================-->
			<!--================ Wishlist ==================-->
			<div class="w3-ch-sideBar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="Wishlist">
				<div class="rightMenu-scroll">
					
						<div class="d-flex align-items-center justify-content-between slide-head py-3 px-3">
							<h4 class="cart_heading fs-md ft-medium mb-0">Saved Products</h4>
							<button onclick="closeWishlist()" class="close_slide" onMouseOver="this.style.color='#db0000'" onMouseOut="this.style.color='#000'"><i class="ti-close"></i></button>
						</div>

					<form action="{{route('wish.remove_all_checked')}}" method="POST" id="check_wish_btn">
						@csrf
						<div class="right-ch-sideBar ">

							@php
								$all_wishes = App\Models\Wish::where('customer_id', Auth::guard('customerlogin')->id())->count()
							@endphp

							{{-- === Select all checkbox start ==== --}}
							@if ($all_wishes != 0)
								<div class="d-flex justify-content-start mt-2" style="font-weight: 500">
									<input type="checkbox" id="checkall_wish" class="ml-2 mr-2">Select All
								</div>
							@endif
							{{-- === Select all checkbox end ==== --}}

							<div class="cart_select_items">
								<!-- Single Item -->
								@if (App\Models\Wish::where('customer_id', Auth::guard('customerlogin')->id())->count() == 0)
									<h5 class="text-center mt-4">No product add to wishlist yet!</h5>
								@endif

								@foreach (App\Models\Wish::where('customer_id', Auth::guard('customerlogin')->id())->get() as $wish)

									{{-- === Select individual checkbox start ==== --}}
									<div class="check_individual_div">
										<input class="check_wish ml-2" type="checkbox" name="wish_id[]" value="{{$wish->id}}">
									</div>
									{{-- === Select individual checkbox end ==== --}}

									<div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3">
										<div class="cart_single d-flex align-items-center ml-3">
											<div class="cart_selected_single_thumb">
												<a href="{{route('product.details', $wish->rel_to_product->slug)}}"><img src="{{asset('uploads/product/preview')}}/{{$wish->rel_to_product->preview}}" width="60" class="img-fluid" alt="" /></a>
											</div>
											<div class="cart_single_caption pl-2">
												<a href="{{route('product.details', $wish->rel_to_product->slug)}}"><h4 class="product_title fs-sm ft-medium mb-3 lh-1">{{$wish->rel_to_product->product_name}}</h4></a>
												<h4 class="fs-md ft-medium mb-0 lh-1">&#2547; {{$wish->rel_to_product->after_discount}}/-</h4>
											</div>
										</div>

										<div class="fls_last">
											<button type="button" class="close_slide gray bg-danger">
												<a href="{{route('wish.remove', $wish->id)}}" onMouseOver="this.style.color='#db0000'" onMouseOut="this.style.color='#6c757d'" style="color: #6c757d">
													<i class="ti-close"></i>
												</a>
											</button>
										</div>
									</div>
								@endforeach
								
							</div>
							
							@if (App\Models\Wish::where('customer_id', Auth::guard('customerlogin')->id())->count() != 0)								
								<div class="cart_action px-3 mt-3">
									<div class="form-group">
										<a href="{{route('customer.customer_wish')}}" class="btn d-block full-width btn-dark-light">View Whishlist</a>
									</div>
								</div>

							@endif
							<div class="cart_action px-3 check_div d-none">
								<div class="form-group">
									<button type="button" class="btn d-block full-width btn-dark-light check_wish_btn">Remove Selected Wishes</button>
								</div>
							</div>						
						</div>
					</form>
				</div>
			</div>
			
			<!--=================== Cart ========================-->
			<!--=================== Cart ========================-->
			<div class="w3-ch-sideBar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="Cart">
				<div class="rightMenu-scroll">
					<div class="d-flex align-items-center justify-content-between slide-head py-3 px-3" >
						<h4 class="cart_heading fs-md ft-medium mb-0">Products List</h4>
						<button onclick="closeCart()" class="close_slide" onMouseOver="this.style.color='#db0000'" onMouseOut="this.style.color='#000'"><i class="ti-close"></i></button>
					</div>

					<form action="{{route('cart.remove_all_checked')}}" method="POST" id="check_cart_btn">
						@csrf
						<div class="right-ch-sideBar">

							@php
								$all_carts = App\Models\cart::where('customer_id', Auth::guard('customerlogin')->id())->count()
							@endphp

							{{-- === Select all checkbox start ==== --}}
							@if ($all_carts != 0)
								<div class="d-flex justify-content-start mt-2" style="font-weight: 500">
									<input type="checkbox" id="checkall_cart" class="ml-2 mr-2">Select All
								</div>
							@endif
							{{-- === Select all checkbox end ==== --}}
							
							<div class="cart_select_items py-2">
								<!-- Single Item -->
								@php
									$sub_total=0;
								@endphp
								@if (App\Models\Cart::where('customer_id', Auth::guard('customerlogin')->id())->count() == 0)
									<h5 class="text-center mt-4">No product add to cart yet!</h5>
								@endif

								@foreach (App\Models\Cart::where('customer_id', Auth::guard('customerlogin')->id())->get() as $cart)

									{{-- === Select individual checkbox start ==== --}}
										<div class="check_individual_div">
											<input class="check_cart ml-2" type="checkbox" name="cart_id[]" value="{{$cart->id}}">
										</div>
									{{-- === Select individual checkbox end ==== --}}

									<div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3">
										<div class="cart_single d-flex align-items-center ml-3">
											<div class="cart_selected_single_thumb">
												<a href="{{route('product.details', $cart->rel_to_product->slug)}}"><img src="{{asset('uploads/product/preview')}}/{{$cart->rel_to_product->preview}}" width="60" class="img-fluid" alt="" /></a>
											</div>
											<div class="cart_single_caption pl-2">
												<a href="{{route('product.details', $cart->rel_to_product->slug)}}"><h4 class="product_title fs-sm ft-medium mb-1 lh-1">{{$cart->rel_to_product->product_name}}</h4></a>
												<p class="text-dark ft-medium small mb-0">Color: {{$cart->rel_to_color->color_name}}</p>
												<p class="text-dark ft-medium small mb-1">Size: {{$cart->rel_to_size->size_name}}</p>
												<h4 class="fs-md ft-medium mb-0 lh-1">&#2547; {{$cart->rel_to_product->after_discount}} X {{$cart->quantity}}</h4>
											</div>
										</div>
										<div class="fls_last" style="width: 50px">
											@if (Route::currentRouteName() != 'checkout')
												<a href="{{route('cart.remove', $cart->id)}}" class="close_slide gray mb-2" onMouseOver="this.style.color='#db0000'" onMouseOut="this.style.color='#6c757d'" style="color: #6c757d"><i class="ti-close"></i></a>
											@endif
											
											<a href="{{route('wish.store_again', $cart->product_id)}}" class="close_slide gray" onMouseOver="this.style.color='#db0000'" onMouseOut="this.style.color='#6c757d'" style="color: #6c757d"><i class="far fa-heart fs-md"></i></a>
										</div>
									</div>
									@php
										$sub_total += $cart->rel_to_product->after_discount*$cart->quantity;
									@endphp
								@endforeach
							</div>					

							@if (App\Models\Cart::where('customer_id', Auth::guard('customerlogin')->id())->count() != 0)												
								<div class="d-flex align-items-center justify-content-between br-top br-bottom px-3 py-3">
									<h6 class="mb-0">Subtotal</h6>
									<h3 class="mb-0 ft-medium">&#2547; {{$sub_total}}/-</h3>
								</div>

								<div class="cart_action px-3 mt-3">
									<div class="form-group">
										<a href="{{route('cart')}}" class="btn d-block full-width btn-dark-light">View Cart</a>
									</div>
								</div>

							@endif
							<div class="cart_action px-3 check_div d-none">
								<div class="form-group">
									<button type="button" class="btn d-block full-width btn-dark-light check_cart_btn">Remove Selected</button>
								</div>
							</div>						
						</div>
					</form>
				</div>
			</div>
			
			<a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>
			

		</div>
		<!-- ============================================================== -->
		<!-- End Wrapper -->
		<!-- ============================================================== -->

		<!-- ============================================================== -->
		<!-- All Jquery -->
		<!-- ============================================================== -->
		<script src="{{asset('frontend/js/jquery.min.js')}}"></script>
		<script src="{{asset('frontend/js/popper.min.js')}}"></script>
		<script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
		<script src="{{asset('frontend/js/ion.rangeSlider.min.js')}}"></script>
		<script src="{{asset('frontend/js/slick.js')}}"></script>
		<script src="{{asset('frontend/js/slider-bg.js')}}"></script>
		<script src="{{asset('frontend/js/lightbox.js')}}"></script> 
		<script src="{{asset('frontend/js/smoothproducts.js')}}"></script>
		<script src="{{asset('frontend/js/snackbar.min.js')}}"></script>
		<script src="{{asset('frontend/js/jQuery.style.switcher.js')}}"></script>
		<script src="{{asset('frontend/js/custom.js')}}"></script>
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

		{{-- ======== preloader js on window reload ======== --}}
		<script>
			$(window).on('load', function () {
				$('#loader').fadeOut();
			}) 
		</script>


		{{-- ======== preloader js on button click ======== --}}
		{{-- <script>
			$(document).ready(function () {
				$("#order_btn").click(function () {
					$("#loader").show();
				});
			});
		</script> --}}


		<!-- ============================================================== -->
		<!-- This page plugins -->
		<!-- ============================================================== -->	

		{{-- Javascript & jQuery number format js --}}
		<script src="{{asset('frontend/js/jquery.number.js')}}"></script>

		{{-- ====== select2 plugin js link ====== --}}
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

		


	{{-- open & close wishlist tab, on click where apply the function- onclick="openWishlist()" & onclick="closeWishlist()" in HTML --}}
		<script>
			function openWishlist() {
				document.getElementById("Wishlist").style.display = "block";
			}
			function closeWishlist() {
				document.getElementById("Wishlist").style.display = "none";
			}
		</script>

		{{-- ====== close wishlist tab on click anywhere in window/body ====== --}}
		<script>
			document.addEventListener('mouseup', function (e) {
				var container = document.getElementById('Wishlist');

				if (!container.contains(e.target)) {
					container.style.display = 'none';
				}
			}.bind(this));
		</script>



	{{-- open & close cart tab, on click where apply the function- onclick="openCart()" & onclick="closeCart()" in HTML --}}
		<script>
			function openCart() {
				document.getElementById("Cart").style.display = "block";
			}
			function closeCart() {
				document.getElementById("Cart").style.display = "none";
			}
		</script>

		{{-- ====== close cart tab on click anywhere in window/body ====== --}}
		<script>
			document.addEventListener('mouseup', function (e) {
				var container = document.getElementById('Cart');

				if (!container.contains(e.target)) {
					container.style.display = 'none';
				}
			}.bind(this));
		</script>


		<script>
			function openSearch() {
				document.getElementById("Search").style.display = "block";
			}
			function closeSearch() {
				document.getElementById("Search").style.display = "none";
			}
		</script>	



		@if (session('wish_again_success'))
			<script>
				Swal.fire({
				position: 'top-end',
				icon: 'success',
				title: "{{session('wish_again_success')}}",
				showConfirmButton: false,
				timer: 2000
				})
			</script>
		@endif

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

		@if (session('wish_remove'))
			<script>
				Swal.fire({
				position: 'top-end',
				icon: 'success',
				title: "{{session('wish_remove')}}",
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

	{{-- ======================== Product search start ======================= --}}
		<script>
			$('#search_btn').click(function(){
				var search_info = $('#search_input').val();
				var catagory_id = $('input[class="catagory_id"]:checked').val();
				var color_id = $('input[class="color_id"]:checked').val();
				var size_id = $('input[class="size_id"]:checked').val();
				var sort = $('.sort').val();
				var min = $('.min').val();
				var max = $('.max').val();
				var link = "{{route('shop')}}"+"?keyword="+search_info+"&catagory="+catagory_id+"&color="+color_id+"&size="+size_id+"&min="+min+"&max="+max+"&sort="+sort;
				window.location.href = link;
			});

			$('#submit_btn').click(function(){
				var search_info = $('#search_input').val();
				var catagory_id = $('input[class="catagory_id"]:checked').val();
				var color_id = $('input[class="color_id"]:checked').val();
				var size_id = $('input[class="size_id"]:checked').val();
				var sort = $('.sort').val();
				var min = $('.min').val();
				var max = $('.max').val();
				var link = "{{route('shop')}}"+"?keyword="+search_info+"&catagory="+catagory_id+"&color="+color_id+"&size="+size_id+"&min="+min+"&max="+max+"&sort="+sort;
				window.location.href = link;
			});

			$('.catagory_id').click(function(){
				var search_info = $('#search_input').val();
				var catagory_id = $('input[class="catagory_id"]:checked').val();
				var color_id = $('input[class="color_id"]:checked').val();
				var size_id = $('input[class="size_id"]:checked').val();
				var sort = $('.sort').val();
				var min = $('.min').val();
				var max = $('.max').val();
				var link = "{{route('shop')}}"+"?keyword="+search_info+"&catagory="+catagory_id+"&color="+color_id+"&size="+size_id+"&min="+min+"&max="+max+"&sort="+sort;
				window.location.href = link;
			});

			$('.color_id').click(function(){
				var search_info = $('#search_input').val();
				var catagory_id = $('input[class="catagory_id"]:checked').val();
				var color_id = $('input[class="color_id"]:checked').val();
				var size_id = $('input[class="size_id"]:checked').val();
				var sort = $('.sort').val();
				var min = $('.min').val();
				var max = $('.max').val();
				var link = "{{route('shop')}}"+"?keyword="+search_info+"&catagory="+catagory_id+"&color="+color_id+"&size="+size_id+"&min="+min+"&max="+max+"&sort="+sort;
				window.location.href = link;
			});

			$('.size_id').click(function(){
				var search_info = $('#search_input').val();
				var catagory_id = $('input[class="catagory_id"]:checked').val();
				var color_id = $('input[class="color_id"]:checked').val();
				var size_id = $('input[class="size_id"]:checked').val();
				var sort = $('.sort').val();
				var min = $('.min').val();
				var max = $('.max').val();
				var link = "{{route('shop')}}"+"?keyword="+search_info+"&catagory="+catagory_id+"&color="+color_id+"&size="+size_id+"&min="+min+"&max="+max+"&sort="+sort;
				window.location.href = link;
			});

			$('.sort').change(function(){
				var search_info = $('#search_input').val();
				var catagory_id = $('input[class="catagory_id"]:checked').val();
				var color_id = $('input[class="color_id"]:checked').val();
				var size_id = $('input[class="size_id"]:checked').val();
				var sort = $('.sort').val();
				var min = $('.min').val();
				var max = $('.max').val();
				var link = "{{route('shop')}}"+"?keyword="+search_info+"&catagory="+catagory_id+"&color="+color_id+"&size="+size_id+"&min="+min+"&max="+max+"&sort="+sort;
				window.location.href = link;
			});
		</script>
	{{-- ======================== Product search end ======================= --}}

	{{-- ================================= Checked wishes start ============================ --}}
	{{-- =================================================================================== --}}

		{{-- ===== check all with enable or disable delete all button ===== --}}
		<script>
			$("#checkall_wish").on('click', function(){
				this.checked ? $(".check_wish").prop("checked",true) : $(".check_wish").prop("checked",false);  
				var checked_pro = $("input:checkbox:checked").length

				if(checked_pro != 0){
					$('.check_div').removeClass('d-none');
				}
				else{
					$('.check_div').addClass('d-none');
				}
			})
		</script>
		
		{{-- ===== check individual with enable or disable delete all button ===== --}}
		<script>
			$('.check_wish').click(function(){
				var checked_pro = $("input:checkbox:checked").length

				if(checked_pro != 0){
					$('.check_div').removeClass('d-none');
				}
				else{
					$('.check_div').addClass('d-none');
				}
			});
		</script>

		{{-- ===== Remove all checked wishes ===== --}}
		<script>
			$('.check_wish_btn').click(function(){
				Swal.fire({
				title: 'Are you sure?',
				icon: 'question',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, Remove Wishes!'
				}).then((result) => {
					if (result.isConfirmed) {
						$('#check_wish_btn').submit();
					}
				})
			});
		</script>

		{{-- ===== All checked wishes removed success message ===== --}}
		@if (session('checked_wish_delete'))
			<script>
				Swal.fire({
				position: 'top-end',
				icon: 'success',
				title: "{{session('checked_wish_delete')}}",
				showConfirmButton: false,
				timer: 2000
				})
			</script>
		@endif



	{{-- ================================= Checked cart start ============================ --}}
	{{-- =================================================================================== --}}

		{{-- ===== check all with enable or disable delete all button ===== --}}
		<script>
			$("#checkall_cart").on('click', function(){
				this.checked ? $(".check_cart").prop("checked",true) : $(".check_cart").prop("checked",false);  
				var checked_pro = $("input:checkbox:checked").length

				if(checked_pro != 0){
					$('.check_div').removeClass('d-none');
				}
				else{
					$('.check_div').addClass('d-none');
				}
			})
		</script>
		
		{{-- ===== check individual with enable or disable delete all button ===== --}}
		<script>
			$('.check_cart').click(function(){
				var checked_pro = $("input:checkbox:checked").length

				if(checked_pro != 0){
					$('.check_div').removeClass('d-none');
				}
				else{
					$('.check_div').addClass('d-none');
				}
			});
		</script>


		{{-- ===== Remove all checked carts ===== --}}
		<script>
			$('.check_cart_btn').click(function(){
				Swal.fire({
				title: 'Are you sure?',
				icon: 'question',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, Remove From Cart!'
				}).then((result) => {
					if (result.isConfirmed) {
						$('#check_cart_btn').submit();
					}
				})
			});
		</script>

		{{-- ===== All checked carts removed success message ===== --}}
		@if (session('checked_cart_delete'))
			<script>
				Swal.fire({
				position: 'top-end',
				icon: 'success',
				title: "{{session('checked_cart_delete')}}",
				showConfirmButton: false,
				timer: 2000
				})
			</script>
		@endif

		@yield('footer_script')	

	</body>

</html>