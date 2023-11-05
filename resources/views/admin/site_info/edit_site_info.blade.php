@extends('layouts.dashboard')

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)"> Edit Site Info</a></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 style="color: #fff">Current Site Info</h4>
                </div>
                <div class="card-body">
                    <div class="site_info_title">
                        <div class="site_info_main mb-3 pb-2" style="border-bottom: 1px solid #a7a7a7;">
                            <h5 style="font-size: 16px; font-weight:700">Site Name: <Span style="font-size: 16px; font-weight:500">Pikter IT</Span></h5>
                        </div>
                        <div class="site_info_main mb-3 pb-2" style="border-bottom: 1px solid #a7a7a7;">
                            <h5 style="font-size: 16px; font-weight:700">Site Address: <Span style="font-size: 16px; font-weight:500">Multiplan Center, Level-3, Shop-351 (Sales Center) & Lavel- 9, Shop-958 (Service Center), New Elephant Rd, Dhaka 1205.</Span></h5>
                        </div>
                        <div class="site_info_main mb-3 pb-2" style="border-bottom: 1px solid #a7a7a7;">
                            <h5 style="font-size: 16px; font-weight:700">Email Address: <Span style="font-size: 16px; font-weight:500">pikterit@gmail.com</Span></h5>
                        </div>
                        <div class="site_info_main mb-3 pb-2" style="border-bottom: 1px solid #a7a7a7;">
                            <h5 style="font-size: 16px; font-weight:700">Contact Number: <Span style="font-size: 16px; font-weight:500">+8801623486100</Span></h5>
                        </div>
                        <div class="site_info_main">
                            <h5 style="font-size: 16px; font-weight:700">Site Logo: <Span style="font-size: 16px; font-weight:500">LOGO</Span></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 style="color: #fff">Change Site Info</h4>
                </div>
                <div class="card-body">
                    <form action="#" method="POST">
                    {{-- <form action="{{route('change_site_info')}}" method="POST"> --}}
                        @csrf
                        <input class="form-control mb-3" type="text" name="site_name" placeholder="Site Name">
                        <input class="form-control mb-3" type="text" name="site_address" placeholder="Site Address">
                        <input class="form-control mb-3" type="email" name="site_email" placeholder="Site Email">
                        <input class="form-control mb-3" type="text" name="contact_number" placeholder="Contact Number">
                        <input class="form-control mb-3" type="file" name="Site_logo">
                        <button type="submit" class="btn btn-primary" style="width: 100%">Change Site Info</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footer_script')


@endsection