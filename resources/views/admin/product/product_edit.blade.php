@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{route('product')}}">Product</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Product Edit</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card" style="border: 1px solid blue">
            <div class="card-body">
                <table class="table table-striped" id="productTable">
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>After Discount</th>
                        <th>Brand</th>
                        <th>Preview</th>
                        <th>Thumbnail</th>
                    </tr>
                    @foreach ($products as $product)
                        <tr>
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
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 style="color: #fff">Product Edit</h4>
            </div>
            <div class="card-body">
                <form action="{{route('product.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                {{--========= catagory name field ==========--}}
                        <div class="col-lg-6 mb-3">
                            <select name="catagory_id" id="catagory_id" class="form-control" value="{{old('catagory_id')}}">
                                @foreach ($products as $product)
                                    <option value="{{$product->catagory_id}}">{{$product->rel_to_catagory->catagory_name}}</option>
                                @endforeach
                                @foreach ($catagories as $catagory) 
                                    <option value="{{$catagory->id}}" {{old('catagory_id')==$catagory->id?'selected':''}}>{{$catagory->catagory_name}}</option>
                                @endforeach
                            </select>
                            @error('catagory_id')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>

                {{--========= subcatagory name field ==========--}}
                        <div class="col-lg-6 mb-3">
                            <select name="subcatagory_id" id="subcatagory_id" class="form-control">
                                @foreach ($products as $product)
                                    <option value="{{$product->subcatagory_id}}">{{$product->rel_to_subcatagory->subcatagory_name}}</option>
                                @endforeach
                                <option value="">
                                    {{old('subcatagory_id')!=null?App\Models\Subcatagory::find(old('subcatagory_id'))->subcatagory_name:'--Select Subcategory--'}}
                                </option>
                            </select>
                            @error('subcatagory_id')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>

                {{--========= product name field ==========--}}
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Product Name:</label>
                            @foreach ($products as $product)
                                <input type="text" class="form-control" name="product_name" id="p_name" value="{{$product->product_name}}">
                            @endforeach
                            @error('product_name')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror

                            @if (session('product_update_duplicate'))
                                <strong class="text-danger" >{{session('product_update_duplicate')}}</strong>
                            @endif
                        </div>

                {{--========= product price field ==========--}}
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Product Price:</label>
                            @foreach ($products as $product)
                                <input type="text" class="form-control" name="price" value="{{$product->price}}">
                             @endforeach
                            @error('price')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>

                {{--========= product Discount field ==========--}}
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Product Discount:</label>
                            @foreach ($products as $product)
                                <input type="text" class="form-control pro_dis" name="discount" value="{{$product->discount}}">
                            @endforeach
                            @error('discount')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>

                {{--========= Product Brand field ==========--}}
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Product Brand:</label>
                            @foreach ($products as $product)
                                <input type="text" class="form-control" name="brand" value="{{$product->brand}}">
                            @endforeach
                        </div>

                {{--========= Key Features field & hidden product id ==========--}}
                        <div class="col-lg-12 mb-3">
                            <label class="form-label">Key Features:</label>
                            @foreach ($products as $product)
                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                <input type="text" class="form-control" name="key_features" value="{{$product->key_features}}">
                            @endforeach
                            
                            @error('key_features')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>

                {{--========= description field ==========--}}
                        <div class="col-lg-12 mb-3">
                            <label class="form-label">Description:</label>
                            <textarea name="description" class="form-control" id="description" cols="30" rows="10">
                                @foreach ($products as $product)
                                {{$product->description}}
                                @endforeach
                            </textarea>
                            @error('description')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>

                {{--========= preview field ==========--}}
                        <div class="col-lg-6 mb-3">
                            <div class="mb-2">
                                @error('preview')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>
                            <label class="form-label">Product Preview:</label>
                            <input type="file" class="form-control" name="preview" onchange="document.getElementById('blahs').src = window.URL.createObjectURL(this.files[0])">
                            <div class="mb-3">
                                @foreach ($products as $product)
                                    <img width="100" id="blahs" src="{{asset('uploads/product/preview')}}/{{$product->preview}}" alt="catagory_image">
                                @endforeach
                            </div>
                        </div>

                {{--========= thumbnail field ==========--}}
                        <div class="col-lg-6 mb-3">
                            <div class="mb-2">
                                @error('thumbnail.*')
                                    <strong class="text-danger err">{{$message}}</strong>
                                @enderror
                            </div>

                            <label class="form-label">Product Thumbnail:</label>
                            <input type="file" class="form-control" name="thumbnail[]" multiple onchange="loadFile(event)">
                            <div id="output">
                                @foreach ($thumbnails as $thumbnail)
                                    <img width="100" id="output" src="{{asset('uploads/product/thumbnails')}}/{{$thumbnail->thumbnail}}" alt="catagory_image">
                                @endforeach
                            </div>
                        </div>



                {{--========= Submit button ==========--}}
                        <div class="col-lg-12 mb-3 text-center m-auto">
                            <button type="submit" class="form-control bg-primary text-white">Update Product</button>
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
        $('#catagory_id').click(function(){
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

    @if (session('product_update'))
        <script>
            Swal.fire({
            position: 'center',
            icon: 'success',
            title: "{{session('product_update')}}",
            showConfirmButton: false,
            timer: 2000
            })
        </script>
    @endif

    <script>
        const img = (src) => `<img src=${src} width="100px"/>`;

        var loadFile = function (event) {
            var output = document.getElementById('output');
            output.innerHTML = '';

            [...event.target.files].forEach(
            (file) => (output.innerHTML += img(URL.createObjectURL(file)))
            );
        };
    </script>

    {{-- <script>
        $(document).ready( function () {
            $('#productTable').DataTable();
        } );
    </script>

    <script>
        $('#disc').click(function(){
            $(this).css('color', '#b1b1b1')
        })
    </script>

    <script>
        $('.err').show(function(){
            $('document').ready(function(){
                $("html, body").animate({ 
                    scrollTop: $('.err').offset().top 
                }, 1000);
            })
        })
    </script> --}}



@endsection