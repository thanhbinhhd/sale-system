@extends('admin.layouts.master')
@section('customcss')
    <link rel="stylesheet" href="/admin/css/toggle-switch.css">
@endsection
@section('pagename')
Slide Manager
@endsection
@section('content')
    <div class="container">
        <button type="button" class="btn btn-info slide-create-btn">New</button>
        <table id="listtable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th class="th-sm">Title
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Preview
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Status
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Action
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($slides as $slide)
                <tr id="row-{{$slide->id}}">
                    <td id="title-{{$slide->id}}">{{$slide->title}}</td>
                    <td id="link-{{$slide->id}}">
                      <img src="{{$slide->link}}" alt="" width="200">
                    </td>
                    <td>
                        <label class="switch">
                            <input class="slide-status" onChange="changeSlideStatusClicked.call(this)" type="checkbox" @if ($slide->status == 1) checked @endif id="{{$slide->id}}">
                            <span class="slider round"></span>
                        </label>
                    </td>
                    <td>
                        <button type="button" class="btn btn-info slide-update-btn" onClick="updateSlideClicked.call(this)" value="{{$slide->id}}">Update</button>
                        <button type="button" class="btn btn-primary slide-delete-btn" onClick="deleteSlideClicked.call(this)" value="{{$slide->id}}">Delete</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="slide-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Slide Manager</h4>
                </div>
                <div class="modal-body">                     
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td>Title</td>
                            <td>
                            <input type="text" class="form-control" id="slide-title" placeholder="Enter Slide Title">
                            </td>
                        </tr>
                        <tr>
                            <td>Link</td>
                            <td>
                            <input type="text" class="form-control" id="slide-link" style="display: none" placeholder="Enter Slide Link">
                            <h5 />
                            <input id="slide-image-file" onChange="readURL.call(this)" accept="image/png, image/jpeg, image/jpg" type="file" class="form-control" name="image" />
                            <h5 />
                            <img id="slide-image-preview" src="/admin/images/avatar.jpg" width="200" style="display: none"/>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="create-slide-btn" onclick="createSlide()">Create</button>
                    <button type="button" class="btn btn-primary" slide-old-name="" slide-id="" id="update-slide-btn" onclick="updateSlide()">Update</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="slide-delete-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Slide Delete</h4>
                </div>
                <div class="modal-body">                    
                    Delete this Slide. You sure?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" slide-id="" id="delete-slide-btn" onclick="deleteSlide()">Delete</button>
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

            $(".slide-create-btn").on("click",function () {               
                $("#slide-modal").modal("show");
                $("#update-slide-btn").hide();
                $("#create-slide-btn").show();
                $('#slide-image-preview').hide();

                $("#slide-title").val("");
                $("#slide-link").val("");
                $("#slide-image-file").val("");
            });
        });

        function changeSlideStatusClicked() {
                var id = this.id;
                var status = ($("#" + id).is(':checked')==1) ? 1 : 0;
                $.ajax({
                    type:'PUT',
                    url: 'update-slide-status',
                    data:{
                        id:id,
                        status:status,
                    },
                    success: function (response) {
                        if(!response.error)
                        {
                            toastr.success('Status was changed!');
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        toastr.error(xhr.responseJSON.message);
                    }
                });
        }

        function updateSlideClicked() {
                $("#slide-modal").modal("show");
                $("#create-slide-btn").hide();
                $("#update-slide-btn").show();
                
                var slideID = this.value;
                var title = document.getElementById("title-" + slideID).innerText;
                var link = $("#link-" + slideID + " img").attr('src');
                $("#slide-title").val(title);
                $("#slide-link").val(link);
                $("#update-slide-btn").attr("slide-id", slideID);
                $("#update-slide-btn").attr("slide-old-name", title);
        }

        function deleteSlideClicked() {
                $("#slide-delete-modal").modal("show");
                var slideID = this.value;  
                $("#delete-slide-btn").attr("slide-id", slideID);  
        }

        function createSlide() {
          var title = $("#slide-title").val();
          var link = "/storage/images/slides/" + title + ".png";
          var file_data = $('#slide-image-file').prop('files')[0];
          if(!file_data){
            toastr.error("Please choose a images!");
            return;
          }
          $.ajax({
                    type:'POST',
                    url: 'create-slide',
                    data:{
                      title:title,
                      link:link,
                    },
                    success: function (response) {
                        if(!response.error)
                        {
                            sendFileToServer(title, file_data);
                            toastr.success('Slide was created!');
                            $("#slide-title").val("");
                            $("#slide-link").val("");
                            $('#slide-image-file').val('');
                            $('#slide-image-preview').hide();
                            var slideID = response.data;
                            var htmlCreated = '<tr id="row-' + slideID +'"><td id="title-' + slideID + '">' + title + '</td><td id="link-' + slideID + '"><img src="' + link + '" alt="" width="200"></td><td><label class="switch"><input class="slide-status" onChange="changeSlideStatusClicked.call(this)" type="checkbox" checked id="' + slideID + '"><span class="slider round"></span></label></td><td><button type="button" class="btn btn-info slide-update-btn" onClick="updateSlideClicked.call(this)" value="' + slideID + '">Update</button><button type="button" class="btn btn-primary slide-delete-btn" onClick="deleteSlideClicked.call(this)" value="' + slideID + '">Delete</button></td></tr>';
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
        
        function updateSlide() {
          var title = $("#slide-title").val();
          var link = "/storage/images/slides/" + title + ".png"; 
          var slideID = $("#update-slide-btn").attr('slide-id');
          var oldName = $("#update-slide-btn").attr('slide-old-name');
          var file_data = $('#slide-image-file').prop('files')[0];
          if(!file_data){
            $.ajax({
                    type:'PUT',
                    url: 'update-slide',
                    data:{
                        id:slideID,
                        title:title,
                        link:link,
                    },
                    success: function (response) {
                        if(!response.error)
                        {
                            changeFileName(oldName, title);
                            toastr.success('Slide was changed!');
                            $("#title-" + slideID).html(title);
                            $("#link-" + slideID + " img").attr('src', link);
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
                    url: 'update-slide',
                    data:{
                        id:slideID,
                        title:title,
                        link:link,
                    },
                    success: function (response) {
                        if(!response.error)
                        {
                            sendFileToServer(title, file_data);
                            toastr.success('Slide was changed!');
                            $("#title-" + slideID).html(title);
                            $("#link-" + slideID + " img").attr('src', link);
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
          
        };

        function deleteSlide() {
            var slideID = $("#delete-slide-btn").attr('slide-id');
            $.ajax({
                    type:'DELETE',
                    url: 'delete-slide',
                    data:{
                      id:slideID,
                    },
                    success: function (response) {
                        $("#slide-delete-modal").modal("hide");
                        if(!response.error)
                        {
                          toastr.success('Slide was Deleted!');
                          $('#row-'+response.data).remove();
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $("#slide-delete-modal").modal("hide");
                        toastr.error(xhr.responseJSON.message);
                    }
            });
        };

        function readURL() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#slide-image-preview').attr('src', e.target.result).show();
                };
                reader.readAsDataURL(this.files[0]);
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
                    url: 'upload-slide-image',
                    dataType: 'text',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'POST',
                    success: function (response) {
                        if(!response.error){
                            toastr.success('Slide was changed!');
                            $('#slide-image-file').val('');
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        toastr.error(xhr.responseJSON.message);
                    }
                });
            } else {
                toastr.error("Not Image! Try again");
                $('#slide-image-file').val('');
            }
            return false;
        }

        function changeFileName(oldName, newName) {
                $.ajax({
                    url: 'change-slide-image-name',
                    data: {
                        oldName:oldName,
                        newName:newName
                    },
                    type: 'POST',
                    success: function (response) {
                        if(!response.error){
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        toastr.error(xhr.responseJSON.message);
                    }
                });
        }
    </script>
@endsection