@extends('layouts.dashboard')


@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Trashed Product</a></li>
    </ol>
</div>


<div class="row">

    {{-- count trashed start --}}
    @php
        $total_trashed_count = App\Models\Product::onlyTrashed()->count();
    @endphp
    {{-- count trashed end --}}

    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 style="color: #fff">Trashed Product List</h4>
                <span style="text-align: right; color: #fff">Total: {{count($trashed)}} </span>
            </div>
            @if ($total_trashed_count != 0)
                <div class="card-body">
                    <form action="{{route('product.check_restore_delete')}}" method="POST" id="check_btn">
                        @csrf
                        <table class="table table-striped" id="productTrashed">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkall_pro" class="mr-2">Select All</th>
                                    <th>SL</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Discount</th>
                                    <th>After Discount</th>
                                    <th>Brand</th>
                                    <th>Preview</th>
                                    <th>Thumbnail</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trashed as $sl=>$product)
                                    <tr>
                                        <td><input class="check_pro" type="checkbox" name="product_id[]" value="{{$product->id}}"></td>
                                        <td>{{$sl+1}}</td>
                                        <td>{{$product->product_name}}</td>
                                        <td>{{'Tk.'.' '.$product->price.'/-'}}</td>
                                        <td>{{$product->discount.'%'}}</td>
                                        <td>{{'Tk.'.' '.$product->after_discount.'/-'}}</td>
                                        <td>{{$product->brand}}</td>
                                        <td>
                                            <img width="100" src="{{asset('uploads/product/preview')}}/{{$product->preview}}" alt="">
                                        </td>
                                        <td>
                                            @foreach (App\Models\Thumbnail::where('product_id',$product->id)->get() as $thumbnail)
                                                <img width="50" src="{{asset('uploads/product/thumbnails')}}/{{$thumbnail->thumbnail}}" alt="">
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                                    <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                                </button>
                                                <div class="dropdown-menu">
                                                    @can('product_restore')
                                                        <a class="dropdown-item" href="{{route('product.restore', $product->id)}}">Restore</a>
                                                    @endcan

                                                    @can('product_force_delete')
                                                        <button type="button" class="dropdown-item force_del_all" value="{{route('product.force_delete', $product->id)}}">Permanent Delete</button>
                                                    @endcan

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <input class="check_btn_val" type="hidden" name="check_btn_val" value="0">
                        <div class="d-flex justify-content-center">
                            @can('product_restore')
                                <button type="button" class="btn btn-danger check_btn mr-3 d-none" name="check_btn" value="1">Restore</button>
                            @endcan
                            @can('product_force_delete')
                                <button type="button" class="btn btn-danger check_btn ml-3 d-none" name="check_btn" value="2">Permanent Delete</button>
                            @endcan
                        </div>
                    </form>
                </div>
                @else
                <h3 class="alert alert-primary text-center">Product trashed list is empty</h3>
            @endif
        </div>
    </div>
</div>

@endsection

@section('footer_script')

    <script>
        $(document).ready( function () {
            $('#productTrashed').DataTable();
        } );
    </script>

    <script>
        $('.force_del_all').click(function(){
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

    @if (session('product_delete_success'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('product_delete_success')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

    @if (session('product_restore_seccess'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('product_restore_seccess')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

    <script>
        $("#checkall_pro").on('click', function(){
            this.checked ? $(".check_pro").prop("checked",true) : $(".check_pro").prop("checked",false);  
            var checked_pro = $("input:checkbox:checked").length

            if(checked_pro != 0){
                $('.check_btn').removeClass('d-none');
            }
            else{
                $('.check_btn').addClass('d-none');
            }
        })
    </script>

    <script>
        $('.check_pro').click(function(){
            var checked_pro = $("input:checkbox:checked").length

            if(checked_pro != 0){
                $('.check_btn').removeClass('d-none');
            }
            else{
                 $('.check_btn').addClass('d-none');
            }
        });
    </script>

    <script>
        $('.check_btn').click(function(){
            if($(this).val() == 1){
                $('.check_btn_val').val($(this).val()) ;
                Swal.fire({
                title: 'Are you sure?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Restore it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#check_btn').submit();
                    }
                })
            }
            else{
                $('.check_btn_val').val($(this).val()) ;
                Swal.fire({
                title: 'Are you sure?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete Permanently!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#check_btn').submit();
                    }
                })
            }
        });
    </script>

@endsection