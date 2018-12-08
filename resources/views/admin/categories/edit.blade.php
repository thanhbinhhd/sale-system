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
    Category Manager
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
        <form method="post" action="{{route('admin.category-manager.update', ['id' => $category->id])}}" enctype= "multipart/form-data" >
            <legend>Edit Category</legend>
            {{ csrf_field()}}
            <input name="_method" type="hidden" value="PUT">
            <input name="category-id" type="hidden" value={{$category->id}}>
            <div class="form-group" style="width: 50%">
                <label for="inputCategoryName">Category Name:</label>
                <input id="inputCategoryName" value="{{old('name')?old('name'):$category->name}}" class="form-control" name="name" placeholder="Category name">
            </div>
            <div class="form-group" style="width: 50%">
                <label for="inputDescription">Description:</label>
                <textarea id="inputDescription" rows="5" class="form-control" name="description" placeholder="Description">{{ old('description')?old('description'):$category->description }}</textarea>
            </div>
            <img id="preview" @if ($category->image_path != null) src="{{$category->image_path}}" @else src="/admin/images/avatar.jpg" style="display: none" @endif alt="Category image" width="200" />
            <div class="form-group" style="width: 50%">
                <label for="inputFile">Image:</label>
                <input id="inputFile"  accept="image/png, image/jpeg, image/jpg" type="file" class="form-control" name="image" />
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
