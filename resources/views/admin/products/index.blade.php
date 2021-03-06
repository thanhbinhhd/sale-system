@extends('admin.layouts.master')
@section('customcss')
    <link rel="stylesheet" href="/admin/css/toggle-switch.css">
    <link rel="stylesheet" type="text/css" href="/admin/css/color-filter.css">
@endsection
@php ($currentAdmin = Auth::guard('admin')->user())
@section('pagename')
    Product Manager
    @if($currentAdmin->level == 1 or $currentAdmin->adminPermission->can_add)
        <a href="{{route('admin.product-manager.create')}}"><button type="button" class="btn btn-primary">Create New</button></a>
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
                <th class="th-sm">Name
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Creator
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Category
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Color
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Price
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
            @foreach($products as $product)
                <tr id="row-{{$product->id}}">
                    <td>{{$product->name}}</td>
                    <td>@if($product->creator!=null){{$product->creator->name}}@endif</td>
                    <td>@if($product->category!=null){{$product->category->name}}@endif</td>
                    <td>
                        @if( $product->productDetail != null)
                        <label class="color-filter color-filter{{$product->productDetail->color}}" ></label>
                        @endif
                    </td>
                    <td>{{$product->price}}</td>
                    <td>{{$product->created_at}}</td>
                    <td>
                        <select class="form-control product-status" data-id="{{$product->id}}">
                            <option value="1" @if($product->status == \App\Model\Product::ACTIVE) selected @endif >Active</option>
                            <option value="0" @if($product->status == \App\Model\Product::INACTIVE) selected @endif>Inactive</option>
                            <option value="2" @if($product->status == \App\Model\Product::REJECT) selected @endif>Reject</option>
                        </select>
                    </td>
                    <td>
                        <a href="{{route('admin.product-manager.edit', ['product_manager' => $product->id])}}" type="button" class="btn btn-info">Detail</a>
                        <button type="button" class="btn btn-danger" data-name="{{$product->name}}" data-id="{{$product->id}}" data-toggle="modal" data-target="#askDeleteModal">Delete</button>
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
                modal.find('#ModalMessage').text('Do you really want to delete product ' + name + ' from db?')
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
                url: '/admin/product-manager/' + id,
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
                        case 404: toastr.error("Product " + thrownError);
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

            $(".product-status").on("change",function () {
                var id = $(this).data('id');
                var status = $(this).val();
                $.ajax({
                    type:'PUT',
                    url: '/admin/update-product-status',
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
                        console.log(id);
                        switch (xhr.status) {
                            case 404: toastr.error("Product " + thrownError);
                                break;
                            default: toastr.error(xhr.responseJSON.message);
                        }
                    }
                });
            })
        });
    </script>
@endsection
