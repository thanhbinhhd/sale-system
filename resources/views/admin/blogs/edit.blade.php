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
    Blog Manager
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
        <form method="post" action="{{route('admin.blog-manager.update', ['id' => $blog->id])}}" enctype= "multipart/form-data" >
            <legend>Edit Blog</legend>
            {{ csrf_field()}}
            <input name="_method" type="hidden" value="PUT">
            <div class="form-group"  style="width: 50%">
                <label for="inputCategory">Category:</label>
                <select class="form-control" id="inputCategory" name="category_id">
                    @foreach (\App\Model\Category::all() as $category)
                        <option @if($category->id == $blog->category_id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="width: 50%">
                <label for="inputBlogTitle">Blog Title:</label>
                <input id="inputBlogTitle" value="{{old('title')?old('title'):$blog->title}}" class="form-control" name="title" placeholder="Blog title">
            </div>
            <div class="form-group" style="width: 50%">
                <label for="inputBlogSlug">Blog Slug:</label>
                <input id="inputBlogSlug" value="{{ old('slug')?old('slug'):$blog->slug }}" class="form-control" name="slug" placeholder="Blog Slug">
            </div>
            <div class="form-group" style="width: 50%">
                <label for="inputBlogAuthor">Author:</label>
                <input id="inputBlogAuthor" value="{{ old('author')?old('author'):$blog->author }}" class="form-control" name="author" placeholder="Author">
            </div>
            <div class="form-group" style="width: 50%">
                <label for="inputTag">Tag</label>
                <select class="form-control" multiple id="inputTag" name="tag[]">
                    @foreach(\App\Model\Tag::all() as $tag)
                        <option @if (in_array($tag->id, array_column($blog->taggables()->get()->toArray(), 'tag_id'))) selected @endif value="{{$tag->id}}">{{$tag->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="width: 50%">
                <label for="inputDescription">Description:</label>
                <textarea id="inputDescription" rows="5" class="form-control" name="description" placeholder="Description">{{ old('description')?old('description'):$blog->description }}</textarea>
            </div>


            <div class="form-group" style="width: 50%">
                <label for="inputContent">Content:</label>
                <textarea id="inputContent" rows="20" class="form-control" name="content" placeholder="Content">{{ old('content')?old('content'):$blog->content }}</textarea>
            </div>
            <div class="form-group" style="width: 50%">
                <label for="inputBlogSource">Source:</label>
                <input id="inputBlogSource" value="{{ old('source')?old('source'):$blog->source }}" class="form-control" name="source" placeholder="Blog Source">
            </div>

            <img id="preview" @if ($blog->thumbnail_path != null) src="{{$blog->thumbnail_path}}" @else src="/admin/images/avatar.jpg" style="display: none" @endif alt="Product image" width="200" />
            <div class="form-group" style="width: 50%">
                <label for="inputFile">Image:</label>
                <input id="inputFile"  accept="image/png, image/jpeg, image/jpg" type="file" class="form-control" name="image" />
            </div>
            
            <div class="form-check">
                <input type="checkbox" class="form-check-input" value="1" @if(old('status') or $blog->status == \App\Model\News::ACTIVE) checked="" @endif id="active" name="status" >
                <label class="form-check-label" for="active">Active this blog</label>
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
