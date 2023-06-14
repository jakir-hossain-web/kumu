@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Catagory</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-8">

        {{-- count total start --}}
        @php
            $total_count = App\Models\Catagory::count();
            $total_trashed_count = App\Models\Catagory::onlyTrashed()->count();
        @endphp
        {{-- count total end --}}

        {{-- ========== catagory list ========== --}}
        <div class="card">
            <div class="card-header bg-primary">
                <h4 style="color: #fff">Catagory List</h4>
                <span style="text-align: right; color: #fff">Total: {{count($catagories)}}</span>
            </div>
            @if ($total_count != 0)
                <div class="card-body">
                    <form action="{{route('catagory.delete_all')}}" method="POST" id="check_catagory_form">
                        @csrf
                        <table class="table table-striped" id="myTable">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="check_catagory_all" class="mr-2">Select All</th>
                                    <th>SL</th>
                                    <th>Catagory</th>
                                    <th>Image</th>
                                    <th>Added By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($catagories as $key=>$catagory)                
                                <tr>
                                    <td><input class="check_catagory_ind" type="checkbox" name="catagory_id[]" value="{{$catagory->id}}"></td>
                                    <td>{{$key+1}}</td>
                                    <td>{{$catagory->catagory_name}}</td>
                                    <td><img src="{{asset('uploads/catagory')}}/{{$catagory->catagory_image}}" width="60px" alt="Catagory Image"></td>
                                    <td>{{$catagory->rel_to_user->name}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                            </button>
                                            <div class="dropdown-menu">
                                                @can('catagory_edit')
                                                    <a class="dropdown-item" href="{{route('catagory.edit', $catagory->id)}}">Edit</a>
                                                @endcan
                                                @can('catagory_delete')
                                                    <a class="dropdown-item" href="{{route('catagory.delete', $catagory->id)}}">Delete</a>
                                                @endcan
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            @can('catagory_delete')
                                <button type="button" class="btn btn-danger mb-3 check_catagory_btn d-none">Delete</button>
                            @endcan
                        </div>
                    </form>
                </div>
                @else
                <h3 class="alert alert-primary text-center">Catagory list is empty</h3>
            @endif
        </div>

        {{-- ========== Trashed catagory list ========== --}}
        <div class="card">
            <div class="card-header bg-primary">
                <h4 style="color: #fff"> Trashed Catagory List</h4>
                <span style="text-align: right; color: #fff">Total: {{count($trashed)}} </span>
            </div>
            @if ($total_trashed_count != 0)
                <div class="card-body">
                    <form action="{{route('catagory.restore_delete_all_trashed')}}" method="POST" id="check_catagory_trashed_form">
                        @csrf
                        <table class="table table-striped" id="trashedTable">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="check_catagory_trashed_all" class="mr-2">Select All</th>
                                    <th>SL</th>
                                    <th>Catagory</th>
                                    <th>Image</th>
                                    <th>Added By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trashed as $key=>$catagory)                
                                <tr>
                                    <td><input class="check_catagory_trashed_ind" type="checkbox" name="catagory_id[]" value="{{$catagory->id}}"></td>
                                    <td>{{$key+1}}</td>
                                    <td>{{$catagory->catagory_name}}</td>
                                    <td><img src="{{asset('uploads/catagory')}}/{{$catagory->catagory_image}}" width="60px" alt="Catagory Image"></td>
                                    <td>{{$catagory->rel_to_user->name}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                            </button>
                                            <div class="dropdown-menu">
                                                @can('catagory_restore')
                                                    <a class="dropdown-item" href="{{route('catagory.restore', $catagory->id)}}">Restore</a>
                                                @endcan
                                                @can('catagory_force_delete')
                                                    <button type="button" class="dropdown-item force_del_cata" value="{{route('catagory.force_delete', $catagory->id)}}">Force Delete</button>
                                                @endcan
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <input class="check_catagory_trashed_val" type="hidden" name="check_catagory_trashed_val" value="0">

                        <div class="d-flex justify-content-center">
                            @can('catagory_restore')
                                <button type="button" class="btn btn-danger mr-3 check_catagory_trashed_btn d-none" name="check_catagory_trashed_btn" value="1">Restore</button>
                            @endcan
                            @can('catagory_force_delete')
                                <button type="button" class="btn btn-danger ml-3 check_catagory_trashed_btn d-none" name="check_catagory_trashed_btn" value="2">Permanent Delete</button>
                            @endcan
                        </div>
                    </form>
                </div>
                @else
                <h3 class="alert alert-primary text-center">Catagory trashed list is empty</h3>
            @endif
        </div>
    </div>

    @can('catagory_add')				
    {{-- ========== add catagory ============ --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 style="color: #fff">Add Catagory</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('catagory.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Catagory Name:</label>
                            <input type="text" class="form-control" name="catagory_name">
                            @error('catagory_name')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Catagory Image:</label>
                            <input type="file" class="form-control" name="catagory_image">
                            @error('catagory_image')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Add Catagory</button>
                        </div>
                        <tbody></tbody>
                    </form>
                </div>
            </div>
        </div>
	@endcan  
</div>
@endsection


@section('footer_script')
    @if (session('catagory_add_seccess'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('catagory_add_seccess')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif
    @if (session('catagory_move_to_trash'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('catagory_move_to_trash')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif
    
    @if (session('catagory_restore_seccess'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('catagory_restore_seccess')}}",
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
    
    @if (session('catagory_force_deleted_seccess'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('catagory_force_deleted_seccess')}}",
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

    {{-- catagory page all delete --}}
    <script>
        $("#check_catagory_all").on('click', function(){
            this.checked ? $(".check_catagory_ind").prop("checked",true) : $(".check_catagory_ind").prop("checked",false);  
            var checked_pro = $("input:checkbox:checked").length

            if(checked_pro != 0){
                $('.check_catagory_btn').removeClass('d-none');
            }
            else{
                $('.check_catagory_btn').addClass('d-none');
            }
        })
    </script>

    <script>
        $('.check_catagory_ind').click(function(){
            var checked_pro = $("input:checkbox:checked").length

            if(checked_pro != 0){
                $('.check_catagory_btn').removeClass('d-none');
            }
            else{
                 $('.check_catagory_btn').addClass('d-none');
            }
        });
    </script>

    <script>
        $('.check_catagory_btn').click(function(){
            Swal.fire({
            title: 'Are you sure?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete Catagory!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#check_catagory_form').submit();
                }
            })
        });
    </script>


    {{-- trashed catagory page all delete --}}
    <script>
        $("#check_catagory_trashed_all").on('click', function(){
            this.checked ? $(".check_catagory_trashed_ind").prop("checked",true) : $(".check_catagory_trashed_ind").prop("checked",false);  
            var checked_pro = $("input:checkbox:checked").length

            if(checked_pro != 0){
                $('.check_catagory_trashed_btn').removeClass('d-none');
            }
            else{
                $('.check_catagory_trashed_btn').addClass('d-none');
            }
        })
    </script>

    <script>
        $('.check_catagory_trashed_ind').click(function(){
            var checked_pro = $("input:checkbox:checked").length

            if(checked_pro != 0){
                $('.check_catagory_trashed_btn').removeClass('d-none');
            }
            else{
                 $('.check_catagory_trashed_btn').addClass('d-none');
            }
        });
    </script>

    <script>
        $('.check_catagory_trashed_btn').click(function(){
            if($(this).val() == 1){
                $('.check_catagory_trashed_val').val($(this).val()) ;
                Swal.fire({
                title: 'Are you sure?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Restore Again!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#check_catagory_trashed_form').submit();
                    }
                })
            }
            else{
                $('.check_catagory_trashed_val').val($(this).val()) ;
                Swal.fire({
                title: 'Are you sure?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete Permanently!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#check_catagory_trashed_form').submit();
                    }
                })
            }
        });
    </script>

@endsection