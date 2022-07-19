@php
    $userPermissions = auth()->user()->permissions;
@endphp

@extends('layouts.dashboard')

@section('breadcrumb')
    <h1>@lang('site.admins')</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
        </li>
        <li class="active"> @lang('site.admins')</li>
    </ol>
@endsection

@section('content-header')
    @lang('site.admins')
@endsection

@section('content-body')
    <div class="row" style="margin-bottom: 15px">
        <form action="{{route('dashboard.users.index')}}" method="GET">

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
                       href="{{route('dashboard.users.create')}}">@lang('operations.create') <i
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

    @if($users->count())
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>@lang('fields.image')</th>
                <th>@lang('fields.first_name')</th>
                <th>@lang('fields.last_name')</th>
                <th>@lang('fields.email')</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td><img src="{{ $user->image_path }}" alt="profile image" width="64px" class="img-rounded"></td>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if(in_array('admins-update',$userPermissions))
                            <a class="btn btn-info btn-sm"
                               href="{{route('dashboard.users.edit',$user)}}">@lang('operations.edit') <i
                                    class="fa fa-edit"></i></a>
                        @else

                            <button class="btn btn-info btn-sm" disabled>@lang('operations.edit')
                                <i class="fa fa-edit"></i>
                            </button>
                        @endif

                        @if(in_array('admins-delete',$userPermissions))
                            <form action="{{ route('dashboard.users.destroy',$user) }}"
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
    {{ $users->withQueryString()->links() }}
@endsection
