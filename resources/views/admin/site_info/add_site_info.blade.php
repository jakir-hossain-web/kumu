@extends('layouts.dashboard')

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Add Site Info</a></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-8 m-auto">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 style="color: #fff">Add Site Info</h4>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        @csrf
                        <input class="form-control mb-3" type="text" name="site_name" placeholder="Site Name">
                        <input class="form-control mb-3" type="text" name="site_address" placeholder="Site Address">
                        <input class="form-control mb-3" type="email" name="site_email" placeholder="Site Email">
                        <input class="form-control mb-3" type="text" name="contact_number" placeholder="Contact Number">
                        <input class="form-control mb-3" type="file" name="Site_logo">
                        <button type="submit" class="btn btn-primary" style="width: 100%">Add Site Info</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footer_script')


@endsection