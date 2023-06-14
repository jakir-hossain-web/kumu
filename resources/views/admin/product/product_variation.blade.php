@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Product Variation</a></li>
    </ol>
</div>

<div class="row">
    {{-- ======== Preview variation ========== --}}
    <div class="col-lg-8">
        {{-- ======== color Preview ========== --}}
        <div class="card">
            <div class="card-header bg-primary">
                <h4 style="color: #fff">Product Color</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>SL</th>
                        <th>Color Name</th>
                        <th>Color</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($colors as $sl=>$color)
                        <tr>
                            <td>{{$sl+1}}</td>
                            <td>{{$color->color_name}}</td>
                            <td>
                                <span class="badge" style="background: {{$color->color_code}}; width: 70px; height: 70px; border-radius: 50%; color: transparent; border: 1px solid #d5d5d5">color</span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu">
                                        @can('variation_edit')
                                            <a class="dropdown-item" href="">Edit</a>
                                        @endcan
                                        @can('variation_delete')
                                            <a class="dropdown-item" href="">Delete</a>
                                        @endcan
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        {{-- ======== Size Preview ========== --}}
        <div class="card">
            <div class="card-header bg-primary">
                <h4 style="color: #fff">Product Size</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>SL</th>
                        <th>Size Name</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($sizes as $sl=>$size)
                        <tr>
                            <td>{{$sl+1}}</td>
                            <td>{{$size->size_name}}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu">
                                        @can('variation_edit')
                                            <a class="dropdown-item" href="">Edit</a>
                                        @endcan
                                        @can('variation_delete')
                                            <a class="dropdown-item" href="">Delete</a>
                                        @endcan
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    @can('variation_add')
    {{-- ======== Add variation ========== --}}
    <div class="col-lg-4">
        {{-- ======== Add color ========== --}}
        <div class="card">
            <div class="card-header bg-primary">
                <h4 style="color: #fff">Add Color</h4>
            </div>
            <div class="card-body">
                <form action="{{route('color.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="text" class="form-control" name="color_name" placeholder="Color Name">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="color_code" placeholder="Color Code">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Color</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ======== Add size ========== --}}
        <div class="card">
            <div class="card-header bg-primary">
                <h4 style="color: #fff">Add Size</h4>
            </div>
            <div class="card-body">
                <form action="{{route('size.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="text" class="form-control" name="size_name" placeholder="Size Name">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Size</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan
</div>


@endsection