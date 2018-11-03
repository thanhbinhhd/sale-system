@extends('admin.layouts.master')
@section('customcss')
    <link rel="stylesheet" href="/admin/css/toggle-switch.css">
    @endsection
@section('pagename')
User Manager
@endsection
@section('content')
    <div class="container">
        <table id="listtable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th class="th-sm">Name
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Email
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Phone
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Address
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
            @foreach($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->phone_number}}</td>
                    <td>{{$user->address}}</td>
                    <td>
                        <label class="switch">
                            <input class="user-status" type="checkbox" @if ($user->status == 1) checked @endif id="{{$user->id}}">
                            <span class="slider round"></span>
                        </label>
                    </td>
                    <td>
                        <a href=""><button type="button" class="btn btn-info">Info</button>
                        </a>
                        <a href=""><button type="button" class="btn btn-primary">Order</button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
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

            $(".user-status").on("change",function () {
                var id = $(this).attr('id');
                var status = ($(this).is(':checked')==1) ? 1 : 0;
                $.ajax({
                    type:'PUT',
                    url: 'update-status',
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
            })
        });
    </script>
@endsection
