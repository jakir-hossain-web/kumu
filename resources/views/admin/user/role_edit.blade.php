@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('role.create')}}">Create Role</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Role Edit</a></li>
    </ol>
</div>
    <div class="container">
        <div class="row">
            {{-- ========== edit role ========== --}}
            <div class="col-lg-12 m-auto">
                <div class="card">
                    <div class="card-header text-center bg-primary">
                        <h4 style="color: #fff">Role Edit- ({{$role->name}})</h4>
                        <span class="text-white">
                            <input style="cursor: pointer" type="checkbox" id="check_permission_all">
                            <label style="cursor: pointer" for="check_permission_all" class="form-check-label">Select All</label>
                        </span>
                    </div>
                    <div class="card-body">
                        <form action="{{route('role_update')}}" method="POST">
                            @csrf

                            @if (session('role_permission_empty'))
								<div class="alert alert-danger">{{session('role_permission_empty')}}</div>
							@endif

                            <div class="role_edit_all d-flex">                             
                                <div class="mb-3 col-lg-3">
                                    @foreach ($permissions_row_one as $permissions_row_one)
                                        <div class="form-check">
                                            <input style="cursor: pointer" class="form-check-input check_permission_ind" type="checkbox" {{($role->hasPermissionTo($permissions_row_one->name))?'checked':''}} value="{{$permissions_row_one->id}}" id="check{{$permissions_row_one->id}}" name="permission_id[]">
                                            <label style="cursor: pointer" class="form-check-label" for="check{{$permissions_row_one->id}}">
                                                {{$permissions_row_one->name}}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mb-3 col-lg-3">
                                    @foreach ($permissions_row_two as $permissions_row_two)
                                        <div class="form-check">
                                            <input style="cursor: pointer" class="form-check-input check_permission_ind" type="checkbox" {{($role->hasPermissionTo($permissions_row_two->name))?'checked':''}} value="{{$permissions_row_two->id}}" id="check{{$permissions_row_two->id}}" name="permission_id[]">
                                            <label style="cursor: pointer" class="form-check-label" for="check{{$permissions_row_two->id}}">
                                                {{$permissions_row_two->name}}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mb-3 col-lg-3">
                                    @foreach ($permissions_row_three as $permissions_row_three)
                                        <div class="form-check">
                                            <input style="cursor: pointer" class="form-check-input check_permission_ind" type="checkbox" {{($role->hasPermissionTo($permissions_row_three->name))?'checked':''}} value="{{$permissions_row_three->id}}" id="check{{$permissions_row_three->id}}" name="permission_id[]">
                                            <label style="cursor: pointer" class="form-check-label" for="check{{$permissions_row_three->id}}">
                                                {{$permissions_row_three->name}}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mb-3 col-lg-3">
                                    @foreach ($permissions_row_four as $permissions_row_four)
                                        <div class="form-check">
                                            <input style="cursor: pointer" class="form-check-input check_permission_ind" type="checkbox" {{($role->hasPermissionTo($permissions_row_four->name))?'checked':''}} value="{{$permissions_row_four->id}}" id="check{{$permissions_row_four->id}}" name="permission_id[]">
                                            <label style="cursor: pointer" class="form-check-label" for="check{{$permissions_row_four->id}}">
                                                {{$permissions_row_four->name}}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            @if (session('role_name_duplicate'))
								<div class="alert alert-danger">{{session('role_name_duplicate')}}</div>
							@endif
                            
                            <div class="mb-3">
                                <input type="hidden" class="form-control" name="role_id" value="{{$role->id}}">
                                <label class="form-label">Role Name:</label>
                                <input type="text" class="form-control" name="role_name" value="{{$role->name}}">
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary" name="add_role_btn">Update Role</button>
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
        $("#check_permission_all").on('click', function(){
            this.checked ? $(".check_permission_ind").prop("checked",true) : $(".check_permission_ind").prop("checked",false);  
        })
    </script>

    @if (session('role_update_success'))
        <script>
            Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: "{{session('role_update_success')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

@endsection