@extends('layouts.dashboard')


@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Site Info</a></li>
        </ol>
    </div>
    

    @php
        $site_info = App\Models\SiteInfo::count();
    @endphp

    @if ($site_info == 0)
        {{-- ========== add site info ============ --}}
        <div class="row">
            <div class="col-lg-8 m-auto">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h4 style="color: #fff">Add Site Info</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('add_site_info')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            {{-- site name --}}
                            <div class="add_site_info_input mb-3">
                                <input class="form-control" type="text" name="site_name" value="{{old('site_name')}}" placeholder="Site Name" >
                                @error('site_name')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>

                            {{-- site slogan --}}
                            <div class="add_site_info_input mb-3">
                                <input class="form-control" type="text" name="site_slogan" value="{{old('site_slogan')}}" placeholder="Site Slogan">
                            </div>

                            {{-- site address --}}
                            <div class="add_site_info_input mb-3">
                                <input class="form-control" type="text" name="site_address" value="{{old('site_address')}}" placeholder="Site Address">
                                @error('site_address')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>

                            {{-- site email --}}
                            <div class="add_site_info_input mb-3">
                                <input class="form-control" type="email" name="site_email" value="{{old('site_email')}}" placeholder="Site Email">
                                @error('site_email')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>

                            {{-- contact number --}}
                            <div class="add_site_info_input mb-3">
                                <input class="form-control" type="text" name="contact_number" value="{{old('contact_number')}}" placeholder="Contact Number">
                                @error('contact_number')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>

                            {{-- site logo --}}
                            <div class="add_site_info_input mb-3">
                                <label class="form-label">Site Logo:</label>
                                <input class="form-control" type="file" name="site_logo">
                                @error('site_logo')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary" style="width: 100%">Add Site Info</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @else
        {{-- ========== update site info ============ --}}
        <div class="row">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h4 style="color: #fff">Current Site Info</h4>
                    </div>
                    <div class="card-body">
                        <div class="site_info_title">
                            <div class="site_info_main mb-3 pb-2" style="border-bottom: 1px solid #a7a7a7;">
                                <h5 style="font-size: 16px; font-weight:700">Site Name: <Span style="font-size: 16px; font-weight:500">{{$site_details->site_name}}</Span></h5>
                            </div>
                            <div class="site_info_main mb-3 pb-2" style="border-bottom: 1px solid #a7a7a7;">
                                <h5 style="font-size: 16px; font-weight:700;">Site Slogan: <Span style="font-size: 16px; font-weight:500;">{{$site_details->site_slogan==''?'---No site slogan added---':$site_details->site_slogan}}</Span></h5>
                            </div>
                            <div class="site_info_main mb-3 pb-2" style="border-bottom: 1px solid #a7a7a7;">
                                <h5 style="font-size: 16px; font-weight:700">Site Address: <Span style="font-size: 16px; font-weight:500">{{$site_details->site_address}}</Span></h5>
                            </div>
                            <div class="site_info_main mb-3 pb-2" style="border-bottom: 1px solid #a7a7a7;">
                                <h5 style="font-size: 16px; font-weight:700">Email Address: <Span style="font-size: 16px; font-weight:500">{{$site_details->site_email}}</Span></h5>
                            </div>
                            <div class="site_info_main mb-3 pb-2" style="border-bottom: 1px solid #a7a7a7;">
                                <h5 style="font-size: 16px; font-weight:700">Contact Number: <Span style="font-size: 16px; font-weight:500">{{$site_details->contact_number}}</Span>                               
                                </h5>
                            </div>
                            <div class="site_info_main text-center">
                                <h5 class="mb-3" style="font-size: 16px; font-weight:700">Site Logo: <Span style="font-size: 16px; font-weight:500">
                                </Span></h5>
                                <img src="{{asset('uploads/site_logo')}}/{{$site_details->site_logo}}" class="img-fluid" alt="Site Logo" style="width: 250px"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h4 style="color: #fff">Update Site Info</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('Update_site_info')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            {{-- site id --}}
                            <input type="hidden" name="site_id" value="{{$site_details->id}}">
                            
                            {{-- site name --}}
                            <div class="add_site_info_input mb-3">
                                <label class="form-label" style="font-weight: 500; color:#3d4465;">Site Name:</label>
                                <input class="form-control" type="text" name="site_name" value="{{$site_details->site_name}}">
                                @error('site_name')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>

                            {{-- site slogan --}}
                            <div class="add_site_info_input mb-3">
                                <label class="form-label" style="font-weight: 500; color:#3d4465;">Site Slogan:</label>
                                <input class="form-control" type="text" name="site_slogan" value="{{$site_details->site_slogan}}">
                            </div>

                            {{-- site address --}}
                            <div class="add_site_info_input mb-3">
                                <label class="form-label" style="font-weight: 500; color:#3d4465;">Site Address:</label>
                                <input class="form-control" type="text" name="site_address" value="{{$site_details->site_address}}">
                                @error('site_address')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>

                            {{-- site email --}}
                            <div class="add_site_info_input mb-3">
                                <label class="form-label" style="font-weight: 500; color:#3d4465;">Site Email:</label>
                                <input class="form-control" type="email" name="site_email" value="{{$site_details->site_email}}">
                                @error('site_email')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>

                            {{-- contact number --}}
                            <div class="add_site_info_input mb-3">
                                <label class="form-label" style="font-weight: 500; color:#3d4465;">Contact Number:</label>
                                <input class="form-control" type="text" name="contact_number" value="{{$site_details->contact_number}}">
                                @error('contact_number')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>

                            {{-- site logo --}}
                            <div class="add_site_info_input mb-3">
                                <label class="form-label" style="font-weight: 500; color:#3d4465;">Site Logo:</label>
                                <input class="form-control" type="file" name="site_logo" onchange="document.getElementById('blahs').src = window.URL.createObjectURL(this.files[0])">
                                @error('site_logo')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>

                            {{-- view site logo image --}}
                            <div class="mb-3">
                                <img id="blahs" src="{{asset('uploads/site_logo')}}/{{$site_details->site_logo}}" class="img-fluid" alt="Site Logo" style="width: 150px"/>
                            </div>

                            <button type="submit" class="btn btn-primary" style="width: 100%">Update Site Info</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection


@section('footer_script')

    {{-- on click image change script start --}}
    <script>
        const img = (src) => `<img src=${src}/>`;

        var loadFile = function (event) {
            var output = document.getElementById('output');
            output.innerHTML = '';

            [...event.target.files].forEach(
            (file) => (output.innerHTML += img(URL.createObjectURL(file)))
            );
        };
    </script>
    {{-- on click image change script end --}}


    @if (session('site_info_add_success'))
        <script>
            Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: "{{session('site_info_add_success')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

    @if (session('site_info_update_success'))
        <script>
            Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: "{{session('site_info_update_success')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif


@endsection