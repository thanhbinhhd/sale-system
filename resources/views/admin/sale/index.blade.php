@extends('admin.layouts.master')
@section('customcss')
    <link rel="stylesheet" href="/admin/css/toggle-switch.css">
    <link rel="stylesheet" type="text/css" href="/admin/css/color-filter.css">
@endsection
@php ($currentAdmin = Auth::guard('admin')->user())
@section('pagename')
    Sale-off Manager
    @if($currentAdmin->level == 1 or $currentAdmin->adminPermission->can_add)
        <a href="{{route('admin.sale-manager.create')}}"><button type="button" class="btn btn-primary">Create New</button></a>
    @endif
@endsection
@section('content')
    <div class="container">
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        <h2>Current sale-off</h2>
        <table id="listtable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th class="th-sm">Product
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Promo Code
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Promo
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Type
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Description
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">Start date
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
                <th class="th-sm">End date
                    <i class="fa fa-sort float-right" aria-hidden="true"></i>
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td>{{$sale->product->name}}</td>
                    <td>{{$sale->promo_code}}</td>
                    <td>{{$sale->promo}}</td>
                    <td>{{($sale->type)?"Public":"Private"}}</td>
                    <td>{{$sale->description}}</td>
                    <td>{{$sale->start_date}}</td>
                    <td>{{$sale->end_date}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection

@section('customscript')
@endsection
