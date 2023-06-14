@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('subcatagory')}}">Subcatagory</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Subcatagory Edit</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-8 m-auto">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 style="color: #fff">Edit Subcatagory</h4>
            </div>
            <div class="card-body">
                <form action="{{route('subcatagory.update')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <select name="catagory_id" class="form-control">
                            <option value="">--Select Catagory--</option>
                            @foreach ($catagories as $catagory)  
                                <option {{($catagory->id == $subcatagory_info->catagory_id)?'selected':''}} value="{{$catagory->id}}">{{$catagory->catagory_name}}</option>
                            @endforeach
                        </select>
                        @error('catagory_id')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="hidden" name="subcatagory_id" value="{{$subcatagory_info->id}}">
                        <input type="text" class="form-control" value="{{$subcatagory_info->subcatagory_name}}" name="subcatagory_name">
                        @error('subcatagory_name')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror

                        @if (session('subcatagory_duplicate'))
                            <strong class="text-danger" >{{session('subcatagory_duplicate')}}</strong>
                        @endif
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
    @if (session('subcatagory_update_seccess'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('subcatagory_update_seccess')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif
@endsection
