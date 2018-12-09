@extends('admin.layouts.master')
@section('customcss')
    <link rel="stylesheet" href="/admin/css/toggle-switch.css"/>
    <link rel="stylesheet" type="text/css" href="/admin/css/color-filter.css"/>
    <link rel="stylesheet" type="text/css" href="/admin/css/product.css"/>
    <link rel="stylesheet" href="/user/css/util.min.css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    <style>
        ul{
            list-style: none;
        }
        input[type="radio"]:checked+label{ border: solid; }
    </style>
@endsection
@section('pagename')
    Product Manager
@endsection
@section('content')
    <div class="container">
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-warning">{{ $error }}</div>
            @endforeach
        @endif
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        <div class="col-lg-6 col-sm-12 left">
            <table class="table" style="background: white;">
                <thead>
                <tr>
                    <th scope="col">Customer Information</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">Name</th>
                    <td>@if($order->creator!=null){{$order->creator->name}}@endif</td>
                    </tr>
                <tr>
                    <th scope="row">Order data</th>
                    <td>{{$order->created_at}}</td>
                </tr>
                <tr>
                    <th scope="row">Phone</th>
                    <td>@if($order->creator!=null){{$order->creator->phone_number}}@endif</td>
                </tr>
                <tr>
                    <th scope="row">Address</th>
                    <td>@if($order->creator!=null){{$order->creator->address}}@endif</td>
                </tr>
                <tr>
                    <th scope="row">Email</th>
                    <td>@if($order->creator!=null){{$order->creator->email}}@endif</td>
                </tr>
                <tr>
                    <th scope="row">Note</th>
                    <td>{{$order->note}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-lg-12 col-sm-12">
            <table class="table" style="background: white;">
                <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Cost</th>
                </tr>
                </thead>
                <tbody>
                @php $total = 0; setlocale(LC_MONETARY, 'en_US');@endphp
                @foreach($order->detail as $index=>$detail)
                    <tr>
                        <td>{{$index}}</td>
                        <td>{{$detail->product->name}}</td>
                        <td>{{$detail->quantity}}</td>
                        <td>{{money_format('%(#10n', $detail->total_price)}} VND</td>
                    </tr>
                    @php $total += $detail->total_price; @endphp
                @endforeach

                <tr>
                    <th colspan="3">Total</th>
                    <td style="color: red;font-weight: bold">{{money_format('%(#10n', $total)}} VND</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-lg-6 col-sm-12 left">
        </div>
        <div class="col-lg-6 col-sm-12 right">
            <div class="col-lg-12 col-sm-12">
                Delivery status
            </div>
            <div class="col-lg-6 col-sm-12 left">
            <select class="form-control" id="status" name="status">
                <option @if($order->status == \App\Model\Order::HANDLED) selected @endif value="{{\App\Model\Order::HANDLED}}">Completed</option>
                <option @if($order->status == \App\Model\Order::PENDING) selected @endif value="{{\App\Model\Order::PENDING}}">Pending</option>
            </select>
            </div>
            <div class="col-lg-6 col-sm-12 right">
            <button class="btn btn-info" id="change-status-button">Change status</button>
            </div>
        </div>
    </div>
@endsection
@section('customscript')
    <script type="text/javascript">

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#change-status-button").on("click",function () {
                var id = {{$order->id}};
                var status = $('#status').val();
                $.ajax({
                    type:'PUT',
                    url: '{{route('admin.order-manager.update', ['id' => $order->id])}}',
                    data:{
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
                            case 404: toastr.error("Order "  + thrownError);
                                break;
                            default: toastr.error(xhr.responseJSON.message);
                        }
                    }
                });
            });
        });

    </script>
@endsection
