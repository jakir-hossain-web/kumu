@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Assign Special Permission</a></li>
    </ol>
</div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header text-center bg-primary">
                        <h4 style="color: #fff">User Specials Permission list</h4>
                        <h4 style="color: #fff"></h4>
                    </div>
                    
                    <div class="card-body">
                        <table class="table table-bordered">
                             <tr class="text-center">
                                <th>User Name</th>
                                <th>User Role</th>
                                <th>Special Permission</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($users as $user)
                                @php
                                    $permissionNames = $user->getPermissionNames();
                                @endphp
                        
                                <tr class="text-center">
                                    <td>{{$user->name}}</td>
                                    <td>
                                        @foreach ($user->getRoleNames() as $role)
                                            <span class="badge badge-info my-1">{{$role}}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($permissionNames as $permission)
                                            <span class="badge badge-primary my-1">
                                            {{$permission}}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{route('user_permission_remove', $user->id)}}">Remove Permission</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            {{-- ========== assign special permission ========== --}}
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header text-center bg-primary">
                        <h4 style="color: #fff">Assign Special Permission</h4>                   
                    </div>
                    <div class="card-body">
                        <form action="{{route('user_permission_assign')}}" method="POST">
                            @csrf

                            @if (session('permission_assign_empty'))
                                <div class="alert alert-danger mb-3">{{session('permission_assign_empty')}}</div>
                            @endif

                            <div class="mb-3">
                                <select name="user_id" id="user_id" class="form-control">
                                    <option value="">--Select User--</option>
                                    @foreach ($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
   
                            <div class="mb-3">
                                <div class="form-check" id="permission_id">
                                    @foreach ($permissions as $permission)
                                        <div class="form-check">
                                            <input style="cursor: pointer" class="form-check-input" type="checkbox" value="{{$permission->id}}" id="check{{$permission->id}}" name="permission_id[]">
                                            <label style="cursor: pointer" class="form-check-label" for="check{{$permission->id}}">
                                                {{$permission->name}}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Assign Permission</button>
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
    $('#user_id').change(function(){
        var user_id = $(this).val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:'/getPermission',
            type:'POST',
            data:{'user_id': user_id},
            success:function(response){
                $('#permission_id').html(response.html);
            }
        })
    })
</script>

    @if (session('permission_assign_success'))
        <script>
            Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: "{{session('permission_assign_success')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif


@endsection