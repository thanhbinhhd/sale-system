@extends('admin.layouts.master')
@section('customcss')
    <link rel="stylesheet" href="/admin/css/toggle-switch.css"/>
    <link rel="stylesheet" type="text/css" href="/admin/css/color-filter.css"/>
    <link rel="stylesheet" type="text/css" href="/admin/css/product.css"/>
    <link rel="stylesheet" href="/user/css/util.min.css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

@endsection
@section('pagename')
    Blog Manager
@endsection
@section('content')
    <div class="container">
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-warning">{{ $error }}</div>
            @endforeach
        @endif
        <form method="post" action="{{route('admin.blog-manager.store')}}" enctype="multipart/form-data">
            <legend>Create new Blog</legend>
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
                <label for="inputBlogTitle">Blog Title:</label>
                <input id="inputBlogTitle" value="{{ old('title') }}" class="form-control" name="title" placeholder="Blog title">
            </div>
            <div class="form-group" style="width: 50%">
                <label for="inputBlogSlug">Blog Slug:</label>
                <input id="inputBlogSlug" value="{{ old('slug') }}" class="form-control" name="slug" placeholder="Blog Slug">
            </div>
            <div class="form-group" style="width: 50%">
                <label for="inputBlogAuthor">Author:</label>
                <input id="inputBlogAuthor" value="{{ old('author') }}" class="form-control" name="author" placeholder="Author">
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
            <div class="form-group" style="width: 50%">
                <label for="inputContent">Content:</label>
                <textarea id="inputContent"  class="form-control" name="content" placeholder="Content">{{ old('content') }}</textarea>
            </div>
            <div class="form-group" style="width: 50%">
                <label for="inputBlogSource">Source:</label>
                <input id="inputBlogSource" value="{{ old('source') }}" class="form-control" name="source" placeholder="Blog Source">
            </div>

            <img id="preview" src="/admin/images/avatar.jpg" alt="your image" width="200" style="display: none"/>
            <div class="form-group" style="width: 50%">
                <label for="inputFile">Thumbnail:</label>
                <input id="inputFile"  accept="image/png, image/jpeg, image/jpg" type="file" class="form-control" name="image" />
            </div>
            <div class="form-group" id="other-preview">
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" value="1" @if(old('status')) checked="" @endif id="active" name="status" >
                <label class="form-check-label" for="active">Active this blog</label>
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
                };
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
            $("#inputTag").select2();
            $("#inputFile").change(function() {
                readURL(this);
            });
            $("#inputFiles").change(function() {
                readURLs(this);
            });
        });

    </script>
@endsection
