@extends('admin.layouts.master')
@section('customcss')
    <link rel="stylesheet" href="/admin/css/toggle-switch.css">
    <link rel="stylesheet" type="text/css" href="/admin/css/color-filter.css">
@endsection
@php ($currentAdmin = Auth::guard('admin')->user())
@section('pagename')
    New Sale-off
@endsection
@section('content')
    <div class="container">
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-warning">{{ $error }}</div>
            @endforeach
        @endif
        <form action="{{route('admin.sale-manager.store')}}" method="post">
            {{ csrf_field()}}
            <div class="col-lg-6 col-sm-12 left">
                <label for="category">Category:</label>
                <select class="form-control" id="category" name="category">
                    <option disabled selected>Select category</option>
                    @foreach ($categories as $category)
                    <option class="options" value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
                <div class="checkbox">
                    <label><input type="checkbox" id="check-all" value="">Check all</label>
                </div>
                <div class="form-group" id="product-list">
                </div>
            </div>
            <div class="col-lg-6 col-sm-12 right">
                <div class="form-group">
                    <label for="promo_code">Promo Code:</label>
                    <input type="number" value="{{old('promo_code')}}" name="promo_code" class="form-control" id="promo_code">
                </div>
                <div class="form-group">
                    <label for="promo">Promo:</label>
                    <input type="text" value="{{old('promo')}}" name="promo" class="form-control" id="promo">
                </div>
                <div class="form-group">
                    <label for="start_date">Start date:</label>
                    <input type="date" value="{{old('start_date')}}" name="start_date" class="form-control" id="start_date">
                </div>
                <div class="form-group">
                    <label for="end_date">End date:</label>
                    <input type="date" value="{{old('end_date')}}" name="end_date" class="form-control" id="end_date">
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea name="description" class="form-control" rows="5" id="description">{{old('end_date')}}</textarea>
                </div>
                <div class="form-group" style="width: 50%">
                    <label for="type">Type:</label>
                    <select id="type" name="type" class="form-control">
                        <option value="1" {{old('type')==1?"selected":""}}>Public</option>
                        <option value="0"  {{old('type')==0?"selected":""}}>Private</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" value="Submit" class="btn btn-info"/>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('customscript')
    <script>
        var productList = {!! json_encode(old('product_id')) !!};
        var first = true;
        $(document).ready(function () {
            function loadProduct(id) {
                $.ajax({
                        type:'get',
                        url: '/admin/sale-manager/category',
                        data:{
                            id:id
                        },
                        success: function (response) {
                            if(!response.error)
                            {
                                $('#product-list').empty();
                                for (let i = 0; i < response.data.length ; i++) {
                                    $('#product-list').append('<div class="checkbox"><label>'+
                                        '<input ' + ((productList && productList.includes("" + response.data[i].id))?"checked":"") + ' class="ahihi" type="checkbox" name="product_id[]" value="' +
                                        response.data[i].id +'">'+
                                        response.data[i].name+
                                        '</label></div>');
                                }
                                first = false;
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            console.log(xhr.status);
                            switch (xhr.status) {
                                case 404: toastr.error("Product " + thrownError);
                                    break;
                                default: toastr.error(xhr.responseJSON.message);
                            }
                        }
                    }
                );
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#check-all').change(function () {
                $('.ahihi').attr("checked",$(this).is(':checked'));
            });
            $('#category').val({{old('category')}});
            if('{{old("category")}}')loadProduct({{old('category')}});
           $('#category').change(function () {
               loadProduct($(this).val());
           });
        });
    </script>
@endsection
