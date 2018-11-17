@extends('admin.layouts.master')
@section('customcss')
    <link rel="stylesheet" href="/admin/css/toggle-switch.css"/>
    <link rel="stylesheet" type="text/css" href="/admin/css/color-filter.css"/>
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
        <form method="post" action="{{route('admin.product-manager.store')}}" enctype="multipart/form-data">
            <legend>Create new Product</legend>
            {{ csrf_field()}}
            <div class="form-group"  style="width: 50%">
                <label for="inputCategory">Category:</label>
                <select class="form-control" id="inputCategory" name="category_id">
                    @foreach (\App\Model\Category::all() as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="width: 50%">
                <label for="inputProductName">Product name:</label>
                <input id="inputProductName" value="{{ old('name') }}" class="form-control" name="name" placeholder="Product name">
            </div>
            <div class="form-group" style="width: 50%">
                <label for="inputPrice">Price:</label>
                <input id="inputPrice" value="{{ old('price') }}" class="form-control" name="price" placeholder="Price">
            </div>
            <div class="form-group" style="width: 50%">
                <label for="inputQuantity">Quantity:</label>
                <input id="inputQuantity" value="{{ old('quantity') }}" class="form-control" name="quantity" placeholder="Quantity">
            </div>
            <div class="form-group" style="width: 50%">
                <label for="">Size</label>
                <select class="form-control product-status" name="size">
                    @foreach(config('sales.size') as $si)
                        <option value="{{$si}}">{{$si}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="width: 50%">
                <label for="" >Color:</label>
                <ul class="flex-w">
                    @foreach (range(1, 7) as $i)
                        <li class="m-r-10">
                            <input style="display: none;" value="{{$i}}" class="checkbox-color-filter" id="color-filter{{$i}}" type="radio" name="color">
                            <label class="color-filter color-filter{{$i}}" for="color-filter{{$i}}"></label>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="form-group" style="width: 50%">
                <label for="inputTag">Tag</label>
                <select class="form-control" multiple id="inputTag" name="tag[]">
                    @foreach(\App\Model\Tag::all() as $tag)
                        <option value="{{$tag->id}}">{{$tag->name}}</option>
                        @endforeach
                </select>
            </div>
            <div class="form-group" style="width: 50%">
                <label for="inputDescription">Description:</label>
                <textarea id="inputDescription"  class="form-control" name="description" placeholder="Description">{{ old('description') }}</textarea>
            </div>

            <img id="preview" src="/admin/images/avatar.jpg" alt="your image" width="200" style="display: none"/>
            <div class="form-group" style="width: 50%">
                <label for="inputFile">Image:</label>
                <input id="inputFile" type="file" class="form-control" name="image" />
            </div>
            <div class="form-group" style="width: 50%">
                <label for="inputFiles">Other Images:</label>
                <input id="inputFiles" type="file" class="form-control" name="images[]" multiple />
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" value="1" @if(old('status')) checked="" @endif id="active" name="status" >
                <label class="form-check-label" for="active">Active this product</label>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
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

        $(document).ready(function () {
            $("#inputTag").select2();
            $("#inputFile").change(function() {
                readURL(this);
            });
        });

    </script>
@endsection
