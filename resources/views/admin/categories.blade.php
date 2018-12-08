@extends('admin.layouts.master')
@section('customcss')
    <link rel="stylesheet" href="/admin/css/toggle-switch.css">
@endsection
@section('pagename')
Category Manager
@endsection
@section('content')
    <div class="container">
        <button type="button" class="btn btn-info category-create-btn">New</button>
        <table id="listtable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th class="th-sm">Name
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Desc
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Modified by
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Preview
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Action
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr id="row-{{$category->id}}">
                    <td id="name-{{$category->id}}">{{$category->name}}</td>
                    <td id="desc-{{$category->id}}">{{$category->description}}</td>
                    <td id="admin-name-{{$category->id}}">@if($category->admin){{$category->admin->username}}@endif</td>
                    <td id="image-path-{{$category->id}}">
                      <img src="{{$category->image_path}}" width="100">
                    </td>
                    <td>
                        <button type="button" class="btn btn-info category-update-btn" onClick="updateCategoryClicked.call(this)" value="{{$category->id}}">Update</button>
                        <button type="button" class="btn btn-primary category-delete-btn" onClick="deleteCategoryClicked.call(this)" value="{{$category->id}}">Delete</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="category-modal" role="dialog">
        @php ($currentAdmin = Auth::guard('admin')->user())
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Category Manager</h4>
                </div>
                <div class="modal-body">                    
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td>Name</td>
                            <td>
                            <input type="text" class="form-control" id="category-name" placeholder="Enter Category Name">
                            </td>
                        </tr>
                        <tr>
                            <td>Desc</td>
                            <td>
                            <input type="text" class="form-control" id="category-desc" placeholder="Enter Category Desc">
                            </td>
                        </tr>
                        <tr>
                            <td>Image Link</td>
                            <td>
                            <input type="text" class="form-control" id="category-image-path" style="display: none" placeholder="Enter Category Image Link">
                            <h5 />
                            <input id="category-image-file" onChange="readURL.call(this)" accept="image/png, image/jpeg, image/jpg" type="file" class="form-control" name="image" />
                            <h5 />
                            <img id="category-image-preview" src="/admin/images/avatar.jpg" width="200" style="display: none"/>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                      <button type="button" class="btn btn-primary" id="create-category-btn" onclick="createCategory()">Create</button>
                      <button type="button" class="btn btn-primary" category-old-name="" category-id="" id="update-category-btn" onclick="updateCategory()">Update</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="category-delete-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Category Delete</h4>
                </div>
                <div class="modal-body">                    
                    Delete this category. You sure?
                </div>
                <div class="modal-footer">
                      <button type="button" class="btn btn-danger" category-id="" id="delete-category-btn" onclick="deleteCategory()">Delete</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

@endsection
@section('customscript')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(".category-create-btn").on("click",function () {               
                $("#category-modal").modal("show");
                $("#update-category-btn").hide();
                $("#create-category-btn").show();
                $('#category-image-preview').hide();

                $("#category-name").val("");
                $("#category-desc").val("");
                $("#category-image-path").val("");
                $("#category-image-file").val("");
            });

        });

        function updateCategoryClicked() {
                $("#category-modal").modal("show");
                $("#create-category-btn").hide();
                $("#update-category-btn").show();
                
                var categoryID = this.value;
                var name = document.getElementById("name-" + categoryID).innerText;
                var desc = document.getElementById("desc-" + categoryID).innerText;
                var imagePath = $("#image-path-" + categoryID + " img").attr('src');

                $("#category-name").val(name);
                $("#category-desc").val(desc);
                $("#category-image-path").val(imagePath);
                $("#update-category-btn").attr("category-id", categoryID);
                $("#update-category-btn").attr("category-old-name", name);
        }

        function deleteCategoryClicked() {
            $("#category-delete-modal").modal("show");
            var categoryID = this.value;     
            $("#delete-category-btn").attr("category-id", categoryID);
        }

        function createCategory() {
          var name = $("#category-name").val();
          var imagePath = "/storage/images/categories/" + name + ".png";    
          var desc = $("#category-desc").val();
          var adminID = {{ $currentAdmin->id }};
          var adminName = "{{ $currentAdmin->username }}";
          var file_data = $('#category-image-file').prop('files')[0];
          if(!file_data){
            toastr.error("Please choose a images!");
            return;
          }
          $.ajax({
                    type:'POST',
                    url: 'create-category',
                    data:{
                        name:name,
                        desc:desc,
                        adminID:adminID,
                        imagePath:imagePath,
                    },
                    success: function (response) {
                        if(!response.error){
                            sendFileToServer(name, file_data);
                            toastr.success('Category was created!');
                            $("#category-name").val("");
                            $("#category-desc").val("");
                            $("#category-image-path").val("");
                            $('#category-image-file').val('');
                            $('#category-image-preview').hide();

                            var categoryID = response.data;                           

                            var htmlCreated = '<tr id="row-' + categoryID +'"><td id="name-' + categoryID + '">' + name + '</td><td id="desc-' + categoryID + '">' + desc + '</td><td id="admin-name-' + categoryID + '">' + adminName + '</td><td id="image-path-' + categoryID + '"><img src="' + imagePath +'" width="100"></td><td><button type="button" class="btn btn-info category-update-btn" onClick="updateCategoryClicked.call(this)" value="' + categoryID + '">Update</button><button type="button" class="btn btn-primary category-delete-btn" onClick="deleteCategoryClicked.call(this)" value="' + categoryID + '">Delete</button></td></tr>';

                            $('#listtable tbody').prepend(htmlCreated);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errors = xhr.responseJSON.errors;
                        if(Object.values(errors)[0][0]) {
                            toastr.error(Object.values(errors)[0][0]);
                        }else{
                            toastr.error(xhr.responseJSON.message);
                        }
                    }
          });
        };

        
        
        function updateCategory() {
          var name = $("#category-name").val();
          var imagePath = "/storage/images/categories/" + name + ".png"; 
          var desc = $("#category-desc").val();
          var categoryID = $("#update-category-btn").attr('category-id');
          var oldName = $("#update-category-btn").attr('category-old-name');
          var adminID = {{ $currentAdmin->id }};
          var adminName = "{{ $currentAdmin->username }}";
          var file_data = $('#category-image-file').prop('files')[0];
          if(!file_data){
            $.ajax({
                    type:'PUT',
                    url: 'update-category',
                    data:{
                        id:categoryID,
                        name:name,
                        desc:desc,
                        adminID:adminID,
                        imagePath:imagePath,
                    },
                    success: function (response) {
                        if(!response.error){
                            changeFileName(oldName, name);
                            toastr.success('Category was changed!');
                            $("#name-" + categoryID).html(name);
                            $("#desc-" + categoryID).html(desc);
                            $("#image-path-" + categoryID + " img").attr('src', imagePath);
                            $("#admin-name-" + categoryID).html(adminName);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errors = xhr.responseJSON.errors;
                        if(Object.values(errors)[0][0]) {
                            toastr.error(Object.values(errors)[0][0]);
                        }else{
                            toastr.error(xhr.responseJSON.message);
                        }
                    }
            });
          }else {
            $.ajax({
                    type:'PUT',
                    url: 'update-category',
                    data:{
                        id:categoryID,
                        name:name,
                        desc:desc,
                        adminID:adminID,
                        imagePath:imagePath,
                    },
                    success: function (response) {
                        if(!response.error){
                            sendFileToServer(name, file_data);
                            toastr.success('Category was changed!');
                            $("#name-" + categoryID).html(name);
                            $("#desc-" + categoryID).html(desc);
                            $("#image-path-" + categoryID + " img").attr('src', imagePath);
                            $("#admin-name-" + categoryID).html(adminName);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        var errors = xhr.responseJSON.errors;
                        if(Object.values(errors)[0][0]) {
                            toastr.error(Object.values(errors)[0][0]);
                        }else{
                            toastr.error(xhr.responseJSON.message);
                        }
                    }
            });
          }
        }

        function deleteCategory() {
            var categoryID = $("#delete-category-btn").attr('category-id');
            $.ajax({
                    type:'DELETE',
                    url: 'delete-category',
                    data:{
                      id:categoryID,
                    },
                    success: function (response) {
                        $("#category-delete-modal").modal("hide");
                        if(!response.error)
                        {
                          toastr.success('Category was Deleted!');
                          $('#row-'+response.data).remove();
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $("#category-delete-modal").modal("hide");
                        toastr.error(xhr.responseJSON.message);
                    }
            });
        }

        function readURL() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#category-image-preview').attr('src', e.target.result).show();
                };
                reader.readAsDataURL(this.files[0]);
                // var name = $("#category-name").val();
                // $("#category-image-path").val("/storage/images/slides/" + name + ".png");
            }
        }

        function sendFileToServer(name, file_data) {
            var type = file_data.type;
            var match = ["image/png", "image/jpg", "image/jpeg"];
            if (type == match[0] || type == match[1] || type == match[2]) {
                var form_data = new FormData();
                form_data.append('file', file_data);
                form_data.append('name', name);
                $.ajax({
                    url: 'upload-category-image',
                    dataType: 'text',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'POST',
                    success: function (response) {
                        if(!response.error){
                            toastr.success('Category was changed!');
                            $('#category-image-file').val('');
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        toastr.error(xhr.responseJSON.message);
                    }
                });
            } else {
                toastr.error("Not Image! Try again");
                $('#category-image-file').val('');
            }
            return false;
        }

        function changeFileName(oldName, newName) {
                $.ajax({
                    url: 'change-category-image-name',
                    data: {
                        oldName:oldName,
                        newName:newName
                    },
                    type: 'POST',
                    success: function (response) {
                        if(!response.error){
                            // toastr.success('Category was changed!');
                            // $('#category-image-file').val('');
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        toastr.error(xhr.responseJSON.message);
                    }
                });
        }
    </script>
@endsection
