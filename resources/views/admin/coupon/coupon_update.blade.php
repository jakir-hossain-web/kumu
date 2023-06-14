@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('coupon')}}">Coupon</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Coupon update</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-8 m-auto">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 style="color: #fff">Coupon Update</h4>
            </div>

            <div class="card-body">
                <form action="{{route('coupon.update')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Coupon Name:</label>
                            <input type="hidden" name="coupon_id" value="{{$coupons->id}}">
                            <input type="text" name="coupon_name" class="form-control" value="{{$coupons->coupon_name}}">
                            @error('coupon_name')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror

                            @if (session('coupon_update_duplicate'))
                                <strong class="text-danger" >{{session('coupon_update_duplicate')}}</strong>
                            @endif
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Coupon Type:</label>
                            <select name="coupon_type" class="form-control">
                                @if ($coupons->coupon_type == 1)
                                    <option value="1" selected>Persentage</option>
                                    <option value="2">Solid Amount</option>
                                    @else
                                    <option value="1">Persentage</option>
                                    <option value="2" selected>Solid Amount</option>
                                @endif

                            </select>
                            @error('coupon_type')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Coupon Amount:</label>
                            <input type="number" name="coupon_amount" class="form-control" value="{{$coupons->coupon_amount}}">
                            @error('coupon_amount')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Minimum Purchase:</label>
                            <input type="number" name="min_purchase" class="form-control" value="{{$coupons->min_purchase ==null?'0':$coupons->min_purchase}}">
                            @error('min_purchase')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Minimum Amount:</label>
                            <input type="number" name="min_amount" class="form-control" value="{{$coupons->min_amount ==null?'0':$coupons->min_amount}}">
                            @error('min_amount')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Maxmimum Amount:</label>
                            <input type="number" name="max_amount" class="form-control" value="{{$coupons->max_amount ==null?'0':$coupons->max_amount}}">
                            @error('max_amount')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label class="form-label">Coupon Validity:</label>
                            <input type="date" name="validity" class="form-control" value="{{$coupons->validity}}">
                            @error('validity')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-12 mb-3">
                            <button type="submit" class="btn btn-primary" style="width: 100%">Update Coupon</button>
                        </div>   
                    </div>       
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer_script')

    @if (session('coupon_update'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('coupon_update')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

@endsection