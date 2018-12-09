@extends('admin.layouts.master')
@section('customcss')
    <link rel="stylesheet" href="/admin/css/toggle-switch.css"/>
    <link rel="stylesheet" type="text/css" href="/admin/css/color-filter.css"/>
    <link rel="stylesheet" type="text/css" href="/admin/css/product.css"/>
    <link rel="stylesheet" href="/user/css/util.min.css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    <style>
        ul{
            list-style: none;
        }
        input[type="radio"]:checked+label{ border: solid; }
    </style>
@endsection
@section('pagename')
    Product Manager
@endsection
@section('content')
    <div class="container">
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-warning">{{ $error }}</div>
            @endforeach
        @endif
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        <form method="post" action="{{route('admin.product-manager.update', ['id' => $product->id])}}" enctype= "multipart/form-data" >
            <legend>Edit Product</legend>
            {{ csrf_field()}}
            <input name="_method" type="hidden" value="PUT">
            <div class="form-group"  style="width: 50%">
                <label for="inputCategory">Category:</label>
                <select class="form-control" id="inputCategory" name="category_id">
                    @foreach (\App\Model\Category::all() as $category)
                        <option @if($category->id == $product->category_id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="width: 50%">
                <label for="inputProductName">Product name:</label>
                <input id="inputProductName" value="{{old('name')?old('name'):$product->name}}" class="form-control" name="name" placeholder="Product name">
            </div>
            <div class="form-group" style="width: 50%">
                <label for="inputPrice">Price:</label>
                <div class="flex">
                    <span class="currency">$</span>
                    <input id="inputPrice" value="{{ old('price')?old('price'):$product->price }}" class="form-control" name="price" placeholder="Price" />
                </div>
            </div>
            <div class="form-group" style="width: 50%">
                <label for="inputQuantity">Quantity:</label>
                <input id="inputQuantity" value="{{ old('quantity')?old('quantity'):$product->quantity }}" class="form-control" name="quantity" placeholder="Quantity">
            </div>
            <div class="form-group" style="width: 50%">
                <label for="">Size</label>
                <select class="form-control product-status" name="size">
                    @foreach(config('sales.size') as $si)
                        <option @if ($product->productDetail != null && $product->productDetail->size == $si) selected @endif value="{{$si}}">{{$si}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="width: 50%">
                <label for="" >Color:</label>
                <ul class="flex-w">
                    @foreach (range(1, 7) as $i)
                        <li class="m-r-10">
                            <input style="display: none;" @if($product->productDetail != null && $i == $product->productDetail->color) checked @endif value="{{$i}}" class="checkbox-color-filter" id="color-filter{{$i}}" type="radio" name="color">
                            <label class="color-filter color-filter{{$i}}" for="color-filter{{$i}}"></label>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="form-group" style="width: 50%">
                <label for="inputTag">Tag</label>
                <select class="form-control" multiple id="inputTag" name="tag[]">
                    @foreach(\App\Model\Tag::all() as $tag)
                        <option @if (in_array($tag->id, array_column($product->taggables()->get()->toArray(), 'tag_id'))) selected @endif value="{{$tag->id}}">{{$tag->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="width: 50%">
                <label for="inputDescription">Description:</label>
                <textarea id="inputDescription"  class="form-control" name="description" placeholder="Description">{{ old('description')?old('description'):$product->description }}</textarea>
            </div>

            <img id="preview" @if ($product->image_path != null) src="{{$product->image_path}}" @else src="/admin/images/avatar.jpg" style="display: none" @endif alt="Product image" width="200" />
            <div class="form-group" style="width: 50%">
                <label for="inputFile">Image:</label>
                <input id="inputFile"  accept="image/png, image/jpeg, image/jpg" type="file" class="form-control" name="image" />
            </div>
            <div class="form-group">
            @if ($product->images != null)
                <label>Select to delete:</label><br/>
                @foreach($product->images as $image)
                        <label for="im-{{$image->id}}" ><img src="{{$image->image_url}}" width="72"/></label>
                        <input id="im-{{$image->id}}" type="checkbox" name="todel[]" value="{{$image->id}}">
                @endforeach
                    <div class="form-group" id="other-preview"></div>
            @endif
            </div>
            <div class="form-group" style="width: 50%">
                <label for="inputFiles">Other Images:</label>
                <input id="inputFiles" type="file"  accept="image/png, image/jpeg, image/jpg" class="form-control" name="images[]" multiple />
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" value="1" @if(old('status') or $product->status == \App\Model\Product::ACTIVE) checked="" @endif id="active" name="status" >
                <label class="form-check-label" for="active">Active this product</label>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
@section('customscript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script type="text/javascript">

        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#preview').attr('src', e.target.result).show();
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readURLs(input){
            $('#other-preview').empty();
            $.each(input.files, function(i, j){
                console.log(i);
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#other-preview').append('<img src="' + e.target.result +'" style="width: 72px; padding-left: 3px;"/>');
                };
                reader.readAsDataURL(input.files[i]);
            });
        }
        $(document).ready(function () {
            $('#inputTag').select2();
            console.log($("#inputTag").val());
            $('#inputTag').val($("#inputTag").val());
            $("#inputFile").change(function() {
                readURL(this);
            });
            $("#inputFiles").change(function() {
                readURLs(this);
            });
        });

    </script>
@endsection
