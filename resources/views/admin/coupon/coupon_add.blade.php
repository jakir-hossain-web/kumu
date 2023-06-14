@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Coupon Add</a></li>
    </ol>
</div>

<div class="row">
    {{-- =============== Add Coupon ================ --}}
    <div class="col-lg-8 m-auto">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 style="color: #fff">Add Coupon</h4>
            </div>
        
            <div class="card-body">
                <form action="{{route('coupon.store')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Coupon Name:</label>
                            <input type="text" name="coupon_name" class="form-control">
                            @error('coupon_name')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Coupon Type:</label>
                            <select name="coupon_type" class="form-control">
                                <option value="">--Select Coupon Type--</option>
                                <option value="1">Persentage</option>
                                <option value="2">Solid Amount</option>
                            </select>
                            @error('coupon_type')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Coupon Amount:</label>
                            <input type="number" name="coupon_amount" class="form-control">
                            @error('coupon_amount')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Minimum Purchase:</label>
                            <input type="number" name="min_purchase" class="form-control">
                            @error('min_purchase')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Minimum Amount:</label>
                            <input type="number" name="min_amount" class="form-control">
                            @error('min_amount')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Maxmimum Amount:</label>
                            <input type="number" name="max_amount" class="form-control">
                            @error('max_amount')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label class="form-label">Coupon Validity:</label>
                            <input type="date" name="validity" class="form-control">
                            @error('validity')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-12 mb-3">
                            @can('coupon_add')
                                <button type="submit" class="btn btn-primary" style="width: 100%">Add Coupon</button>
                            @endcan
                        </div>   
                    </div>       
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer_script')

    @if (session('coupon_add'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('coupon_add')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

@endsection