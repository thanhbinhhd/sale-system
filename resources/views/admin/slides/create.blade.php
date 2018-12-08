@extends('admin.layouts.master')
@section('customcss')
    <link rel="stylesheet" href="/admin/css/toggle-switch.css"/>
    <link rel="stylesheet" type="text/css" href="/admin/css/color-filter.css"/>
    <link rel="stylesheet" type="text/css" href="/admin/css/product.css"/>
    <link rel="stylesheet" href="/user/css/util.min.css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

@endsection
@section('pagename')
    Slide Manager
@endsection
@section('content')
    <div class="container">
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-warning">{{ $error }}</div>
            @endforeach
        @endif
        <form method="post" action="{{route('admin.slide-manager.store')}}" enctype="multipart/form-data">
            <legend>Create new Slide</legend>
            {{ csrf_field()}}
            <div class="form-group" style="width: 50%">
                <label for="inputSlideTitle">Slide Title:</label>
                <input id="inputSlideTitle" value="{{ old('title') }}" class="form-control" name="title" placeholder="Slide title">
            </div>
            <img id="preview" src="/admin/images/avatar.jpg" alt="your image" width="200" style="display: none"/>
            <div class="form-group" style="width: 50%">
                <label for="inputFile">Image:</label>
                <input id="inputFile"  accept="image/png, image/jpeg, image/jpg" type="file" class="form-control" name="image" />
            </div>
            <div class="form-group" id="other-preview">
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" value="1" @if(old('status')) checked="" @endif id="active" name="status" >
                <label class="form-check-label" for="active">Active this slide</label>
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
