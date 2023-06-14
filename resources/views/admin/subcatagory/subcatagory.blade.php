@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Subcatagory</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-8">

        {{-- count total start --}}
        @php
            $total_count = App\Models\Subcatagory::count();
            $total_trashed_count = App\Models\Subcatagory::onlyTrashed()->count();
        @endphp
        {{-- count total end --}}

        {{-- ========== subcatagory list ========== --}}
        <div class="card">
            <div class="card-header bg-primary">
                <h4 style="color: #fff">Subcatagory List</h4>
                <span style="text-align: right; color: #fff">Total: {{count($subcatagories)}} </span>
            </div>

            @if ($total_count != 0)
                <div class="card-body">
                    <form action="{{route('subcatagory.delete_all')}}" method="POST" id="check_subcatagory_form">
                        @csrf
                        <table class="table table-striped" id="myTable">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="check_subcatagory_all" class="mr-2">Select All</th>
                                    <th>SL</th>
                                    <th>Catagory name</th>
                                    <th>Subcatagory Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subcatagories as $key=>$subcatagory)                      
                                <tr>
                                    <td><input class="check_subcatagory_ind" type="checkbox" name="subcatagory_id[]" value="{{$subcatagory->id}}"></td>
                                    <td>{{$key+1}}</td>
                                    <td>{{$subcatagory->rel_to_cat->catagory_name}}</td>
                                    <td>{{$subcatagory->subcatagory_name}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                            </button>
                                            <div class="dropdown-menu">
                                                @can('subcatagory_edit')
                                                    <a class="dropdown-item" href="{{route('subcatagory.edit', $subcatagory->id)}}">Edit</a>
                                                @endcan
                                                @can('subcatagory_delete')
                                                    <a class="dropdown-item" href="{{route('subcatagory.delete', $subcatagory->id)}}">Delete</a>
                                                @endcan
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            @can('subcatagory_delete')
                                <button type="button" class="btn btn-danger mb-3 check_subcatagory_btn d-none">Delete</button>
                            @endcan
                        </div>
                    </form>
                </div>
                @else
                <h3 class="alert alert-primary text-center">Subcatagory list is empty</h3>
            @endif
        </div>

        {{-- ========== trashed subcatagory list ========== --}}
        <div class="card">
            <div class="card-header bg-primary">
                <h4 style="color: #fff">Trashed Subcatagory List</h4>
                <span style="text-align: right; color: #fff">Total: {{count($trashed)}} </span>
            </div>

            @if ($total_trashed_count != 0)
                <div class="card-body">
                    <form action="{{route('subcatagory.restore_delete_all_trashed')}}" method="POST" id="check_subcatagory_trashed_form">
                        @csrf
                        <table class="table table-striped" id="trashedTable">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="check_subcatagory_trashed_all" class="mr-2">Select All</th>
                                    <th>SL</th>
                                    <th>Catagory name</th>
                                    <th>Subcatagory Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trashed as $key=>$subcatagory)                      
                                <tr>
                                    <td><input class="check_subcatagory_trashed_ind" type="checkbox" name="subcatagory_id[]" value="{{$subcatagory->id}}"></td>
                                    <td>{{$key+1}}</td>
                                    <td>{{$subcatagory->rel_to_cat->catagory_name}}</td>
                                    <td>{{$subcatagory->subcatagory_name}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                            </button>
                                            <div class="dropdown-menu">
                                                @can('subcatagory_restore')
                                                    <a class="dropdown-item" href="{{route('subcatagory.restore', $subcatagory->id)}}">Restore</a>
                                                @endcan
                                                @can('subcatagory_force_delete')
                                                    <button type="button" class="dropdown-item force_del_cata" value="{{route('subcatagory.force_delete', $subcatagory->id)}}">Force Delete</button>
                                                @endcan
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        <input class="check_subcatagory_trashed_val" type="hidden" name="check_subcatagory_trashed_val" value="0">

                        <div class="d-flex justify-content-center">
                            @can('subcatagory_restore')
                                <button type="button" class="btn btn-danger mr-3 check_subcatagory_trashed_btn d-none" name="check_subcatagory_trashed_btn" value="1">Restore</button>
                            @endcan
                            @can('subcatagory_force_delete')
                                <button type="button" class="btn btn-danger ml-3 check_subcatagory_trashed_btn d-none" name="check_subcatagory_trashed_btn" value="2">Permanent Delete</button>
                            @endcan
                        </div>
                    </form>
                </div>
                @else
                <h3 class="alert alert-primary text-center">Subcatagory trashed list is empty</h3>
            @endif
        </div>
    </div>

    @can('subcatagory_add')
        {{-- ========= add subcatagory ========== --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 style="color: #fff">Add Subcatagory</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('subcatagory.store')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <select name="catagory_id" class="form-control">
                                <option value="">--Select Catagory--</option>
                                @foreach ($catagories as $catagory)
                                    <option value="{{$catagory->id}}">{{$catagory->catagory_name}}</option>
                                @endforeach
                            </select>
                            @error('catagory_id')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="text" name="subcatagory_name" class="form-control" placeholder="Subcatagory Name">
                            @error('subcatagory_name')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror

                            @if (session('subcatagory_duplicate'))
                                <strong class="text-danger" >{{session('subcatagory_duplicate')}}</strong>
                            @endif
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Add Subcatagory</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
</div>

@endsection

@section('footer_script')

    @if (session('subcatagory_add_seccess'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('subcatagory_add_seccess')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

    @if (session('subcatagory_move_to_trash'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('subcatagory_move_to_trash')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

    @if (session('subcatagory_restore_seccess'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('subcatagory_restore_seccess')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

    <script>
        $('.force_del_cata').click(function(){
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

    @if (session('subcatagory_force_deleted_seccess'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('subcatagory_force_deleted_seccess')}}",
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
        $(document).ready( function () {
            $('#trashedTable').DataTable();
        } );
    </script>


    {{-- subcatagory page all delete --}}
    <script>
        $("#check_subcatagory_all").on('click', function(){
            this.checked ? $(".check_subcatagory_ind").prop("checked",true) : $(".check_subcatagory_ind").prop("checked",false);  
            var checked_pro = $("input:checkbox:checked").length

            if(checked_pro != 0){
                $('.check_subcatagory_btn').removeClass('d-none');
            }
            else{
                $('.check_subcatagory_btn').addClass('d-none');
            }
        })
    </script>

    <script>
        $('.check_subcatagory_ind').click(function(){
            var checked_pro = $("input:checkbox:checked").length

            if(checked_pro != 0){
                $('.check_subcatagory_btn').removeClass('d-none');
            }
            else{
                 $('.check_subcatagory_btn').addClass('d-none');
            }
        });
    </script>

    <script>
        $('.check_subcatagory_btn').click(function(){
            Swal.fire({
            title: 'Are you sure?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete Subcatagory!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#check_subcatagory_form').submit();
                }
            })
        });
    </script>


    {{-- trashed subcatagory page all delete --}}
    <script>
        $("#check_subcatagory_trashed_all").on('click', function(){
            this.checked ? $(".check_subcatagory_trashed_ind").prop("checked",true) : $(".check_subcatagory_trashed_ind").prop("checked",false);  
            var checked_pro = $("input:checkbox:checked").length

            if(checked_pro != 0){
                $('.check_subcatagory_trashed_btn').removeClass('d-none');
            }
            else{
                $('.check_subcatagory_trashed_btn').addClass('d-none');
            }
        })
    </script>

    <script>
        $('.check_subcatagory_trashed_ind').click(function(){
            var checked_pro = $("input:checkbox:checked").length

            if(checked_pro != 0){
                $('.check_subcatagory_trashed_btn').removeClass('d-none');
            }
            else{
                 $('.check_subcatagory_trashed_btn').addClass('d-none');
            }
        });
    </script>

    <script>
        $('.check_subcatagory_trashed_btn').click(function(){
            if($(this).val() == 1){
                $('.check_subcatagory_trashed_val').val($(this).val()) ;
                Swal.fire({
                title: 'Are you sure?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Restore Again!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#check_subcatagory_trashed_form').submit();
                    }
                })
            }
            else{
                $('.check_subcatagory_trashed_val').val($(this).val()) ;
                Swal.fire({
                title: 'Are you sure?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete Permanently!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#check_subcatagory_trashed_form').submit();
                    }
                })
            }
        });
    </script>

@endsection