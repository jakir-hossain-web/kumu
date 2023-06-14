@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('charge')}}">Delivery Charge</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Delivery Charge Update</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-8 m-auto">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 style="color: #fff">Update Delivery Charge</h4>
            </div>
            <div class="card-body">
                <form action="{{route('charge.update')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Delivery Type:</label>
                        <input type="hidden" name="charge_id" value="{{$charges->id}}">
                        <input type="text" class="form-control" name="delivery_type" value="{{$charges->delivery_type}}">
                        @error('delivery_type')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror

                        @if (session('charge_update_duplicate'))
                            <strong class="text-danger" >{{session('charge_update_duplicate')}}</strong>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Delivery Charge:</label>
                        <input type="number" class="form-control" name="delivery_charge" value="{{$charges->delivery_charge}}">
                        @error('delivery_charge')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update Delivery Charge</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('footer_script')

    @if (session('charge_update'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('charge_update')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

@endsection