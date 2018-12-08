@extends('admin.layouts.master')
@section('customcss')
    <link rel="stylesheet" href="/admin/css/toggle-switch.css">
    <link rel="stylesheet" type="text/css" href="/admin/css/color-filter.css">
@endsection
@php ($currentAdmin = Auth::guard('admin')->user())
@section('pagename')
    Slide Manager
    @if($currentAdmin->level == 1 or $currentAdmin->adminPermission->can_add)
        <a href="{{route('admin.slide-manager.create')}}"><button type="button" class="btn btn-primary">Create New</button></a>
    @endif
@endsection
@section('content')
    <div class="container">
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        <table id="listtable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th class="th-sm">Title
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Preview
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Created Date
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
                    <td>{{$slide->title}}</td>
                    <td>
                      <img src="{{$slide->link}}" width="200">
                    </td>
                    <td>{{$slide->created_at}}</td>
                    <td>
                        <select class="form-control slide-status" data-id="{{$slide->id}}">
                            <option value="1" @if($slide->status == \App\Model\Slide::ACTIVE) selected @endif >Active</option>
                            <option value="0" @if($slide->status == \App\Model\Slide::BLOCKED) selected @endif>Blocked</option>
                        </select>
                    </td>
                    <td>
                        <a href="{{route('admin.slide-manager.edit', ['slide_manager' => $slide->id])}}" type="button" class="btn btn-info">Detail</a>
                        <button type="button" class="btn btn-danger" data-name="{{$slide->title}}" data-id="{{$slide->id}}" data-toggle="modal" data-target="#askDeleteModal">Delete</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="askDeleteModal" tabindex="-1" role="dialog" aria-labelledby="askDeleteModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="askDeleteModal">Delete?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" ></span>
                    </button>
                </div>
                <div class="modal-body" id="ModalMessage">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="deleteAdmin(this.getAttribute('data-id'))" data-dismiss="modal">Delete</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('customscript')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#askDeleteModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var name = button.data('name');
                var id = button.data('id');
                var modal = $(this)
                modal.find('#ModalMessage').text("Do you really want to delete slide '" + name + "' from db?")
                modal.find('.btn-danger').attr('data-id', id)
            })
        })
        function deleteAdmin(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'post',
                url: '/admin/slide-manager/' + id,
                data:{
                    id:id,
                    _method: 'delete'
                },
                success: function (response) {
                    if(!response.error)
                    {
                        toastr.success('Deleted!');
                        $("#row-" + id).remove();
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    switch (xhr.status) {
                        case 404: toastr.error("Slide " + thrownError);
                            break;
                        default: toastr.error(xhr.responseJSON.message);
                    }
                }
            });
        }
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(".slide-status").on("change",function () {
                var id = $(this).data('id');
                var status = $(this).val();
                $.ajax({
                    type:'PUT',
                    url: '/admin/update-slide-status',
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
                        switch (xhr.status) {
                            case 404: toastr.error("Slide " + thrownError);
                                break;
                            default: toastr.error(xhr.responseJSON.message);
                        }
                    }
                });
            })
        });
    </script>
@endsection
