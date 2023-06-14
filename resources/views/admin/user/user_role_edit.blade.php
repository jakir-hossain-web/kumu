@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('role.assign')}}">Assign Role</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Change User Role</a></li>
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
                    <div class="card-body">
                        <form action="{{route('user_role_change')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">User Name:</label>
                                <input type="text" value="{{$user->name}}" class="form-control" readOnly>
                                <input type="hidden" value="{{$user->id}}" name="user_id">
                            </div>
                            <div class="mb-3">
                                <select name="role_id" id="" class="form-control">
                                    @foreach ($roles as $role)
                                        <option value="{{$role->id}}" {{($user->hasRole($role->name))?'selected':''}}>{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Change User Role</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_script')

    @if (session('user_role_change_success'))
        <script>
            Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: "{{session('user_role_change_success')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif 

@endsection