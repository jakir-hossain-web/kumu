@extends('layouts.dashboard')

<style>
    .inv_quantity{
        width: 70px;
        height: 35px;
        text-align: center;
        background: #f0f1f5;
        border: 1px solid #8b8b8b;
        border-radius: 5px;
        color: #7e7e7e;
    }
    .btn {
        line-height: 10px !important;
    }
    .icon_size{
        color: #fff;
        font-size: 20px !important;
    }
</style>

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('product')}}">Product</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Inventory</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-8">
        {{-- ========= single inventory update start ========== --}}
        <div class="card inv_single_card">
            <div class="card-header bg-primary">
                <h4 style="color: #fff">{{$product_info->product_name}}</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>Sl</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>

                    @forelse ($inventories as $sl=>$inventory)  
                        <form action="{{route('inventory.update')}}" method="POST">
                            @csrf
                            <tr>
                                <td>{{$sl+1}}</td>
                                <td>{{$inventory->rel_to_color->color_name}}</td>
                                <td>{{$inventory->size_id}}</td>
                                <td>
                                    <input type="hidden" name="inv_id" value="{{$inventory->id}}">
                                    <input type="number" class="inv_quantity" name="inv_quantity" value="{{$inventory->quantity}}" readonly>
                                </td>
                                <td>
                                    @can('inventory_edit')
                                        <button type="button" class="btn btn-primary inv_edit" style="width: 110px">Edit</button>
                                    @endcan

                                    <button type="submit" class="btn btn-success inv_update d-none" style="width: 110px">Update</button>

                                    @can('inventory_delete')
                                        <a class="btn btn-danger" style="width: 110px" href="{{route('inventory.delete', $inventory->id)}}">Delete</a>
                                    @endcan

                                </td>
                            </tr>
                        </form>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Inventory not added yet!</td>
                        </tr>
                    @endforelse
                </table>
            </div>
        </div>
        {{-- ========= single inventory update end ========== --}}

        {{-- ========= All inventory update start ========== --}}
        <form action="{{route('inventory.all_update')}}" method="POST">
            @csrf
            <div class="card inv_all_edit_card d-none">
                <div class="card-header bg-primary">
                    <h4 style="color: #fff">{{$product_info->product_name}}</h4>
                </div>
                <div class="card-body">                    
                    <table class="table table-striped">
                        <tr>
                            <th>Sl</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Quantity</th>
                        </tr>
                        @forelse ($inventories as $sl=>$inventory)  
                            <tr>
                                <td>{{$sl+1}}</td>
                                <td>{{$inventory->rel_to_color->color_name}}</td>
                                <td>{{$inventory->size_id}}</td>
                                <td>
                                    <input type="hidden" name="inv_id[]" value="{{$inventory->id}}">
                                    <input type="number" class="inv_quantity" name="inv_quantity[]" value="{{$inventory->quantity}}">
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Inventory not added yet!</td>
                            </tr>
                        @endforelse
                    </table>
                </div>
            </div>
            <div class="text-center">
                @can('inventory_edit')
                    <button type="button" class="btn btn-primary inv_edit_all">Click To Edit All <i class="fa fa-angle-double-right icon_size ml-2"></i></button>
                @endcan
                <button type="button" class="btn btn-primary inv_single_edit d-none"><i class="fa fa-angle-double-left icon_size mr-2"></i> Back To Single Edit</button>
                <button type="submit" class="btn btn-success inv_update_all d-none">Update All <i class="fa fa-paper-plane icon_size ml-2"></i></button>
            </div>
        </form>
        {{-- ========= All inventory update end ========== --}}
    </div>

    @can('inventory_add')
        {{-- ======== Add Product inventory ========= --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 style="color: #fff">Add Inventory</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('inventory.store')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input type="hidden" name="product_id" value="{{$product_info->id}}">
                            <input type="text" readonly class="form-control" value="{{$product_info->product_name}}">
                        </div>
                        <div class="mb-3">
                            <select name="color_id" class="form-control">
                                <option value="">--Select Color</option>
                                @foreach ($colors as $color)
                                    <option value="{{$color->id}}">{{$color->color_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <select name="size_id" class="form-control">
                                <option value="">--Select Size</option>
                                    @foreach ($sizes as $size)
                                        <option value="{{$size->id}}">{{$size->size_name}}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control" name="quantity" placeholder="Quantity">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Add Inventory</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
</div>

@endsection

@section('footer_script')

    <script>
        $('.inv_edit').click(function(){
            $(this).closest('tr').find('input').removeAttr('readonly');
            $(this).closest('tr').find('.inv_update').removeClass('d-none');
            $(this).closest('tr').find('.inv_edit').addClass('d-none');
            $(this).closest('tr').find('input').css('background', 'white');
            $(this).closest('tr').find('input').css('color', 'black');
            $(this).closest('tr').find('input').css('font-weight', '500');
            $(this).closest('tr').find('input').css('border', '3px solid #616161');
        });
    </script>

    <script>
        $('.inv_edit_all').click(function(){
            $('.inv_single_card').addClass('d-none');
            $('.inv_all_edit_card').removeClass('d-none');
            $('.inv_all_edit_card').find('input').css('background', 'white');
            $('.inv_all_edit_card').find('input').css('color', 'black');
            $('.inv_all_edit_card').find('input').css('font-weight', '500');
            $('.inv_all_edit_card').find('input').css('border', '3px solid #616161');
            $('.inv_single_edit').removeClass('d-none');
            $('.inv_update_all').removeClass('d-none');
            $('.inv_edit_all').addClass('d-none');
        });
    </script>

    <script>
        $('.inv_single_edit').click(function(){
            $('.inv_single_card').removeClass('d-none');
            $('.inv_all_edit_card').addClass('d-none');
            $('.inv_single_edit').addClass('d-none');
            $('.inv_update_all').addClass('d-none');
            $('.inv_edit_all').removeClass('d-none');
        });
    </script>

    @if (session('inventory_update'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('inventory_update')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

    @if (session('inventory_delete'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('inventory_delete')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

@endsection