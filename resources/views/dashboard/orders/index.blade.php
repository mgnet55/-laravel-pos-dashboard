@php
    $userPermissions = auth()->user()->permissions;
@endphp

@extends('layouts.dashboard')

@section('breadcrumb')
    <h1>@lang('site.clients')</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
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

            </div>
        </form>
    </div>

    @if($orders->count())
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>@lang('fields.name')</th>
                <th>@lang('fields.date')</th>
                <th>@lang('fields.total')</th>
                <th>@lang('fields.quantity')</th>
                <th>@lang('fields.status')</th>
                <th>@lang('fields.products')</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $order->client->name }}</td>
                    <td>{{ $order->created_at->diffForHumans() }}</td>
                    <td>{{ $order->total_price }}</td>
                    <td>{{ $order->total_products }}</td>
                    <td>{{ $order->status }}</td>
                    <td><a class="btn btn-default btn-sm"
                           href="{{route('dashboard.orders.show',$order)}}">@lang('site.products') <i
                                class="fa fa-tags"></i></a></td>
                    <td>
                        @if(in_array('orders-update',$userPermissions))
                            <a class="btn btn-info btn-sm"
                               href="{{route('dashboard.orders.edit',$order)}}">@lang('operations.edit') <i
                                    class="fa fa-edit"></i></a>
                        @else

                            <button class="btn btn-info btn-sm" disabled>@lang('operations.edit')
                                <i class="fa fa-edit"></i>
                            </button>
                        @endif

                        @if(in_array('orders-delete',$userPermissions))
                            <form action="{{ route('dashboard.orders.destroy',$order) }}"
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
@section('content-footer')
    {{ $orders->withQueryString()->links() }}
@endsection

