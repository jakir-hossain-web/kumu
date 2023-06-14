@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Coupon list</a></li>
    </ol>
</div>

<div class="row">
    {{-- =============== View Coupon ================ --}}

    {{-- count total start --}}
    @php
        $total_count = App\Models\Coupon::count();
    @endphp
    {{-- count total end --}}

    <div class="col-lg-12">
        <div class="card-header bg-primary">
            <h4 style="color: #fff">Coupon List</h4>
        </div>
        @if ($total_count != 0)
            <div class="card-body">
                <form action="{{route('coupon.delete_all')}}" method="POST" id="check_coupon_form">
                    @csrf
                    <table class="table table-striped" id="couponTable">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="check_coupon_all" class="mr-2">Select All</th>
                                <th>SL</th>
                                <th>Coupon Name</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Min Purchase</th>
                                <th>Min Amount</th>
                                <th>Max Amount</th>
                                <th>Validity</th>
                                <th>Added By</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($coupons as $sl=>$coupon)  
                            <tr>
                                <td><input class="check_coupon_ind" type="checkbox" name="coupon_id[]" value="{{$coupon->id}}"></td>
                                <td>{{$sl+1}}</td>
                                <td>{{$coupon->coupon_name}}</td>
                                <td><span class="badge badge-{{$coupon->coupon_type ==1?'info':'success'}}">{{$coupon->coupon_type ==1?'Persentage':'Solid Amount'}}</span></td>
                                <td>{{$coupon->coupon_type ==1?$coupon->coupon_amount.'%':'Tk.'.' '.$coupon->coupon_amount.'/-'}}</td>
                                <td>{{$coupon->min_purchase ==null?'0':'Tk.'.' '.$coupon->min_purchase.'/-'}}</td>
                                <td>{{$coupon->min_amount ==null?'0':'Tk.'.' '.$coupon->min_amount.'/-'}}</td>
                                <td>{{$coupon->max_amount ==null?'0':'Tk.'.' '.$coupon->max_amount.'/-'}}</td>
                                <td>{{$coupon->validity}}<br>({{Carbon\Carbon::now()->diffInDays($coupon->validity, false)}} days remaining)</td>
                                <td>{{$coupon->rel_to_user->name}}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                            <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                        </button>
                                        <div class="dropdown-menu">
                                            @can('coupon_edit')
                                                <a class="dropdown-item" href="{{route('coupon.edit', $coupon->id)}}">Edit</a>
                                            @endcan
                                            @can('coupon_delete')
                                                <a class="dropdown-item" href="{{route('coupon.delete', $coupon->id)}}">Delete</a>
                                            @endcan
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        @can('coupon_delete')
                            <button type="button" class="btn btn-danger mb-3 check_coupon_btn d-none">Delete</button>
                        @endcan
                    </div>
                </form>
            </div>
            @else
            <h3 class="alert alert-primary text-center">Coupon list is empty</h3>
        @endif
    </div>
</div>

@endsection

@section('footer_script')

    @if (session('coupon_delete'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('coupon_delete')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

    <script>
        $(document).ready( function () {
            $('#couponTable').DataTable();
        } );
    </script>

    {{-- coupon page all delete --}}
    <script>
        $("#check_coupon_all").on('click', function(){
            this.checked ? $(".check_coupon_ind").prop("checked",true) : $(".check_coupon_ind").prop("checked",false);  
            var checked_pro = $("input:checkbox:checked").length

            if(checked_pro != 0){
                $('.check_coupon_btn').removeClass('d-none');
            }
            else{
                $('.check_coupon_btn').addClass('d-none');
            }
        })
    </script>

    <script>
        $('.check_coupon_ind').click(function(){
            var checked_pro = $("input:checkbox:checked").length

            if(checked_pro != 0){
                $('.check_coupon_btn').removeClass('d-none');
            }
            else{
                 $('.check_coupon_btn').addClass('d-none');
            }
        });
    </script>

    <script>
        $('.check_coupon_btn').click(function(){
            Swal.fire({
            title: 'Are you sure?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete Coupon!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#check_coupon_form').submit();
                }
            })
        });
    </script>

@endsection