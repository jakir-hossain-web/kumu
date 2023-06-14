@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Profile</a></li>
    </ol>
</div>
    <div class="container">
        <div class="row">
            {{-- ============ profile info update ========== --}}
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h4 class="text-white">Update Profile Info</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('profile.update')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Name:</label>
                                <input type="text" class="form-control" name="name" value="{{Auth::user()->name}}">
                                @error('name')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Email:</label>
                                <input type="email" class="form-control" name="email" value="{{Auth::user()->email}}">
                                @error('email')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Update Info</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ============ profile password change ========== --}}
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h4 class="text-white">Change Password</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('password.update')}}" method="POST">
                            @csrf
                            <div class="mb-3" style="position: relative">
                                <label class="form-label">Old Password:</label>
                                <input type="password" class="form-control" id="old_pass_type" name="old_password" autocomplete="new-password">
                                <i class="fa fa-eye" id="old_pass_show" style="position: absolute; top: 33px; right: 0; height: 40px; width: 40px; line-height: 40px; text-align: center; background: #0B2A97; color: #fff;  border-radius: 0 22px 22px 0;"></i>
                                @error('old_password')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                                @if (session('wrong_password'))
                                    <strong class="text-danger">{{session('wrong_password')}}</strong>
                                @endif
                            </div>
                            <div class="mb-3" style="position: relative">
                                <label class="form-label">New Password:</label>
                                <input type="password" class="form-control" id="new_pass_type" name="password">
                                <i class="fa fa-eye" id="new_pass_show" style="position: absolute; top: 33px; right: 0; height: 40px; width: 40px; line-height: 40px; text-align: center; background: #0B2A97; color: #fff;  border-radius: 0 22px 22px 0;"></i>
                                @error('password')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3" style="position: relative">
                                <label class="form-label">Confirm Password:</label>
                                <input type="password" class="form-control" id="con_pass_type" name="password_confirmation">
                                <i class="fa fa-eye" id="con_pass_show" style="position: absolute; top: 33px; right: 0; height: 40px; width: 40px; line-height: 40px; text-align: center; background: #0B2A97; color: #fff;  border-radius: 0 22px 22px 0;"></i>
                                @error('password_confirmation')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                                @if (session('password_not_match'))
                                    <strong class="text-danger">{{session('password_not_match')}}</strong>
                                @endif
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Change Password</button>
                            </div>
                        </form>
                        <div class="pass_format">
                            <p style="font-size: 11px; text-align: justify;"><span style="font-size: 12px; font-width: 700; color:#0B2A97">Password Formate:</span> Password must contain minimum 08 Character and minimum 01 Uppercase, 01 Lowercase, 01 Number & 01 Special Character must be used.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ============ profile photo update ========== --}}
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h4 class="text-white">Update Profile Image</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{route('image.update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Profile Image:</label>
                                <input type="file" class="form-control" name="image">
                                @error('image')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Update Image</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_script')
@if (session('profile_update_seccess'))
    <script>
        Swal.fire({
        position: 'center',
        icon: 'success',
        title: "{{session('profile_update_seccess')}}",
        showConfirmButton: false,
        timer: 2000
        })
    </script>
@endif
@if (session('password_update_success'))
    <script>
        Swal.fire({
        position: 'center',
        icon: 'success',
        title: "{{session('password_update_success')}}",
        showConfirmButton: false,
        timer: 2000
        })
    </script>
@endif
@if (session('image_update_success'))
    <script>
        Swal.fire({
        position: 'center',
        icon: 'success',
        title: "{{session('image_update_success')}}",
        showConfirmButton: false,
        timer: 2000
        })
    </script>
@endif
<script>
    $('#old_pass_show').click(function(){
        var old_pass_type = document.getElementById('old_pass_type');

        if (old_pass_type.type == 'password') {
            old_pass_type.type = 'text';
        }
        else{
            old_pass_type.type = 'password';
        }
    })
    $('#new_pass_show').click(function(){
        var new_pass_type = document.getElementById('new_pass_type');

        if (new_pass_type.type == 'password') {
            new_pass_type.type = 'text';
        }
        else{
            new_pass_type.type = 'password';
        }
    })
    $('#con_pass_show').click(function(){
        var con_pass_type = document.getElementById('con_pass_type');

        if (con_pass_type.type == 'password') {
            con_pass_type.type = 'text';
        }
        else{
            con_pass_type.type = 'password';
        }
    })
</script>
@endsection