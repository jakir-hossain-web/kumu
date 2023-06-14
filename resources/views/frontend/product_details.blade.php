@extends('frontend.master')

<style>
	.customer_login_reg a {
		transition: .5s;
		color: #f33066;
		background: #f8adc2;
		margin-left: 5px;
		padding: 5px 10px;
		border-radius: 3px;
	}
	.customer_login_reg a:hover{
		background: #f33066;
		color: #fff;
	}
	.all_review{
		position: fixed;
		top: 0;
		left: 0;
		width: 100vw;
		z-index: 9999;
		background: rgba(0, 0, 0, 0.85);
		opacity: 0;
		visibility: hidden;
		padding-bottom: 150px;
		transition: .3s;
	}
	.all_review_head{
		padding: 50px 0 10px 0;
		width: 75%;
		margin: 0 auto;
		position: relative;
	}
	.all_review_head h3{
		position: absolute;
		top: 50px;
		right: 0;
	}
	.all_review_part{
		background: rgba(0, 0, 0, 0.5);
		margin: 50px 0;
		padding: 50px 30px;
		height: 90vh;
		width: 75%;
		margin: 0 auto;
		overflow-y: scroll;
		scrollbar-width: none;
	}
	.reviews_rate{
		margin-top: 70px !important;
	}
</style>

@section('content')
<div class="">
	<!-- ======================= Top Breadcrubms ======================== -->
	<div class="gray py-3">
		<div class="container">
			<div class="row">
				<div class="colxl-12 col-lg-12 col-md-12">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{route('front.home')}}">Home</a></li>
							<li class="breadcrumb-item active" aria-current="page">Product Details</li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
	</div>
	<!-- ======================= Top Breadcrubms ======================== -->
	
	<!-- ======================= Product Detail ======================== -->
	<section class="middle">
		<div class="container">
			<div class="row justify-content-between">
				<div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
					<div class="quick_view_slide">
							@foreach ($thumbnails as $thumbnail)   
							<div class="single_view_slide"><a href="assets/img/product/4.jpg" data-lightbox="roadtrip" class="d-block mb-4"><img src="{{asset('uploads/product/thumbnails')}}/{{$thumbnail->thumbnail}}" class="img-fluid rounded" alt="" /></a></div>
							@endforeach
						</div>
					</div>
				
				<div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
					<div class="prd_details pl-3">
							
						<div class="prt_01 mb-1"><span class="text-light bg-info rounded px-2 py-1">{{$product_info->first()->rel_to_catagory->catagory_name}}</span></div>
						<div class="prt_02 mb-3">
							<h2 class="ft-bold mb-1">{{$product_info->first()->product_name}}</h2>
							<div class="text-left">

								{{-- ==== single product average rating start ==== --}}
								@php
									$review_count = App\Models\OrderProduct::where('product_id', $product_info->first()->id)->whereNotNull('review')->count();

									$review_sum = App\Models\OrderProduct::where('product_id', $product_info->first()->id)->whereNotNull('review')->sum('star');
								@endphp

								@if ($review_count != 0)
								
									@php
										$average_rating = round($review_sum/$review_count);
									@endphp

									<div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
										
										@for ($i=1; $i<=5-$average_rating; $i++)
											<i class="fas fa-star"></i>
										@endfor
										<span class="small">({{$review_count}} Reviews)</span>
									</div>
									@else
									<div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
										@for ($i=1; $i<=5; $i++)
											<i class="fas fa-star"></i>
										@endfor
										<span class="small">(0 Reviews)</span>
									</div>
								@endif
								{{-- ==== single product average rating end ==== --}}

								<div class="elis_rty">
									@if ($product_info->first()->discount)
										<span class="ft-medium text-muted line-through fs-md mr-2">&#2547; {{$product_info->first()->price}}</span>
									@endif
									<span class="ft-bold theme-cl fs-lg mr-2">&#2547; {{$product_info->first()->after_discount}}</span>
								</div>
							</div>
						</div>
						
						<div class="prt_03 mb-4">
							<p>{{$product_info->first()->key_features}}</p>
						</div>
						<!--==================== Add to cart form start ====================-->
						<form action="{{route('cart.store')}}" method="POST">
							@csrf
							<!--============ color ============-->
							<div class="prt_04 mb-2">
								@error('color_id')
									<strong class="text-danger">{{$message}}</strong>
								@enderror
								<p class="d-flex align-items-center mb-0 text-dark ft-medium">Color:</p>
								<div class="text-left">
									@if ($available_colors->count() == 1)
										@foreach ($available_colors as $available_color)
											<div class="form-check form-option form-check-inline mb-1">
												<input class="form-check-input color_class" type="radio" name="color_id" value="{{$available_color->color_id}}" id="white{{$available_color->color_id}}" checked>
												<label class="form-option-label rounded-circle" for="white{{$available_color->color_id}}"><span class="form-option-color rounded-circle" style="background:{{$available_color->rel_to_color->color_code}}">
													@if ($available_color->color_id == 1)
													{{$available_color->rel_to_color->color_name}}
													@endif
												</span></label>
											</div>
										@endforeach
										@else
										@foreach ($available_colors as $available_color)
											<div class="form-check form-option form-check-inline mb-1">
												<input class="form-check-input color_class" type="radio" name="color_id" value="{{$available_color->color_id}}" id="white{{$available_color->color_id}}">
												<label class="form-option-label rounded-circle" for="white{{$available_color->color_id}}"><span class="form-option-color rounded-circle" style="background:{{$available_color->rel_to_color->color_code}}">
													@if ($available_color->color_id == 1)
														{{$available_color->rel_to_color->color_name}}
													@endif
												</span></label>
											</div>
										@endforeach
									@endif
								</div>
							</div>
							
							<!--============ size ============-->
							<div class="prt_04 mb-4">
								@error('size')
									<strong class="text-danger">{{$message}}</strong>
								@enderror
								<p class="d-flex align-items-center mb-0 text-dark ft-medium">Size:</p>
								<div class="text-left pb-0 pt-2 ajax_size">
									@if ($available_sizes->count() == 1)
										@foreach ($available_sizes as $available_size)
											<div class="form-check size-option form-option form-check-inline mb-2">
												<input class="form-check-input" type="radio" name="size" value="{{$available_size->size_id}}" id="{{$available_size->size_id}}" checked>
												<label class="form-option-label" for="{{$available_size->size_id}}">{{$available_size->rel_to_size->size_name}}
												</label>
											</div>
										@endforeach
										@else
										@foreach ($available_sizes as $available_size)
											<div class="form-check size-option form-option form-check-inline mb-2">
												<input class="form-check-input" type="radio" name="size" value="{{$available_size->size_id}}" id="{{$available_size->size_id}}">
												<label class="form-option-label" for="{{$available_size->size_id}}">{{$available_size->rel_to_size->size_name}}</label>
											</div>
										@endforeach
									@endif
								</div>
							</div>
							
							<div class="prt_05 mb-4">
								<div class="form-row mb-7">
									<div class="col-12 col-lg-auto">
										<!--============ Quantity ============-->
										<select class="mb-2 custom-select" name="quantity">
											<option value="1" selected="">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
										</select>
									</div>
									<div class="col-12 col-lg">
										<!--============ submit ============-->
										<input type="hidden" name="product_id" value="{{$product_info->first()->id}}">
										<button type="submit" class="btn btn-block custom-height bg-dark mb-2">
											<i class="lni lni-shopping-basket mr-2"></i>Add to Cart 
										</button>
									</div>
									<div class="col-12 col-lg-auto">
										<!--=========== Wishlist ============-->
										@forelse ($wishlists as $wishlist)
											@if ($wishlist)
												<a class="btn custom-height btn-default btn-block mb-2 text-white bg-danger" href="{{route('wish.remove', $wishlist->id)}}">
													<i class="lni lni-heart mr-2"></i>Remove Wishlist
												</a>
											@endif
										@empty
											<button class="btn custom-height btn-default btn-block mb-2 text-white bg-success" formaction="{{route('wish.store')}}">
												<i class="lni lni-heart mr-2"></i>Add Wishlist
											</button>
										@endforelse
									</div>
								</div>
							</div>
						</form>
						<!--============ Add to cart form end ============-->

						<!--============ social share start ============-->
						<div class="prt_06 d-flex align-items-center justify-content-start">
							<div>
								<span style="font-size: 16px; color:#707070; font-weight: 600">Share:</span>
							</div>
							<div class="social-btn-sp">
								{!! $shareButtons !!}
							</div>
						</div>
						<!--============ social share end ============-->						
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- ======================= Product Detail End ======================== -->
	
	<!-- ======================= Product Description ======================= -->
	<section class="middle">
		<div class="container">
			<div class="row align-items-center justify-content-center">
				<div class="col-xl-11 col-lg-12 col-md-12 col-sm-12">
					<ul class="nav nav-tabs b-0 d-flex align-items-center justify-content-center simple_tab_links mb-4" id="myTab" role="tablist">
						<li class="nav-item active" role="presentation">
							<a class="nav-link" id="description-tab" href="#description" data-toggle="tab" role="tab" aria-controls="description" aria-selected="true">Description</a>
						</li>
						<li class="nav-item" role="presentation">
							<a class="nav-link" href="#information" id="information-tab" data-toggle="tab" role="tab" aria-controls="information" aria-selected="false">Additional information</a>
						</li>
						<li class="nav-item" role="presentation">
							<a class="nav-link" href="#reviews" id="reviews-tab" data-toggle="tab" role="tab" aria-controls="reviews" aria-selected="false">Reviews</a>
						</li>
					</ul>
					
					<div class="tab-content" id="myTabContent">
						
						<!-- Description Content -->
						<div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
							<div class="description_info">
								<p class="p-0 mb-2">{!!$product_info->first()->description!!}</p>
							</div>
						</div>
						
						<!-- Additional Content -->
						<div class="tab-pane fade" id="information" role="tabpanel" aria-labelledby="information-tab">
							<div class="additionals">
								<table class="table">
									<tbody>
										<tr>
											<th class="ft-medium text-dark">ID</th>
											<td>#1253458</td>
										</tr>
										<tr>
											<th class="ft-medium text-dark">SKU</th>
											<td>KUM125896</td>
										</tr>
										<tr>
											<th class="ft-medium text-dark">Color</th>
											<td>Sky Blue</td>
										</tr>
										<tr>
											<th class="ft-medium text-dark">Size</th>
											<td>Xl, 42</td>
										</tr>
										<tr>
											<th class="ft-medium text-dark">Weight</th>
											<td>450 Gr</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						
						<!-- Reviews Content -->
						@php
							$reviews = App\Models\OrderProduct::where('product_id', $product_info->first()->id)->whereNotNull('review')->take(3)->orderBy('updated_at','desc')->get();

							$all_reviews = App\Models\OrderProduct::where('product_id', $product_info->first()->id)->whereNotNull('review')->orderBy('updated_at','desc')->get();
						@endphp

						<div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab" style="position: relative">

							{{-- ===== pop-up window all review start ===== --}}
							<div class="all_review">
								<div class="all_review_head">
									<h1 class="text-center text-warning">All Reviews</h1>
									<h3 class="all_review_return btn btn-dark text-warning border border-warning">
										<i class="fa fa-arrow-left mr-2"></i>Return Back
									</h3>
								</div>
								<div class="all_review_part">
									@forelse ($all_reviews as $review)
										<div class="single_rev d-flex align-items-start br-bottom py-3" style="position: relative">
											<div class="single_rev_thumb">

												@if ($review->rel_to_customer->profile_image == null)
													<img class="circle" width="60" src="{{ Avatar::create($review->rel_to_customer->name)->toBase64() }}" alt="Profile Image"/>
													@else
													<img class="circle" width="60" src="{{asset('uploads/customer')}}/{{$review->rel_to_customer->profile_image}}" alt="Profile Image">
												@endif								

											</div>
											<div class="single_rev_caption pl-3">
												<div class="single_capt_left">
													<h4 class="mb-0 fs-md ft-medium lh-1 text-white">
														{{$review->rel_to_customer->name}}
													</h4>
													<span class="small text-warning">
														{{$review->updated_at->format('d M Y')}}
													</span>
													<p class="text-white">{{$review->review}}</p>
												</div>
												<div class="single_capt_right" style="position: absolute; top: 15px; right: 0;">
													<div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
														@for ($i=1; $i<=$review->star; $i++)
															<i class="fas fa-star filled"></i>
														@endfor
														@for ($i=1; $i<=5-$review->star; $i++)
															<i class="fas fa-star"></i>
														@endfor
													</div>
												</div>
											</div>
										</div>									
										@empty
										<h4 class="customer_login_reg alert alert-danger text-center">No review submitted yet!</h4>
									@endforelse	
									<div class="d-flex justify-content-center">
										<h3 class="all_review_return btn btn-dark text-warning mt-3 border border-warning">
											<i class="fa fa-arrow-left mr-2"></i>Return Back
										</h3>
									</div>
								</div>
							</div>
							{{-- ===== pop-up window all review end ===== --}}

							<!-- Single Review start -->
							@forelse ($reviews as $review)
								<div class="single_rev d-flex align-items-start br-bottom py-3" style="position: relative">
									<div class="single_rev_thumb">

										@if ($review->rel_to_customer->profile_image == null)
											<img class="circle" width="60" src="{{ Avatar::create($review->rel_to_customer->name)->toBase64() }}" alt="Profile Image"/>
											@else
											<img class="circle" width="60" src="{{asset('uploads/customer')}}/{{$review->rel_to_customer->profile_image}}" alt="Profile Image">
										@endif								

									</div>
									<div class="single_rev_caption pl-3">
										<div class="single_capt_left">
											<h5 class="mb-0 fs-md ft-medium lh-1">
												{{$review->rel_to_customer->name}}
											</h5>
											<span class="small">
												{{$review->updated_at->format('d M Y')}}
											</span>
											<p>{{$review->review}}</p>
										</div>
										<div class="single_capt_right" style="position: absolute; top: 15px; right: 0;">
											<div class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
												@for ($i=1; $i<=$review->star; $i++)
													<i class="fas fa-star filled"></i>
												@endfor
												@for ($i=1; $i<=5-$review->star; $i++)
													<i class="fas fa-star"></i>
												@endfor
											</div>
										</div>
									</div>
								</div>									
								@empty
								<h4 class="customer_login_reg alert alert-danger text-center">No review submitted yet!</h4>
							@endforelse	
							@if ($review_count >= 4)
								<div class="text-center mt-3 mb-3">
									<h3 class="btn btn-dark" id="all_review">View All Reviews
										<i class="fa fa-arrow-right ml-2"></i>
									</h3>
								</div>
							@endif
							<!-- Single Review end -->

							@auth('customerlogin')

								@if (App\Models\OrderProduct::where('customer_id', Auth::guard('customerlogin')->id())->where('product_id', $product_info->first()->id)->exists())

									<div class="reviews_rate">
										<form class="row" action="{{route('review.update', $product_info->first()->id)}}" method="POST">
											@csrf

											<div style="margin: 0 auto">
												@if (session('review_update_error'))
													<strong class="alert alert-danger" style="font-size: 20px;">{{session('review_update_error')}}</strong>
												@endif	
											</div>

											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-1">
												<h4>Submit Rating: </h4>
											</div>
											
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
												<div class="revie_stars d-flex align-items-center justify-content-between px-2 py-2 gray rounded mb-2 mt-1">
													<div class="srt_013">
														<div class="submit-rating">
															<input class="star" id="star-5" type="radio" name="star" value="5" />
															<label for="star-5" title="5 stars">
																<i class="active fa fa-star" aria-hidden="true"></i>
															</label>

															<input class="star" id="star-4" type="radio" name="star" value="4" />
															<label for="star-4" title="4 stars">
																<i class="active fa fa-star" aria-hidden="true"></i>
															</label>

															<input class="star" id="star-3" type="radio" name="star" value="3" />
															<label for="star-3" title="3 stars">
																<i class="active fa fa-star" aria-hidden="true"></i>
															</label>

															<input class="star" id="star-2" type="radio" name="star" value="2" />
															<label for="star-2" title="2 stars">
																<i class="active fa fa-star" aria-hidden="true"></i>
															</label>
															
															<input class="star" id="star-1" type="radio" name="star" value="1" selected/>
															<label for="star-1" title="1 star">
																<i class="active fa fa-star" aria-hidden="true"></i>
															</label>
														</div>
													</div>

													<div class="srt_014">
														<h6 class="mb-0">
															<span id="selected_star">
																@if ($review_count != 0)
																	{{$average_rating}} 
																	@else
																	0
																@endif
															</span> Star
														</h6>
													</div>
												</div>
											</div>
											
											<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
												<div class="form-group">
													<label class="medium text-dark ft-medium">Full Name</label>
													<input type="text" class="form-control" value="{{Auth::guard('customerlogin')->user()->name}}"/>
												</div>
											</div>
											
											<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
												<div class="form-group">
													<label class="medium text-dark ft-medium">Email Address</label>
													<input type="email" class="form-control" value="{{Auth::guard('customerlogin')->user()->email}}"/>
												</div>
											</div>
											
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
												<div class="form-group">
													<label class="medium text-dark ft-medium">Description</label>
													<textarea class="form-control" name="review"> {{old('review')}} </textarea>
												</div>
											</div>
											
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
												<div class="form-group m-0">
													<button type="submit" class="review_btn btn btn-white stretched-link hover-black">Submit Review <i class="lni lni-arrow-right"></i></button>
												</div>
											</div>
											
										</form>
									</div>
									@else
									<h4 class="customer_login_reg alert alert-danger text-center">To submit your review please purchase the product first</h4>
								@endif

								@else
								<h4 class="customer_login_reg alert alert-danger text-center">To submit your review please login first -----> 
									<a href="{{route('customer.login.register')}}">Login Here</a>
								</h4>
							@endauth
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- ======================= Product Description End ==================== -->
	
	<!-- ======================= Similar Products Start ============================ -->
	<section class="middle pt-0">
		<div class="container">
			
			<div class="row justify-content-center">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
					<div class="sec_title position-relative text-center">
						<h2 class="off_title">Similar Products</h2>
						<h3 class="ft-bold pt-3">Matching Producta</h3>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
					<div class="slide_items">
						
						@forelse ($related_products as $related_product)
							<!-- single Item -->
							<div class="single_itesm">
								<div class="product_grid card b-0 mb-0">
									@if ($related_product->discount)
										<div class="badge bg-info text-white position-absolute ab-left text-upper" style="font-size: 13px">-{{$related_product->discount}}%</div>
										<div class="badge position-absolute ft-regular ab-right text-upper" onMouseOver="this.style.background='#cc164a'" onMouseOut="this.style.background='#f33066'" style="background: #f33066">
											<a href="{{route('wish.store_again', $related_product->id)}}" style="color: #fff"><i class="far fa-heart fs-lg"></i></a>
										</div>
										
										@else
										<div class="badge bg-success text-white position-absolute ab-left text-upper" style="font-size: 13px">New</div>
										<div class="badge position-absolute ft-regular ab-right text-upper" onMouseOver="this.style.background='#cc164a'" onMouseOut="this.style.background='#f33066'" style="background: #f33066">
											<a href="{{route('wish.store_again', $related_product->id)}}" style="color: #fff"><i class="far fa-heart fs-lg"></i></a>
										</div>
									@endif
									<div class="card-body p-0">
										<div class="shop_thumb position-relative">
											<a class="card-img-top d-block overflow-hidden" href="{{route('product.details', $related_product->slug)}}"><img class="card-img-top" src="{{asset('uploads/product/preview')}}/{{$related_product->preview}}" alt="..."></a>
										</div>
									</div>
									<div class="card-footer b-0 p-3 pb-0 d-flex align-items-start justify-content-center">
										<div class="text-left">
											<div class="text-center">
												<h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="{{route('product.details', $related_product->slug)}}">{{$related_product->product_name}}</a></h5>
												
												<div class="elis_rty">
													@if ($related_product->discount)
													<span class="ft-medium text-muted fs-md line-through">&#2547; {{$related_product->price}}</span>2
												@endif
													<span class="ft-bold fs-md text-dark">&#2547; {{$related_product->after_discount}}</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							@empty
							<h3 class="text-center">No Related Product Found!</h3>
						@endforelse

					</div>
				</div>
			</div>
			
		</div>
	</section>
</div>
@endsection

@section('footer_script')

	{{-- ======= return back to a review tab ======= --}}
	<script>
		$(document).ready(function () {
        	$('#myTab a[href="#{{ old('tab') }}"]').tab('show')
        });
	</script>
	
	{{-- ======= scrollTop js to view the review part of the page ======= --}}
	@if (session('review_update'))
        <script>
			$(document).ready(function() {
				$('html, body').animate({
					scrollTop: 800
				}, 1000);
			});
			Swal.fire({
			position: 'top-end',
            icon: 'success',
            title: "{{session('review_update')}}",
            showConfirmButton: false,
            timer: 2000
            })
		</script>
    @endif

	{{-- ======= scrollTop js to show the review submit error ======= --}}
	@if (session('review_update_error'))
        <script>
			$(document).ready(function() {
				$('html, body').animate({
					scrollTop: 1340
				}, 1000);
			});
		</script>
    @endif

	<script>
		$('#all_review').click(function(){
			$('.all_review').css({
				'opacity': '1',
				'visibility': 'visible',
			});
			$('body').css({
				'overflow': 'hidden',
			})
		})
	</script>

	<script>
		$('.all_review_return').click(function(){
			$('.all_review').css({
				'opacity': '0',
				'visibility': 'hidden',
			});
			$('body').css({
				'overflow-y': 'scroll',
			})
		})
	</script>

	<script>
		$('.color_class').click(function(){
			var product_id = "{{$product_info->first()->id}}";
			var color_id = $(this).val();
			

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$.ajax({
				url:'/getSize',
				type:'POST',
				data:{'product_id': product_id, 'color_id': color_id},
				success:function(data){
					$('.ajax_size').html(data);
				}
			})
		})
	</script>

	@if (session('cart_success'))
        <script>
            Swal.fire({
			position: 'top-end',
            icon: 'success',
            title: "{{session('cart_success')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

	@if (session('wish_success'))
        <script>
            Swal.fire({
			position: 'top-end',
            icon: 'success',
            title: "{{session('wish_success')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

	<script>
		$('.star').click(function(){
			var star = $(this).val();
			$('#selected_star').html(star);
		})
	</script>

	@if (session('just_stock_out'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'info',
            title: 'Stock Out',
            text:  "{{session('just_stock_out')}}",
            confirmButtonText:'Refresh',
            confirmButtonColor:'#000000cc',
            background: '#0000009d',
            color: '#ffffff'
            })
        </script>
    @endif

	
@endsection 