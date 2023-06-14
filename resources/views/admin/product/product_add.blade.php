@extends('layouts.dashboard')

<style>
    .icon_size{
        font-size: 17px !important;
    }
</style>

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Product Add</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 style="color: #fff">Add Product</h4>
            </div>
            <div class="card-body">
                <form action="{{route('product.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <select name="catagory_id" id="catagory_id" class="form-control" value="{{old('catagory_id')}}">
                                <option value="">--Select Category--</option>
                                @foreach ($catagories as $catagory) 
                                    <option value="{{$catagory->id}}" {{old('catagory_id')==$catagory->id?'selected':''}}>{{$catagory->catagory_name}}</option>
                                @endforeach
                            </select>
                            @error('catagory_id')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <select name="subcatagory_id" id="subcatagory_id" class="form-control">
                                <option value="">
                                    {{old('subcatagory_id')!=null?App\Models\Subcatagory::find(old('subcatagory_id'))->subcatagory_name:'--Select Subcategory--'}}
                                </option>
                            </select>
                            @error('subcatagory_id')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Product Name:</label>
                            <input type="text" class="form-control" name="product_name" id="p_name" value="{{old('product_name')!=null?old('product_name'):null}}">
                            @error('product_name')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Product Price:</label>
                            <input type="text" class="form-control" name="price" value="{{old('price')}}">
                            @error('price')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Product Discount:</label>
                            <input type="number" class="form-control pro_dis" name="discount" value="{{old('discount') == '' ?'0' :old('discount')}}" id="disc" style="color: transparent">
                            @error('discount')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Product Brand:</label>
                            <input type="text" class="form-control" name="brand" value="{{old('brand')}}">
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label class="form-label">Key Features:</label>
                            <input type="text" class="form-control" name="key_features" value="{{old('key_features')}}">
                            @error('key_features')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label class="form-label">Description:</label>
                            <textarea name="description" class="form-control" id="description" cols="30" rows="10">
                                {{old('description')}}
                            </textarea>
                            @error('description')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Product Preview:</label>
                            <input type="file" class="form-control" name="preview">
                            @error('preview')
                                <strong class="text-danger err">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Product Thumbnail:</label>
                            <input type="file" class="form-control" name="thumbnail[]" multiple>
                            @error('thumbnail')
                                <strong class="text-danger err">{{$message}}</strong>
                            @enderror
                            @error('thumbnail.*')
                                <strong class="text-danger err">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-12 mb-3 text-center m-auto">
                            @can('product_add')
                                <button type="submit" class="form-control bg-primary text-white icon_size">Add Product</button>
                            @endcan
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_script')
<script>
    $('#catagory_id').change(function(){
        var catagory_id = $(this).val();
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:'/getSubcatagory',
            type:'POST',
            data:{'catagory_id': catagory_id},
            success:function(data){
                $('#subcatagory_id').html(data);
            }
        })
    })
</script>

<script>
    $(document).ready(function() {
        $('#description').summernote();
    });
</script>

@if (session('product_add_success'))
    <script>
        Swal.fire({
        position: 'center',
        icon: 'success',
        title: "{{session('product_add_success')}}",
        showConfirmButton: false,
        timer: 2000
        })
    </script>
@endif

<script>
    $(document).ready( function () {
        $('#productTable').DataTable();
    } );
</script>

<script>
    $('#disc').click(function(){
        $(this).css('color', '#b1b1b1')
    })
</script>
{{-- for focus error message --}}
<script>
    $('.err').show(function(){
        $('document').ready(function(){
            $("html, body").animate({ 
                scrollTop: $('.err').offset().top 
            }, 1000);
        })
    })
</script>

@endsection