@php
    $userPermissions = auth()->user()->permissions;
@endphp

@extends('layouts.dashboard')

@section('breadcrumb')
    <h1>@lang('site.clients')</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
        <li> @lang('site.clients')</li>
        <li class="active"> @lang('site.orders')</li>
    </ol>
@endsection

@section('content-header')
    @lang('site.orders')
@endsection

@section('content-body')

    <div class="row" style="margin-bottom: 15px">
        <form action="{{route('dashboard.clients.index')}}" method="GET">

            <div class="col-md-4">
                <label for="search" class="sr-only"></label>
                <input type="text" id="search" name="search" class="form-control"
                       placeholder="@lang('operations.search')" value="{{request('search')}}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">
                    @lang('operations.search')
                    <i class="fa fa-search"></i>
                </button>

                {{--                @if(in_array('orders-create',$userPermissions))--}}
                <a class="btn btn-success"
                   href="{{route('dashboard.clients.orders.create',$client)}}">@lang('operations.add_order') <i
                        class="fa fa-plus"></i>
                </a>
                {{--@else
                    <button class="btn btn-success" disabled>@lang('operations.create')
                        <i class="fa fa-plus"></i>
                    </button>
                @endif--}}
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="info-box">
                <div class="info-box-content">
                    <span class="info-box-text">@lang('fields.name')</span>
                    <span class="info-box-number">{{$client->name}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box">
                <div class="info-box-content">
                    <span class="info-box-text">@lang('fields.address')</span>
                    <span class="info-box-number">{{$client->address}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box">
                <div class="info-box-content">
                    <span class="info-box-text">@lang('fields.phone')</span>
                    <span class="info-box-number">{{$client->phone[0]}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box">
                <div class="info-box-content">
                    <span class="info-box-text">@lang('fields.phone_alt')</span>
                    <span class="info-box-number">{{$client->phone[1]}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>

    </div>
    @if($orders->count())
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>@lang('fields.date')</th>
                <th>@lang('fields.total')</th>
                <th>@lang('fields.quantity')</th>
                <th>@lang('fields.status')</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>{{ $order->total_price }}</td>
                    <td>{{ $order->total_products }}</td>
                    <td>{{ $order->status }}</td>
                    <td>
                        <a class="btn btn-default btn-sm"
                           href="{{route('dashboard.clients.orders.show',[$client,$order])}}">@lang('site.order_details')
                            <i
                                class="fa fa-tags"></i></a>
                        @if(in_array('admins-update',$userPermissions))
                            <a class="btn btn-info btn-sm"
                               href="{{route('dashboard.clients.orders.edit',[$client,$order])}}">@lang('operations.edit')
                                <i
                                    class="fa fa-edit"></i></a>
                        @else

                            <button class="btn btn-info btn-sm" disabled>@lang('operations.edit')
                                <i class="fa fa-edit"></i>
                            </button>
                        @endif

                        @if(in_array('admins-delete',$userPermissions))
                            <form action="{{ route('dashboard.clients.orders.destroy',[$client,$order]) }}"
                                  method="post"
                                  style="display: inline-block">
                                @csrf
                                @method('delete')

                                <button type="submit" class="btn btn-danger btn-sm delete">
                                    @lang('operations.delete') <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        @else
                            <button class="btn btn-danger btn-sm" disabled>@lang('operations.delete') <i
                                    class="fa fa-trash"></i>
                            </button>
                        @endif


                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <h3>@lang('messages.no_data')</h3>
    @endif
@endsection

