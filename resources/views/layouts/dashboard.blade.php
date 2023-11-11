<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pikter IT - Admin Dashboard</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png">
	<link rel="stylesheet" href="{{asset('dashboard/vendor/chartist/css/chartist.min.css')}}">
    <link href="{{asset('dashboard/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
	<link href="{{asset('dashboard/vendor/owl-carousel/owl.carousel.css')}}" rel="stylesheet">
	<link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="{{asset('dashboard/css/style.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">


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
		.message_notification{
			position: absolute;
			bottom: 0px;
			left: 0;
			padding: 15px 75px 15px 75px;
			background: #e0e0e0;
		}
		.order_notification{
			position: absolute;
			bottom: 0px;
			left: 0;
			padding: 15px 91px 15px 91px;
			background: #e0e0e0;
		}
		.brand-logo .brand_title{
			font-family: 'Poppins', sans-serif;
			font-weight: 700;
			font-size: 28px;
			position: relative;
			padding-right: 25px;
		}
		.brand_slogan{
			position: absolute;
			top: 100%;
			left: 0;
			font-weight: 300;
			font-size: 10px;
		}
	</style>

</head>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
		@php
			$site_details = App\Models\SiteInfo::get()->first();
		@endphp

        <div class="nav-header">
            <a href="{{route('home')}}" class="brand-logo">
				<img src="{{asset('uploads/site_logo')}}/{{$site_details->site_logo}}" class="brand_logo_img img-fluid rounded mr-2" alt="Site Logo" style="width: 65px"/>
				<h2 class="brand_title"></span>{{$site_details->site_name}}<span class="brand_slogan">{{$site_details->site_slogan}}</span> </h2>
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->
		
		
		<!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar">
								Dashboard
                            </div>
                        </div>
                        <ul class="navbar-nav header-right">
							<li class="nav-item">
								<div class="input-group search-area d-xl-inline-flex d-none">
									<div class="input-group-append">
										<span class="input-group-text"><a href="javascript:void(0)"><i class="flaticon-381-search-2"></i></a></span>
									</div>
									<input type="text" class="form-control" placeholder="Search here...">
								</div>
							</li>

							{{-- ========== Customer message notification =========== --}}
							@php
								$total_new_message = App\Models\CustomerMessage::where('notification_status', 0)->count();
							@endphp
							<li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link  ai-icon" href="javascript:void(0)" role="button" data-toggle="dropdown">
                                    <i class="fa fa-envelope"></i>
									<div class="pulse-css text-primary text-center">{{$total_new_message}}</div>
                                </a>

                                <div class="dropdown-menu rounded dropdown-menu-right">
                                    <div id="DZ_W_Notification1" class="widget-media dz-scroll p-3 height380">
										<p style="border-bottom: 1px solid #c1c1c1" class="text-center">New Message Notifications</p>
										<ul class="timeline">
											@if ($total_new_message == 0)
												<p class="text-center font-weight-bold text-danger">No New Message</p>
												@else
												@foreach (App\Models\CustomerMessage::where('notification_status', 0)->orderBy('created_at','desc')->get() as $message)
													<li>
														<a href="{{route('customer_message_details', $message->id)}}">
															<div class="timeline-panel">
																<div class="media-body text-center">
																	<h6 class="mb-1">{{$message->name}}</h6>
																	<small class="d-block">{{$message->created_at->format('d M, Y')}}</small>
																</div>
															</div>
														</a>
													</li>
												@endforeach
											@endif										
										</ul>
									</div>
									<div class="message_notification text-center">
										<a href="{{route('customer_message')}}">See all messages <i class="ti-arrow-right"></i></a>
									</div>
                                </div>
                            </li>

							{{-- ============= Order placed notification ============= --}}
							@php
								$total_new_order = App\Models\Order::where('notification_status', 0)->count();
							@endphp
							<li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link  ai-icon" href="javascript:void(0)" role="button" data-toggle="dropdown">
                                    <i class="fa fa-shopping-bag"></i>
									<div class="pulse-css text-primary text-center">{{$total_new_order}}</div>
                                </a>

                                <div class="dropdown-menu rounded dropdown-menu-right">
                                    <div id="DZ_W_Notification1" class="widget-media dz-scroll p-3 height380">
										<p style="border-bottom: 1px solid #c1c1c1" class="text-center">New Order Notifications</p>
										<ul class="timeline">
											@if ($total_new_order == 0)
												<p class="text-center font-weight-bold text-danger">No New Order</p>
												@else
												@foreach (App\Models\Order::where('notification_status', 0)->orderBy('created_at','desc')->get() as $notification_status)
													<li>
														<a href="{{route('order.details', $notification_status->id)}}">
															<div class="timeline-panel">
																<div class="media mr-2">
																	@if ($notification_status->rel_to_customer->profile_image == null)
																		<img alt="image" width="50" src="{{ Avatar::create($notification_status->rel_to_customer->name)->toBase64() }}" />
																		@else
																		<img alt="image" width="50" src="{{asset('uploads/customer')}}/{{$notification_status->rel_to_customer->profile_image}}">
																	@endif
																</div>
																<div class="media-body">
																	<h6 class="mb-1">{{$notification_status->rel_to_customer->name}}</h6>
																	<small class="d-block">{{$notification_status->created_at->format('d M, Y')}}</small>
																</div>
															</div>
														</a>
													</li>
												@endforeach
											@endif
										</ul>
									</div>
									<div class="order_notification text-center">
										<a href="{{route('order_list')}}">See all orders <i class="ti-arrow-right"></i></a>
									</div>
                                </div>
                            </li>
							@php
								$user = Auth::user();
							@endphp
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link dropdown-toggle" href="javascript:void(0)" role="button" data-toggle="dropdown">
									@if (Auth::user()->image == null)
										<img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" />
										@else
										<img src="{{asset('uploads/user')}}/{{Auth::user()->image}}" alt="Profile Image">
									@endif
                                    
									<div class="header-info">
										<span class="text-black"><strong>{{Auth::user()->name}}</strong></span>			
										<p class="fs-12 mb-0">Super Admin</p>
									</div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="{{route('profile')}}" class="dropdown-item ai-icon">
                                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <span class="ml-2">Profile </span>
                                    </a>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById    ('logout-form').submit();" class="dropdown-item ai-icon">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                        <span class="ml-2">Logout </span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
				<ul class="metismenu" id="menu">
                    <li><a class="ai-icon" href="{{route('home')}}" aria-expanded="false">
							<i class="flaticon-381-networking"></i>
							<span class="nav-text">Dashboard</span>
						</a>
                    </li> 
					<li><a class="ai-icon" href="{{route('site_info')}}" aria-expanded="false">
							<i class="fa fa-cog"></i>
							<span class="nav-text">Site Info</span>
						</a>
					</li> 
					@can('user_delete')
						<li><a class="ai-icon" href="{{route('user')}}" aria-expanded="false">
								<i class="fa fa-group"></i>
								<span class="nav-text">Users</span>
							</a>
						</li> 
					@endcan   
					
					@can('role_management')
						<li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
								<i class="fa fa-tasks"></i>
								<span class="nav-text">Role Management</span>
							</a>
							<ul aria-expanded="false">
								<li><a href="{{route('role.create')}}">Create Role</a></li>
								<li><a href="{{route('role.assign')}}">Assign Role</a></li>
								<li><a href="{{route('permission.assign')}}">Assign Special Permission</a></li>
							</ul>
						</li>   
					@endcan

                    <li><a class="ai-icon" href="{{route('profile')}}" aria-expanded="false">
							<i class="fa fa-user-circle-o"></i>
							<span class="nav-text">Profile</span>
						</a>
                    </li>  
					
					<li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="fa fa-list"></i>
							<span class="nav-text">Catagory</span>
						</a>
						<ul aria-expanded="false">
							<li><a href="{{route('catagory')}}">Catagory List</a></li>
							<li><a href="{{route('subcatagory')}}">Subcatagory List</a></li>
						</ul>
					</li>                               
					<li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="fa fa-shopping-bag"></i>
							<span class="nav-text">Product</span>
						</a>
						<ul aria-expanded="false">
							<li><a href="{{route('product')}}">Product List</a></li>
							<li><a href="{{route('product.trashed')}}">Trashed Product List</a></li>
							@can('product_add')
								<li><a href="{{route('product.add')}}">Add Product</a></li>
							@endcan
							<li><a href="{{route('product.variation')}}">Product Variation</a></li>
						</ul>
					</li> 
					<li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="fa fa-tags"></i>
							<span class="nav-text">Coupon</span>
						</a>
						<ul aria-expanded="false">
							@can('coupon_add')
								<li><a href="{{route('coupon.add')}}">Coupon Add</a></li>
							@endcan
							<li><a href="{{route('coupon')}}">Coupon List</a></li>
							<li><a href="{{route('coupon.trashed')}}">Coupon Trashed List</a></li>
						</ul>
					</li>                              
					<li><a class="ai-icon" href="{{route('charge')}}" aria-expanded="false">
							<i class="fa fa-truck"></i>
							<span class="nav-text">Delivery Charge</span>
						</a>
					</li>                              
					<li><a class="ai-icon" href="{{route('order_list')}}" aria-expanded="false">
							<i class="fa fa-paper-plane"></i>
							<span class="nav-text">Order List</span>
						</a>
					</li>   
					<li><a class="ai-icon" href="{{route('customer_message')}}" aria-expanded="false">
							<i class="fa fa-envelope"></i>
							<span class="nav-text">Customer Message</span>
						</a>
					</li>   
					<li><a class="ai-icon" href="{{route('report')}}" aria-expanded="false">
							<i class="fa fa-history"></i>
							<span class="nav-text">Report</span>
						</a>
					</li>   				                             
                </ul>
			</div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->
		
		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
                @yield('content')
            </div>
            
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="http://dexignzone.com/" target="_blank">DexignZone</a> 2020</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

		<!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{asset('dashboard/vendor/global/global.min.js')}}"></script>
	<script src="{{asset('dashboard/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
	<script src="{{asset('dashboard/vendor/chart.js/Chart.bundle.min.js')}}"></script>
    <script src="{{asset('dashboard/js/custom.min.js')}}"></script>
	<script src="{{asset('dashboard/js/deznav-init.js')}}"></script>
	<script src="{{asset('dashboard/vendor/owl-carousel/owl.carousel.js')}}"></script>
	
	<!-- Chart piety plugin files -->
    <script src="{{asset('dashboard/vendor/peity/jquery.peity.min.js')}}"></script>
	
	<!-- Apex Chart -->
	<script src="{{asset('dashboard/vendor/apexchart/apexchart.js')}}"></script>
	<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
	
	<!-- Dashboard 1 -->
	<script src="{{asset('dashboard/js/dashboard/dashboard-1.js')}}"></script>
	
	<!-- chart.js -->
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	{{-- sweet alert js --}}
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	

	<script>
		function carouselReview(){
			/*  testimonial one function by = owl.carousel.js */
			jQuery('.testimonial-one').owlCarousel({
				loop:true,
				autoplay:true,
				margin:30,
				nav:false,
				dots: false,
				left:true,
				navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
				responsive:{
					0:{
						items:1
					},
					484:{
						items:2
					},
					882:{
						items:3
					},	
					1200:{
						items:2
					},			
					
					1540:{
						items:3
					},
					1740:{
						items:4
					}
				}
			})			
		}
		jQuery(window).on('load',function(){
			setTimeout(function(){
				carouselReview();
			}, 1000); 
		});
	</script>
	@yield('footer_script')
</body>
</html>