@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Assign Role</a></li>
    </ol>
</div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header text-center bg-primary">
                        <h4 style="color: #fff">User Role list</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                             <tr class="text-center">
                                <th>User Name</th>
                                <th>User Role</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($users as $user)
                                <tr class="text-center">
                                    <td>{{$user->name}}</td>
                                    <td>
                                        @foreach ($user->getRoleNames() as $role)
                                            <span class="badge badge-primary my-1">{{$role}}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{route('user_role_edit', $user->id)}}">Edit Role</a>
                                                <button type="button" class="dropdown-item role_delete" value="{{route('user_role_delete', $user->id)}}">Remove Role</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            {{-- ========== assign role ========== --}}
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header text-center bg-primary">
                        <h4 style="color: #fff">Assign Role</h4>                   
                    </div>
                    <div class="card-body">
                        <form action="{{route('user_role_assign')}}" method="POST">
                            @csrf

                            @if (session('role_assign_empty'))
                                <div class="alert alert-danger mb-3">{{session('role_assign_empty')}}</div>
                            @endif

                            @if (session('already_role_assign'))
                                <div class="alert alert-danger mb-3">{{session('already_role_assign')}}</div>
                            @endif

                            <div class="mb-3">
                                <select name="user_id" id="" class="form-control">
                                    <option value="">--Select User--</option>
                                    @foreach ($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <select name="role_id" id="" class="form-control">
                                    <option value="">--Select Role--</option>
                                    @foreach ($roles as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Assign Role</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_script')

    <script>
        $('.role_delete').click(function(){
            Swal.fire({
            title: 'Are you sure?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Remove Role!'
            }).then((result) => {
            if (result.isConfirmed) {
                var link = $(this).val();
                window.location.href = link;
            }
            })
        });
    </script>

    @if (session('role_assign_success'))
        <script>
            Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: "{{session('role_assign_success')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

    @if (session('user_role_remove_success'))
        <script>
            Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: "{{session('user_role_remove_success')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

@endsection