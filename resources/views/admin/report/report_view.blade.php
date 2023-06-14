@extends('layouts.dashboard')

@section('content')

<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Report</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 style="color: #fff">Order Report</h4>
            </div>
            <div class="card-body">
                <form action="{{route('report.download')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <select id="" class="form-control" name="order_status">
                            <option value="">-- Select Order Status --</option>
                            <option value="1">Order Confirmed</option>
                            <option value="2">All Order</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <select id="" class="form-control" name="download_mode">
                            <option value="">-- Select Download Mode --</option>
                            <option value="1">PDF</option>
                            <option value="2">Excel</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="" class="form-label">From</label>
                                <input type="date" class="form-control" name="download_form">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="" class="form-label">To</label>
                                <input type="date" class="form-control"  name="download_to">
                            </div>
                        </div>
                    </div>  
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary w-100">Download Report</button>
                    </div>                 
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@section('footer_script')

    {{-- @if (session('order_status_update'))
        <script>
            Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: "{{session('order_status_update')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif --}}

@endsection