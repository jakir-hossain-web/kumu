@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('catagory')}}">Catagory</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Catagory Edit</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-8 m-auto">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 style="color: #fff">Edit Catagory</h4>
            </div>
            <div class="card-body">
                <form action="{{route('catagory.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @if (session('catagory_update_duplicate'))
                        <strong class="text-danger" >{{session('catagory_update_duplicate')}}</strong>
                    @endif

                    <div class="mb-3 mt-2">
                        <input type="hidden" name="catagory_id" value="{{$catagory->id}}">
                        <input type="text" class="form-control" name="catagory_name" value="{{$catagory->catagory_name}}">
                        @error('catagory_name')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="file" class="form-control" name="catagory_image" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        @error('catagory_image')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <img width="100" id="blah" src="{{asset('uploads/catagory')}}/{{$catagory->catagory_image}}" alt="catagory_image">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_script')
    @if (session('catagory_update_seccess'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('catagory_update_seccess')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif
@endsection