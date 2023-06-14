@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Create Role</a></li>
    </ol>
</div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header text-center bg-primary">
                        <h4 style="color: #fff">Role List</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                             <tr class="text-center">
                                <th>Role</th>
                                <th>Permission</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($roles as $role)
                                <tr class="text-center">
                                    <td>{{$role->name}}</td>
                                    <td>
                                        @foreach ($role->getAllPermissions() as $permission)
                                            <span class="badge badge-primary my-1">{{$permission->name}}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{route('role_edit', $role->id)}}">Edit</a>
                                                <button type="button" class="dropdown-item role_delete" value="{{route('role_delete', $role->id)}}">Delete</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                {{-- ========== add role ========== --}}
                <div class="card">
                    <div class="card-header text-center bg-primary">
                        <h4 style="color: #fff">Create New Role</h4>
                        <span class="text-white">
                            <input style="cursor: pointer" type="checkbox" id="check_permission_all">
                            <label style="cursor: pointer" for="check_permission_all" class="form-check-label">Select All</label>
                        </span>
                    </div>
                    <div class="card-body">
                        <form action="{{route('role.store')}}" method="POST">
                            @csrf

                            @if (session('role_permission_empty'))
								<div class="alert alert-danger">{{session('role_permission_empty')}}</div>
							@endif
                            @if (session('role_name_empty'))
								<div class="alert alert-danger">{{session('role_name_empty')}}</div>
							@endif
                            @if (session('role_name_duplicate'))
								<div class="alert alert-danger">{{session('role_name_duplicate')}}</div>
							@endif

                            <div class="mb-3">
                                @foreach ($permissions as $permission)
                                    <div class="form-check">   
                                                                           
                                        <input style="cursor: pointer" class="form-check-input check_permission_ind" type="checkbox" value="{{$permission->id}}" id="check{{$permission->id}}" name="permission_id[]">

                                        <label style="cursor: pointer" class="form-check-label" for="check{{$permission->id}}">
                                            {{$permission->name}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Role Name:</label>
                                <input type="text" class="form-control" name="role_name">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary" name="add_role_btn">Create Role</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ========== add permission (only for Delevoper) ========== --}}
            {{-- <div class="col-lg-4">
                <div class="card">
                    <div class="card-header text-center bg-primary">
                        <h4 style="color: #fff">Add New Permission</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('permission.store')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Permission Name:</label>
                                <input type="text" class="form-control" name="permission_name">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary" name="add_permission_btn">Add Permission</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection

@section('footer_script')

    <script>
        $("#check_permission_all").on('click', function(){
            this.checked ? $(".check_permission_ind").prop("checked",true) : $(".check_permission_ind").prop("checked",false);  
        })
    </script>

    <script>
        $('.role_delete').click(function(){
            Swal.fire({
            title: 'Are you sure?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete Role!'
            }).then((result) => {
            if (result.isConfirmed) {
                var link = $(this).val();
                window.location.href = link;
            }
            })
        });
    </script>

    @if (session('role_store_success'))
        <script>
            Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: "{{session('role_store_success')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

    @if (session('role_delete_success'))
        <script>
            Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: "{{session('role_delete_success')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

@endsection