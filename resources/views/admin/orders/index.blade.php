@extends('admin.layouts.master')
@section('customcss')
    <link rel="stylesheet" href="/admin/css/toggle-switch.css">
    <link rel="stylesheet" type="text/css" href="/admin/css/color-filter.css">
@endsection
@php ($currentAdmin = Auth::guard('admin')->user())
@section('pagename')
    Order Manager
@endsection
@section('content')
    <div class="container">
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        <table id="listtable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th class="th-sm">Order ID
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Username
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Address
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Order date
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Email
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
            @foreach($orders as $order)
                <tr id="row-{{$order->id}}">
                    <td>{{$order->id}}</td>
                    <td>@if($order->creator!=null){{$order->creator->name}}@endif</td>
                    <td>@if($order->creator!=null){{$order->creator->address}}@endif</td>
                    <td>{{$order->created_at}}</td>
                    <td>@if($order->creator!=null){{$order->creator->email}}@endif</td>
                    <td>{{($order->status == \App\Model\Order::HANDLED)?"Completed":"Pending"}}</td>
                    <td>
                        <a href="{{route('admin.order-manager.show', ['id' => $order->id])}}" type="button" class="btn btn-info">Detail</a>
                        <button type="button" class="btn btn-danger" data-name="@if($order->creator!=null){{$order->creator->name}}@endif" data-id="{{$order->id}}" data-toggle="modal" data-target="#askDeleteModal">Delete</button>
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
                    <button type="button" class="btn btn-danger" onclick="deleteOrder(this.getAttribute('data-id'))" data-dismiss="modal">Delete</button>
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
                modal.find('#ModalMessage').text('Do you really want to delete order ' + name + ' from db?')
                modal.find('.btn-danger').attr('data-id', id)
            })
        })
        function deleteOrder(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'delete',
                url: '/admin/order-manager/' + id,
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
                    console.log(xhr.status);
                    switch (xhr.status) {
                        case 404: toastr.error("order " + thrownError);
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
        });
    </script>
@endsection
