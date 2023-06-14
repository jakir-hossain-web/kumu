@extends('layouts.dashboard')


@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('permission.assign')}}">Assign Special Permission</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">User Permission Remove</a></li>
    </ol>
</div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 m-auto">
                {{-- ========== user role edit ========== --}}
                <div class="card">
                    <div class="card-header bg-primary">
                        <div>
                            <h4 style="color: #fff">{{$user->name}}</h4>
                            <h6 style="color: #c1c1c1">{{$user->getRoleNames()->first()}}</h6>
                        </div>
                        @if ($user->image == null)
                            <img style="width: 70px; border-radius: 50%; border: 3px solid #fff" src="{{ Avatar::create($user->name)->toBase64() }}" />
                            @else
                            <img style="width: 70px; border-radius: 50%; border: 3px solid #fff" src="{{asset('uploads/user')}}/{{$user->image}}" alt="Profile Image">
                        @endif
                    </div> 

                    @if (session('permission_not_selected'))
                        <div class="alert alert-danger mt-2">{{session('permission_not_selected')}}</div>
                    @endif

                    {{-- ====== select all ====== --}}
                    <div class="select_all ml-4 mt-3 mb-0" style="font-weight: 500">
                        <input class="text-right" style="cursor: pointer;" type="checkbox" id="check_permission_all">
                        <label style="cursor: pointer; font-size: 17px; font-weight: 600; color: #0B2A97 " for="check_permission_all" class="form-check-label">Select All</label>
                    </div>

                    <div class="card-body p-0 ml-4 mt-2">
                        <form action="{{route('role.user_permission_remove')}}" method="POST">
                            @csrf

                            <input type="hidden" value="{{$user->id}}" name="user_id">
                            <div class="mb-3"> 
                                @php
                                    $user_permissions = $user->getPermissionNames();
                                @endphp   
                                
                                @forelse ($user_permissions as $permission)
                                    <div class="form-check">
                                        <input style="cursor: pointer" class="form-check-input check_permission_ind" type="checkbox" value="{{$permission}}" id="{{$permission}}" name="permission_id[]">
                                        <label style="cursor: pointer" class="form-check-label" for="{{$permission}}">
                                            {{$permission}}
                                        </label>
                                    </div>  
                                    @empty
                                   <div class="alert alert-success text-center">No Special Permission Assigned!</div>
                                @endforelse
                            </div>
                            
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Remove Permission</button>
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

    @if (session('user_permission_remove_success'))
        <script>
            Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: "{{session('user_permission_remove_success')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif 

@endsection