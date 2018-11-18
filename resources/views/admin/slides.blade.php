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
                            <input type="text" class="form-control" id="slide-link" placeholder="Enter Slide Link">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="create-slide-btn" onclick="createSlide()">Create</button>
                    <button type="button" class="btn btn-primary" slide-id="" id="update-slide-btn" onclick="updateSlide()">Update</button>
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
                $("#slide-title").val("");
                $("#slide-link").val("");
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
        }

        function deleteSlideClicked() {
                $("#slide-delete-modal").modal("show");
                var slideID = this.value;  
                $("#delete-slide-btn").attr("slide-id", slideID);  
        }

        function createSlide() {
          var title = $("#slide-title").val();
          var link = $("#slide-link").val();
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
                            toastr.success('Slide was created!');
                            $("#slide-title").val("");
                            $("#slide-link").val("");
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
          var link = $("#slide-link").val();
          var slideID = $("#update-slide-btn").attr('slide-id');
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
                          console.log(response.data);
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
    </script>
@endsection