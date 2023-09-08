@extends('layouts.dashboard')

<style>
    .view_update_status .form-control{
        height: 35px !important;
    }
</style>

@section('content')

 @php
    $view_order_details = App\Models\Order::where('id', $view_order_sl_no)->get()->first();
    $view_order_id = $view_order_details->order_id;
    $view_order_date = $view_order_details->created_at;
    $view_order_status = $view_order_details->order_status;
    $view_customer_id = $view_order_details->customer_id;
    $view_sub_total = $view_order_details->sub_total;
    $view_sales_discount = $view_order_details->sales_discount;
    $view_coupon_discount = $view_order_details->coupon_discount;
    $view_delivery_charge = $view_order_details->delivery_charge;
    $view_total = $view_order_details->total;
    $view_customer_details = App\Models\CustomerLogin::where('id', $view_customer_id)->get()->first();
    $view_billing_details = App\Models\BillingDetails::where('order_id', $view_order_id)->get()->first();
@endphp

<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('order_list')}}">Order List</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Order Details <span style="color: #656773; font-size: 16px">(Order Id: {{$view_order_id}})</span></a></li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card" style="border: 1px solid blue">
            <div class="row">
                <div class="card-body d-flex justify-content-start">
                    <div class="col-lg-4">
                        <h4 class="bg-primary text-white pt-2 pb-2 pl-3" style="border-radius: 12px 12px 0 0">Order by</h4>
                        <div class="d-flex justify-content-start customer_profile_main mt-3">
                            <div class="mr-3">
                                @if ($view_customer_details->profile_image == null)
                                    <img src="{{ Avatar::create($view_customer_details->name)->toBase64() }}" alt="Profile Image"/>
                                    @else
                                    <img style="border-radius: 50%" class="img-fluid circle" width="170" src="{{asset('uploads/customer')}}/{{$view_customer_details->profile_image}}" alt="Profile Image">
                                @endif
                            </div>

                            <div>
                                <h4 class="fs-md mb-2">{{$view_customer_details->name}}</h4>
                                <h5 class="mb-2" style="font-size: 13px">{{$view_customer_details->email}}</h5>

                                @if ($view_customer_details->mobile != null)
                                    <h5 class="mb-1" style="font-size: 13px">Contact No: {{$view_customer_details->mobile}}</h5>
                                @endif

                                @if ($view_customer_details->address != null)
                                    <h5 style="font-size: 13px; line-height: 20px">Address: {{$view_customer_details->address}}.</h5>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <h4 class="bg-primary text-white pt-2 pb-2 pl-3" style="border-radius: 12px 12px 0 0">Billing Address</h4>
                        <div class="ml-3 mt-3">
                            <h4 class="fs-md mb-2">{{$view_billing_details->name}}</h4>
                            <h5 class="mb-2" style="font-size: 13px">{{$view_billing_details->email}}</h5>
                            <h5 class="mb-2" style="font-size: 13px">Contact No: {{$view_billing_details->mobile}}</h5>
                            <h5 class="mb-2" style="font-size: 13px; line-height: 20px">Address: {{$view_billing_details->address}},
                                <span> {{$view_billing_details->rel_to_city->name}},</span>
                                <span> {{$view_billing_details->rel_to_country->name}}.</span>
                            </h5>
                            @if ($view_billing_details->notes != null)
                                <h5 style="font-size: 13px; color: #757575">( {{$view_billing_details->notes}} )</h5>           
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <h4 class="bg-primary text-white pt-2 pb-2 pl-3" style="border-radius: 12px 12px 0 0">Order Status</h4>
                        <div class="ml-3 mr-2 mt-3">
                            <label class="form-label">Current Status:</label>
                            @if ($view_order_status == 1 )
                                <span class="badge text-white bg-primary w-100">{{'Placed'}}</span>
                                @elseif ($view_order_status == 2)
                                <span class="badge text-white bg-success w-100">{{'Confirmed'}}</span>
                                @elseif ($view_order_status == 3)
                                <span class="badge text-white bg-warning w-100">{{'Processing'}}</span>
                                @elseif ($view_order_status == 4)
                                <span class="badge text-white bg-secondary w-100">{{'On Delivery'}}</span>
                                @elseif ($view_order_status == 5)
                                <span class="badge text-white bg-info w-100">{{'Delivered'}}</span>
                                @else
                                <span class="badge text-white bg-danger w-100">{{'Canceled'}}</span>
                            @endif
                        </div>
                        @can('order_status_change')
                            <div class="ml-3 mt-2 mr-2 view_update_status">
                                <label class="form-label">Update Status:</label>
                                <form id="update_status" action="{{route('order_status_update')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{$view_order_id}}">
                                    <input type="hidden" name="order_status" value="0" class="order_status">
                                    <select id="" class="form-control update_status">
                                        <option value="0">-- Change Status --</option>
                                        <option value="1">Placed</option>
                                        <option value="2">Confirmed</option>
                                        <option value="3">Processing</option>
                                        <option value="4">On Delivery</option>
                                        <option value="5">Delivered</option>
                                        <option value="6">Canceled</option>
                                    </select>
                                </form>
                            </div>
                        @endcan
                    </div>
                </div>  
            </div>          
        </div>
    </div>

    <div class="col-lg-12">        
        <div class="card">
            <div class="card-header bg-primary">
                <h4 style="color: #fff">Order Details</h4>
                <span style="color: #fff; font-weight: 500; font-size: 1.125rem">Order Date: {{$view_order_date->format('d-M-Y')}}</span>
            </div>

            <div class="card-body">
                <table class="table table-striped" id="productTable">
                    <tr class="text-center">
                        <th>Sl</th>
                        <th>Preview</th>
                        <th>Product Name</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Unit Discount</th>
                        <th>Total</th>
                    </tr>

                    @foreach (App\Models\OrderProduct::where('order_id', $view_order_id)->get() as $sl=>$order)
                        <tr class="text-center">
                            <td>{{$sl+1}}</td>
                            <td>
                                <img width="80" src="{{asset('uploads/product/preview')}}/{{$order->rel_to_product->preview}}" alt="Product Image">
                            </td>
                            <td>{{$order->rel_to_product->product_name}}</td>
                            <td>{{$order->rel_to_color->color_name}}</td>
                            <td>{{$order->rel_to_size->size_name}}</td>
                            <td>{{$order->quantity}}</td>
                            <td>{{number_format($order->original_price)}}/-</td>
                            <td>{{number_format(($order->original_price)*($order->discount)/100)}}/-</td>
                            <td>{{number_format($order->after_discount)}}/-</td> 
                        </tr>
                     @endforeach
                </table>
                <div class="main d-flex justify-content-end">
                    <div class="col-lg-4 order_details_bottom d-flex justify-content-between">
                        <div class="order_details_bottom_text text-right">
                            <h6 style="color: #7e7e7e">Total Price =</h6>
                            <h6 style="color: #7e7e7e">(-)Coupon Discount =</h6>
                            <h6 style="border-bottom: 1px solid #b1aeae; color: #7e7e7e" class="pb-1">(+)Delivery Charge =</h6>
                            <h4 style="color: #7e7e7e">Grand Total =</h4>
                        </div>
                        <div class="order_details_bottom_amount text-right">
                            <h6 style="color: #7e7e7e">{{number_format(round($view_sub_total-$view_sales_discount))}}/-</h6>
                            <h6 style="color: #7e7e7e">{{number_format(round($view_coupon_discount))}}/-</h6>
                            <h6 style="border-bottom: 1px solid #b1aeae; color: #7e7e7e" class="pb-1">{{number_format(round($view_delivery_charge))}}/-</h6>
                            <h4 style="color: #7e7e7e">{{number_format(round($view_total))}}/-</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('footer_script')

    <script>
        $('.update_status').change(function(){
            var this_val = $(this).val();
            if(this_val != 0){
                $('.order_status').val(this_val);
                $('#update_status').submit();
            }
        });
    </script>

    @if (session('order_status_update'))
        <script>
            Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: "{{session('order_status_update')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

@endsection