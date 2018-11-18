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
                <th class="th-sm">Action
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr id="row-{{$category->id}}">
                    <td id="name-{{$category->id}}">{{$category->name}}</td>
                    <td id="desc-{{$category->id}}">{{$category->description}}</td>
                    <td id="admin-name-{{$category->id}}">{{$category->admin->username}}</td>
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
                    @if (session('error'))
                      <div class="alert alert-danger">
                        {{ session('error') }}
                      </div>
                    @endif
                    @if (session('success'))
                      <div class="alert alert-success">
                        {{ session('success') }}
                      </div>
                    @endif                     
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
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                      <button type="button" class="btn btn-primary" id="create-category-btn" onclick="createCategory()">Create</button>
                      <button type="button" class="btn btn-primary" category-id="" id="update-category-btn" onclick="updateCategory()">Update</button>
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

                $("#category-name").val("");
                $("#category-desc").val("");
            });

        });

        function updateCategoryClicked() {
                $("#category-modal").modal("show");
                $("#create-category-btn").hide();
                $("#update-category-btn").show();
                
                var categoryID = this.value;
                var name = document.getElementById("name-" + categoryID).innerText;
                var desc = document.getElementById("desc-" + categoryID).innerText;

                $("#category-name").val(name);
                $("#category-desc").val(desc);
                $("#update-category-btn").attr("category-id", categoryID);
        }

        function deleteCategoryClicked() {
              var categoryID = this.value;     
              $.ajax({
                    type:'DELETE',
                    url: 'delete-category',
                    data:{
                      id:categoryID,
                    },
                    success: function (response) {
                        if(!response.error)
                        {
                          toastr.success('Category was Deleted!');
                          $('#row-'+response.data).remove();
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        toastr.error(xhr.responseJSON.message);
                    }
              });
        }

        function createCategory() {
          var name = $("#category-name").val();
          if(name === "") {
            toastr.error("Name can not be empty!");
            return;
          }
          var desc = $("#category-desc").val();
          var adminID = {{ $currentAdmin->id }};
          var adminName = "{{ $currentAdmin->username }}";
          $.ajax({
                    type:'POST',
                    url: 'create-category',
                    data:{
                        name:name,
                        desc:desc,
                        adminID:adminID,
                    },
                    success: function (response) {
                        if(!response.error)
                        {
                            toastr.success('Category was created!');
                            $("#category-name").val("");
                            $("#category-desc").val("");

                            var categoryID = response.data;

                            var htmlCreated = '<tr id="row-' + categoryID +'"><td id="name-' + categoryID + '">' + name + '</td><td id="desc-' + categoryID + '">' + desc + '</td><td id="admin-name-' + categoryID + '">' + adminName + '</td><td><button type="button" class="btn btn-info category-update-btn" onClick="updateCategoryClicked.call(this)" value="' + categoryID + '">Update</button><button type="button" class="btn btn-primary category-delete-btn" onClick="deleteCategoryClicked.call(this)" value="' + categoryID + '">Delete</button></td></tr>';

                            $('#listtable tbody').append(htmlCreated);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        toastr.error(xhr.responseJSON.message);
                    }
          });
        };
        
        function updateCategory() {
          var name = $("#category-name").val();
          if(name === "") {
            toastr.error("Name can not be empty!");
            return;
          }
          var desc = $("#category-desc").val();
          var categoryID = $("#update-category-btn").attr('category-id');
          var adminID = {{ $currentAdmin->id }};
          var adminName = "{{ $currentAdmin->username }}";
          $.ajax({
                    type:'PUT',
                    url: 'update-category',
                    data:{
                        id:categoryID,
                        name:name,
                        desc:desc,
                        adminID:adminID,
                    },
                    success: function (response) {
                        if(!response.error)
                        {
                          console.log(response.data);
                            toastr.success('Category was changed!');
                            $("#name-" + categoryID).html(name);
                            $("#desc-" + categoryID).html(desc);
                            $("#admin-name-" + categoryID).html(adminName);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        toastr.error(xhr.responseJSON.message);
                    }
          });
        };
    </script>
@endsection
