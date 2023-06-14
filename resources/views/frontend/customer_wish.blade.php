@extends('frontend.master')

<style>
    .btn.btn_love {
        background: #fa6c89  !important;
        width: 35px !important;
        height: 35px !important;
        transition: .3s
    }
    .btn.btn_love:hover {
        background: #ee1c47  !important;
    }
    ul.dahs_navbar li a{
        transition: .3s;
    }
    ul.dahs_navbar li a:hover{
        color: #ee1c47;
    }

    .product_grid input[type="checkbox"] {
        width: 17px;
        height: 17px;
        position: absolute;
        bottom: 10px;
        right: 10px;
        cursor: pointer;
    }
    .wish_all_main {
        position: relative;
    }
    .wish_all_part {
        position: absolute;
        top: -40px;
        left: 0;
    }
    .wish_all_part input[type="checkbox"] {
        width: 17px;
        height:17px;
        cursor: pointer;
    }
    .check_wish_all_btn{
        position: absolute;
        top: -45px;
        right: 0;
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
                        <li class="breadcrumb-item active">Wishlist</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->

<!-- ======================= Dashboard Detail ======================== -->
<section class="middle">
    <div class="container">
        <div class="row justify-content-center justify-content-between wish_all_main">
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
                            <li><a href="{{route('customer.customer_wish')}}" class="active"><i class="lni lni-heart mr-2"></i>Wishlist</a></li>
                            <li><a href="{{route('customer.profile')}}"><i class="lni lni-user mr-2"></i>Profile Info</a></li>
                            <li><a href="{{route('customer.logout')}}"><i class="lni lni-power-switch mr-2"></i>Log Out</a></li>
                        </ul>
                    </div>
                    
                </div>
            </div>
            
            <div class="col-12 col-md-12 col-lg-8 col-xl-8 text-center">

                <form action="{{route('wish.remove_all_checked')}}" method="POST" id="check_wish_btn_page">
					@csrf
                    <!-- row -->
                    <div class="wish_all_main">
                        {{-- === Select all checkbox start ==== --}}
                            @php
                                $all_wishes = App\Models\Wish::where('customer_id', Auth::guard('customerlogin')->id())->count()
                            @endphp
                            @if ($all_wishes != 0)
                                <div class="d-flex justify-content-start mt-2 wish_all_part" style="font-weight: 500">
                                    <input type="checkbox" id="wish_all_part" class="ml-2 mr-2">Select All
                                </div>
                            @endif
                        {{-- === Select all checkbox end ==== --}}

                        {{-- ===== check all button start ===== --}}
                        <div class="form-group check_wish_all_btn d-none">
                            <button type="button" class="btn d-block full-width btn-dark-light check_wish_btn_all">Remove Selected</button>
                        </div>
                        {{-- ===== check all button end ===== --}}
                    </div>
                    
                    <div class="row align-items-center">
                    
                        <!-- Single -->
                        @forelse ($wishes as $wish)
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                <div class="product_grid card b-0">
                                    {{-- === Select individual checkbox start ==== --}}
                                    <div>
                                        <input class="check_wish_ind" type="checkbox" name="wish_id[]" value="{{$wish->id}}">
                                    </div>
                                    {{-- === Select individual checkbox end ==== --}}

                                    @if ($wish->rel_to_product->discount)
                                        <div class="badge bg-info text-white position-absolute ab-left text-upper" style="font-size: 13px">-{{$wish->rel_to_product->discount}}%</div>
                                        @else
                                        <div class="badge bg-success text-white position-absolute ab-left text-upper" style="font-size: 13px">NEW</div>
                                    @endif
                                    <a href="{{route('wish.remove', $wish->id)}}" class="btn btn_love position-absolute ab-right theme-cl"><i class="fas fa-times text-white"></i></a>
                                                                
                                    <div class="card-body p-0">
                                        <div class="shop_thumb position-relative">
                                            <a class="card-img-top d-block overflow-hidden" href="{{route('product.details', $wish->rel_to_product->slug)}}"><img class="card-img-top" src="{{asset('uploads/product/preview')}}/{{$wish->rel_to_product->preview}}" alt="preview"></a>
                                        </div>
                                    </div>
                                    <div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
                                        <div class="text-left">
                                            <div class="text-center">
                                                <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a href="{{route('product.details', $wish->rel_to_product->slug)}}">{{$wish->rel_to_product->product_name}}</a></h5>
                                                <div class="elis_rty">
                                                    @if ($wish->rel_to_product->discount)
                                                        <span class="ft-medium text-muted line-through fs-md mr-2">&#2547; {{number_format(round($wish->rel_to_product->price))}}/-</span>
                                                    @endif
                                                    <span class="ft-bold fs-md text-dark">&#2547; {{number_format(round($wish->rel_to_product->after_discount))}}/-</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <h1 class="alert alert-danger w-100">No Product Add to Wish List Yet!</h1>
                        @endforelse

                        
                        
                    </div>
                    <!-- row -->
                </form>
            </div>
            
        </div>
    </div>
</section>
<!-- ======================= Dashboard Detail End ======================== -->


@endsection


@section('footer_script')

    {{-- ===== check all with enable or disable delete all button ===== --}}
		<script>
			$("#wish_all_part").on('click', function(){
				this.checked ? $(".check_wish_ind").prop("checked",true) : $(".check_wish_ind").prop("checked",false);  
				var checked_pro = $("input:checkbox:checked").length

				if(checked_pro != 0){
					$('.check_wish_all_btn').removeClass('d-none');
				}
				else{
					$('.check_wish_all_btn').addClass('d-none');
				}
			})
		</script>
		
		{{-- ===== check individual with enable or disable delete all button ===== --}}
		<script>
			$('.check_wish_ind').click(function(){
				var checked_pro = $("input:checkbox:checked").length

				if(checked_pro != 0){
					$('.check_wish_all_btn').removeClass('d-none');
				}
				else{
					$('.check_wish_all_btn').addClass('d-none');
				}
			});
		</script>

        {{-- ===== Remove all checked wishes ===== --}}
		<script>
			$('.check_wish_btn_all').click(function(){
				Swal.fire({
				title: 'Are you sure?',
				icon: 'question',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, Remove Wishes!'
				}).then((result) => {
					if (result.isConfirmed) {
						$('#check_wish_btn_page').submit();
					}
				})
			});
		</script>

		{{-- ===== All checked wishes removed success message ===== --}}
		@if (session('checked_wish_all_delete'))
			<script>
				Swal.fire({
				position: 'top-end',
				icon: 'success',
				title: "{{session('checked_wish_all_delete')}}",
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
	
@endsection 