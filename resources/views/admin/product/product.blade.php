@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Product</a></li>
    </ol>
</div>

<div class="row">

    {{-- count total start --}}
    @php
        $total_count = App\Models\Product::count();
    @endphp
    {{-- count total end --}}

    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 style="color: #fff">Product List</h4>
                <span style="text-align: right; color: #fff">Total: {{count($products)}} </span>
            </div>

            @if ($total_count != 0)
                <div class="card-body">
                    <form action="{{route('product.check_delete')}}" method="POST" id="check_btn">
                        @csrf
                        <table class="table table-striped" id="productTable">
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
                                @foreach ($products as $sl=>$product)
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
                                                    @can('product_edit')
                                                        <a class="dropdown-item" href="{{route('product.edit', $product->id)}}">Edit</a>
                                                    @endcan

                                                    <a class="dropdown-item" href="{{route('product.inventory', $product->id)}}">Inventory</a>

                                                    @can('product_delete')
                                                        <a class="dropdown-item" href="{{route('product.delete', $product->id)}}">Delete</a>
                                                    @endcan
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            @can('product_delete')
                                <button type="button" class="btn btn-danger mb-3 check_btn d-none">Delete</button>
                            @endcan
                        </div>
                    </form>
                </div>
                @else
                <h3 class="alert alert-primary text-center">Product list is empty</h3>
            @endif
        </div>
    </div>
</div>

@endsection

@section('footer_script')

<script>
    $(document).ready( function () {
        $('#productTable').DataTable();
    } );
</script>

    @if (session('product_move_to_trash'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('product_move_to_trash')}}",
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
            Swal.fire({
            title: 'Are you sure?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#check_btn').submit();
                }
            })
        });
    </script>


@endsection