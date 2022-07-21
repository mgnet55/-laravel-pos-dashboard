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
    @lang('site.clients')
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

                @if(in_array('admins-create',$userPermissions))
                    <a class="btn btn-success"
                       href="{{route('dashboard.clients.create')}}">@lang('operations.create') <i
                            class="fa fa-plus"></i>
                    </a>
                @else
                    <button class="btn btn-success" disabled>@lang('operations.create')
                        <i class="fa fa-plus"></i>
                    </button>
                @endif
            </div>
        </form>
    </div>

    @if($clients->count())
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>@lang('fields.name')</th>
                <th>@lang('fields.email')</th>
                <th>@lang('fields.phone')</th>
                <th>@lang('fields.phone_alt')</th>
                <th>@lang('fields.address')</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($clients as $client)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $client->name }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->phone[0] }}</td>
                    <td>{{ $client->phone[1]??'' }}</td>
                    <td>{{ $client->address }}</td>
                    <td>
                        @if(in_array('admins-update',$userPermissions))
                            <a class="btn btn-info btn-sm"
                               href="{{route('dashboard.clients.edit',$client)}}">@lang('operations.edit') <i
                                    class="fa fa-edit"></i></a>
                        @else

                            <button class="btn btn-info btn-sm" disabled>@lang('operations.edit')
                                <i class="fa fa-edit"></i>
                            </button>
                        @endif

                        @if(in_array('admins-delete',$userPermissions))
                            <form action="{{ route('dashboard.clients.destroy',$client) }}"
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
    {{ $clients->withQueryString()->links() }}
@endsection
