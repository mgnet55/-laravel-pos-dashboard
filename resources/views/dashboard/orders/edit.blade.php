@extends('layouts.dashboard')

@section('breadcrumb')
    <h1>@lang('site.clients')</h1>

    <ol class="breadcrumb">
        <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')
            </a>
        </li>
        <li><a href="{{route('dashboard.users.index')}}">@lang('site.clients')</a>
        <li class="active"> @lang('operations.update')</li>
    </ol>
@endsection

@section('content-header')
    @lang('operations.update')
@endsection

@section('content-body')
    <!-- /.box-header -->
    @include('partials._errors')
    <!-- form start -->
    <form role="form" method="post" action="{{route('dashboard.clients.update',$client)}}">
        @csrf
        @method('PATCH')
        <div class="box-body">

            <div class="form-group">
                <label for="name">@lang('fields.name')</label>
                <input name="name" type="text" class="form-control" id="name"
                       value="{{ old('name',$client->name) }}"
                       placeholder="@lang('fields.name')">
            </div>

            <div class="form-group">
                <label for="email">@lang('fields.email')</label>
                <input name="email" type="email" class="form-control" id="email"
                       value="{{ old('email',$client->email) }}"
                       placeholder="@lang('fields.email')">
            </div>

            <div class="form-group">
                <label for="address">@lang('fields.address')</label>
                <input name="address" type="text" class="form-control" id="address"
                       value="{{ old('address',$client->address) }}"
                       placeholder="@lang('fields.address')">
            </div>

            <div class="form-group">
                <label for="phone">@lang('fields.phone')</label>
                <input name="phone[]" type="tel" class="form-control" id="phone"
                       value="{{ old('phone.0',$client->phone[0])  }}"
                       placeholder="@lang('fields.phone')">
            </div>

            <div class="form-group">
                <label for="phone">@lang('fields.phone_alt')</label>
                <input name="phone[]" type="tel" class="form-control" id="phone"
                       value="{{ old('phone.1',$client->phone[1])  }}"
                       placeholder="@lang('fields.phone_alt')">
            </div>


        </div>

        {{-- Persmissions--}}
        <button type="submit" class="btn btn-primary">@lang('operations.update')</button>

    </form>

@endsection

@section('js')
    <script src="{{asset('assets/js/custom.js')}}"></script>
@endsection
