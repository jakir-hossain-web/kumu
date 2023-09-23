@extends('layouts.dashboard')

<style>
    .search_form_select{
        color: #474747 !important;
        border: 1px solid #0B2A97 !important;
        margin-right: 10px !important;
        width: 60%;
    }
    .search_btn{
        width: 20%;
        margin-right: 10px !important;
    }
    .refresh_btn{
        width: 20%;
    }
</style>


@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Order List</a></li>
    </ol>
</div>

<div class="search_by_status mb-3">
    <form id="search_btn" action="{{route('search_order_list')}}" method="POST">
        @csrf
        <div class="search_form d-flex">
            <input type="hidden" name="search_order_status" value="0" class="search_order_status">
            <select name="status" class="search_form_select form-control" value="{{old('status')}}">
                <option value="0">---Select Order Status ---</option>
                <option value="1" {{$order_status==1?'selected':''}}>Placed</option>
                <option value="2" {{$order_status==2?'selected':''}}>Confirmed</option>
                <option value="3" {{$order_status==3?'selected':''}}>Processing</option>
                <option value="4" {{$order_status==4?'selected':''}}>On Delivery</option>
                <option value="5" {{$order_status==5?'selected':''}}>Delivered</option>
                <option value="6" {{$order_status==6?'selected':''}}>Canceled</option>
                <option value="7" {{$order_status==7?'selected':''}}>All Orders</option>
            </select>
            <Button type="submit" class="btn btn-primary search_btn">Search</Button>
            <Button type="submit" class="btn btn-success refresh_btn">Refresh</Button>
        </div>
    </form>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 style="color: #fff">Order List</h4>
                </h4>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="orderTable">
                    <thead>
                        <tr class="text-center">
                            <th>Sl</th>
                            <th>Order ID</th>
                            <th>Payment Method</th>
                            <th>Amount</th>
                            <th>Order Date</th>
                            <th>Order Status</th>
                            <th>Order Details</th>
                            <th>Invoice</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    @php
                        if($order_status == 0){
                            $orders = App\Models\Order::orderBy('created_at','desc')->get();
                        }
                        else if($order_status == 7){
                            $orders = App\Models\Order::orderBy('created_at','desc')->get();
                        }
                        else(
                            $orders = App\Models\Order::where('order_status', $order_status)->orderBy('created_at','desc')->get()
                        )
                    @endphp

                    <tbody>
                        @foreach ($orders as $sl=>$order)   
                            <tr class="text-center">
                                <td>{{$sl+1}}</td>
                                <td>{{$order->order_id}}</td>
                                <td>
                                    @if ($order->payment_method == 1)   
                                        {{'Cash'}}
                                        @elseif ($order->payment_method == 2)
                                        {{'SSL'}}
                                        @else
                                        {{'Stripe'}}
                                    @endif
                                </td>  
                                <td>{{number_format(round($order->total))}}/-</td>  
                                <td>{{$order->created_at->format('d-M-Y')}}</td>  
                                <td>
                                    @if ($order->order_status == 1 )
                                        <span class="badge text-white bg-primary ">{{'Placed'}}</span>
                                        @elseif ($order->order_status == 2)
                                        <span class="badge text-white bg-success">{{'Confirmed'}}</span>
                                        @elseif ($order->order_status == 3)
                                        <span class="badge text-white bg-warning">{{'Processing'}}</span>
                                        @elseif ($order->order_status == 4)
                                        <span class="badge text-white bg-secondary">{{'On Delivery'}}</span>
                                        @elseif ($order->order_status == 5)
                                        <span class="badge text-white bg-info">{{'Delivered'}}</span>
                                        @else
                                        <span class="badge text-white bg-danger">{{'Canceled'}}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('order.details', $order->id)}}" class="badge text-white bg-secondary">View</a>
                                </td>
                                <td>
                                    <a href="{{route('Download_invoice', substr($order->order_id,1))}}" class="badge text-white bg-success">Download</a>
                                </td>
                                @can('order_status_change')
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                            </button>
                                            <div class="dropdown-menu">
                                                <form action="{{route('order_status_update')}}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="order_id" value="{{$order->order_id}}">
                                                    <button type="submit" class="dropdown-item" name="order_status" value="1">Placed</button>
                                                    <button type="submit" class="dropdown-item" name="order_status" value="2">Confirmed</button>
                                                    <button type="submit" class="dropdown-item" name="order_status" value="3">Processing</button>
                                                    <button type="submit" class="dropdown-item" name="order_status" value="4">On Delivery</button>
                                                    <button type="submit" class="dropdown-item" name="order_status" value="5">Delivered</button>
                                                    <button type="submit" class="dropdown-item" name="order_status" value="6">Canceled</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>                           
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection


@section('footer_script')

    <script>
        $('.refresh_btn').click(function() {
            var this_val = 0;
            $('.search_order_status').val(this_val);
            $('#search_btn').submit();
        });
    </script>

    <script>
        $('.search_btn').click(function(event){
            var this_val = $('.search_form_select').val();
            
            if(this_val == 0){
                event.preventDefault(); // Prevent the default form submission
                Swal.fire({
                position: 'center',
                icon: 'warning',
                text: "Select Order Status First!",
                showConfirmButton: false,
                background: '#01186d',
                color: '#d1d1d1',
                iconColor: '#d1d1d1'
                })
            }
            else{
                $('.search_order_status').val(this_val);
                $('#search_btn').submit();
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

    <script>
        $(document).ready( function () {
            $('#orderTable').DataTable();
        } );
    </script>

@endsection