@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Delivery Charge</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 style="color: #fff">Delivery Charge List</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>Sl</th>
                        <th>Delivery Type</th>
                        <th>Delivery Charge</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($charges as $sl=>$charge)
                        <tr>
                            <td>{{$sl+1}}</td>
                            <td>{{$charge->delivery_type}}</td>
                            <td>{{$charge->delivery_charge}}</td>
                            <td>
                            <div class="dropdown">
                                <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                    <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                </button>
                                <div class="dropdown-menu">
                                    @can('delivery_charge_edit')
                                        <a class="dropdown-item" href="{{route('charge.edit', $charge->id)}}">Edit</a>
                                    @endcan
                                    @can('delivery_charge_delete')
                                        <a class="dropdown-item" href="{{route('charge.delete', $charge->id)}}">Delete</a>
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

    @can('delivery_charge_add')
        {{-- ========= add delivery charge ========= --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 style="color: #fff">Add Delivery Charge</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('charge.store')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Delivery Type:</label>
                            <input type="text" class="form-control" name="delivery_type">
                            @error('delivery_type')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Delivery Charge:</label>
                            <input type="number" class="form-control" name="delivery_charge">
                            @error('delivery_charge')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Add Delivery Charge</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
</div>

{{-- ============ Trashed delivery charge table =========== --}}
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 style="color: #fff">Delivery Charge Trashed List</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>Sl</th>
                        <th>Delivery Type</th>
                        <th>Delivery Charge</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($trashed_charges as $sl=>$charge)
                        <tr>
                            <td>{{$sl+1}}</td>
                            <td>{{$charge->delivery_type}}</td>
                            <td>{{$charge->delivery_charge}}</td>
                            <td>
                            <div class="dropdown">
                                <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                    <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                </button>
                                <div class="dropdown-menu">
                                    @can('delivery_charge_restore')
                                        <a class="dropdown-item" href="{{route('charge.restore', $charge->id)}}">Restore</a>
                                    @endcan
                                    @can('delivery_charge_force_delete')
                                        <button class="dropdown-item force_del_charge" value="{{route('charge.force_delete', $charge->id)}}">Permanent Delete</button>
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
</div>


@endsection

@section('footer_script')

    <script>
        $('.force_del_charge').click(function(){
            Swal.fire({
            title: 'Are you sure?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete Permanently!'
            }).then((result) => {
            if (result.isConfirmed) {
                var link = $(this).val();
                window.location.href = link;
            }
            })
        });
    </script>

    @if (session('charge_add'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('charge_add')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

    @if (session('charge_delete'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('charge_delete')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

    @if (session('charge_restore'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('charge_restore')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

    @if (session('charge_force_delete'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('charge_force_delete')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

@endsection