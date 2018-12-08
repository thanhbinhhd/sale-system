@extends('admin.layouts.master')
@section('customcss')
    <link rel="stylesheet" href="/admin/css/toggle-switch.css"/>
    <link rel="stylesheet" type="text/css" href="/admin/css/color-filter.css"/>
    <link rel="stylesheet" type="text/css" href="/admin/css/product.css"/>
    <link rel="stylesheet" href="/user/css/util.min.css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

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
        <form method="post" action="{{route('admin.category-manager.store')}}" enctype="multipart/form-data">
            <legend>Create new Category</legend>
            {{ csrf_field()}}
            <div class="form-group" style="width: 50%">
                <label for="inputCategoryName">Category Name:</label>
                <input id="inputCategoryName" value="{{ old('name') }}" class="form-control" name="name" placeholder="Category name">
            </div>
            <div class="form-group" style="width: 50%">
                <label for="inputDescription">Description:</label>
                <textarea id="inputDescription" rows="5" class="form-control" name="description" placeholder="Description">{{ old('description') }}</textarea>
            </div>

            <img id="preview" src="/admin/images/avatar.jpg" alt="your image" width="200" style="display: none"/>
            <div class="form-group" style="width: 50%">
                <label for="inputFile">Image:</label>
                <input id="inputFile"  accept="image/png, image/jpeg, image/jpg" type="file" class="form-control" name="image" />
            </div>
            <div class="form-group" id="other-preview">
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
