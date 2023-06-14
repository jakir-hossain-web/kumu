@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Users</a></li>
    </ol>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12 m-auto">
            <div class="card">
                <div class="card-header text-center bg-primary">
                    <h4 style="color: #fff">User List</h4>
                    <span style="text-align: right; color: #fff">Total User: {{count($users)}} </span>
                </div>
                <div class="card-body">
                    <form action="{{route('user.delete_all')}}" method="POST" id="check_user_form">
                        @csrf
                        <table class="table table-striped" id="myTable">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="check_user_all" class="mr-2">Select All</th>
                                    <th>SL</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $key=>$user)
                                <tr>
                                    <td><input class="check_user_ind" type="checkbox" name="user_id[]" value="{{$user->id}}"></td>
                                    <td>{{$key+1}}</td>                          
                                    <td>
                                        @if ($user->image == null)
                                        <img width="50" src="{{ Avatar::create($user->name)->toBase64() }}" />
                                        @else
                                        <img style="border-radius: 50%" width="50" src="{{asset('uploads/user')}}/{{$user->image}}" alt="Profile Image">
                                        @endif
                                    </td>                          
                                    <td>{{$user->name}}</td>                          
                                    <td>{{$user->email}}</td>                          
                                    <td>{{$user->created_at->diffForHumans()}}</td>                          
                                    <td>
                                        <button  value="{{route('user.delete', $user->id)}}" class="btn btn-danger user_del">Delete</button>
                                    </td>                          
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-danger mb-3 check_user_btn d-none">Delete</button>
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
        $('.user_del').click(function(){
            Swal.fire({
            title: 'Are you sure?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                var link = $(this).val();
                window.location.href = link;
            }
            })
        });
    </script>

    @if (session('delete_success'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'User Deleted Successfully!',
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>

    <script>
        $("#check_user_all").on('click', function(){
            this.checked ? $(".check_user_ind").prop("checked",true) : $(".check_user_ind").prop("checked",false);  
            var checked_pro = $("input:checkbox:checked").length

            if(checked_pro != 0){
                $('.check_user_btn').removeClass('d-none');
            }
            else{
                $('.check_user_btn').addClass('d-none');
            }
        })
    </script>

    <script>
        $('.check_user_ind').click(function(){
            var checked_pro = $("input:checkbox:checked").length

            if(checked_pro != 0){
                $('.check_user_btn').removeClass('d-none');
            }
            else{
                 $('.check_user_btn').addClass('d-none');
            }
        });
    </script>

    <script>
        $('.check_user_btn').click(function(){
            Swal.fire({
            title: 'Are you sure?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete User!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#check_user_form').submit();
                }
            })
        });
    </script>

    @if (session('delete_all_success'))
        <script>
            Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: "{{session('delete_all_success')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

@endsection