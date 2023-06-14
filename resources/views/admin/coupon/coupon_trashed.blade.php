@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Coupon Trashed List</a></li>
    </ol>
</div>

<div class="row">
    {{-- ======================== View Trashed Coupon ======================= --}}

    {{-- count trashed start --}}
    @php
        $total_trashed_count = App\Models\Coupon::onlyTrashed()->count();
    @endphp
    {{-- count trashed end --}}
    
    <div class="col-lg-12">
        <div class="card-header bg-primary">
            <h4 style="color: #fff">Coupon Trashed List</h4>
        </div>
        @if ($total_trashed_count != 0)
            <div class="card-body">
                <form action="{{route('coupon.restore_delete_all_trashed')}}" method="POST"    id="check_coupon_trashed_form">
                    @csrf
                    <table class="table table-striped" id="couponTable">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="check_coupon_trashed_all" class="mr-2">Select All</th>
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
                                <td><input class="check_coupon_trashed_ind" type="checkbox" name="coupon_id[]" value="{{$coupon->id}}"></td>
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
                                            @can('coupon_restore')
                                                <a class="dropdown-item" href="{{route('coupon.restore', $coupon->id)}}">Restore</a>
                                            @endcan
                                            @can('coupon_force_delete')
                                                <button type="button" class="dropdown-item force_del_coupon" value="{{route('coupon.force_delete', $coupon->id)}}">Permanent Delete</button>
                                            @endcan
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
            
                    <input class="check_coupon_trashed_val" type="hidden" name="check_coupon_trashed_val" value="0">

                    <div class="d-flex justify-content-center">
                        @can('coupon_restore')
                            <button type="button" class="btn btn-danger mr-3 check_coupon_trashed_btn d-none" name="check_coupon_trashed_btn" value="1">Restore</button>
                        @endcan
                        @can('coupon_force_delete')
                            <button type="button" class="btn btn-danger ml-3 check_coupon_trashed_btn d-none" name="check_coupon_trashed_btn" value="2">Permanent Delete</button>
                        @endcan
                    </div>
                </form>
            </div>
            @else
            <h3 class="alert alert-primary text-center">Coupon trashed list is empty</h3>
        @endif
    </div>
</div>

@endsection

@section('footer_script')

    <script>
        $('.force_del_coupon').click(function(){
            Swal.fire({
            title: 'Are you sure?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete Permanently!'
            }).then((result) => {
            if (result.isConfirmed) {
                var link = $(this).val();
                window.location.href = link;
            }
            })
        });
    </script>

    @if (session('coupon_restore'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('coupon_restore')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

    @if (session('coupon_force_delete'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('coupon_force_delete')}}",
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

    {{-- trashed coupon page all delete --}}
    <script>
        $("#check_coupon_trashed_all").on('click', function(){
            this.checked ? $(".check_coupon_trashed_ind").prop("checked",true) : $(".check_coupon_trashed_ind").prop("checked",false);  
            var checked_pro = $("input:checkbox:checked").length

            if(checked_pro != 0){
                $('.check_coupon_trashed_btn').removeClass('d-none');
            }
            else{
                $('.check_coupon_trashed_btn').addClass('d-none');
            }
        })
    </script>

    <script>
        $('.check_coupon_trashed_ind').click(function(){
            var checked_pro = $("input:checkbox:checked").length

            if(checked_pro != 0){
                $('.check_coupon_trashed_btn').removeClass('d-none');
            }
            else{
                 $('.check_coupon_trashed_btn').addClass('d-none');
            }
        });
    </script>

    <script>
        $('.check_coupon_trashed_btn').click(function(){
            if($(this).val() == 1){
                $('.check_coupon_trashed_val').val($(this).val()) ;
                Swal.fire({
                title: 'Are you sure?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Restore Again!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#check_coupon_trashed_form').submit();
                    }
                })
            }
            else{
                $('.check_coupon_trashed_val').val($(this).val()) ;
                Swal.fire({
                title: 'Are you sure?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete Permanently!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#check_coupon_trashed_form').submit();
                    }
                })
            }
        });
    </script>

@endsection