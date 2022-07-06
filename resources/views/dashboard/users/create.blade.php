@extends('layouts.dashboard')

@section('content')
    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.admins')</h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li><a href="{{route('dashboard.users.index')}}">@lang('site.admins')</a>
                <li class="active"> @lang('operations.add')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('operations.add')</h3>
                </div>
                <!-- /.box-header -->
                @include('partials._errors')
                <!-- form start -->
                <form role="form" method="post" action="{{route('dashboard.users.store')}}">
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="email">@lang('fields.email')</label>
                            <input name="email" type="email" class="form-control" id="email"
                                   value="{{ old('email') }}"
                                   placeholder="@lang('fields.email')">
                        </div>
                        <div class="form-group">
                            <label for="first_name">@lang('fields.first_name')</label>
                            <input name="first_name" type="text" class="form-control" id="first_name"
                                   value="{{ old('first_name') }}"
                                   placeholder="@lang('fields.first_name')">
                        </div>
                        <div class="form-group">
                            <label for="last_name">@lang('fields.last_name')</label>
                            <input name="last_name" type="text" class="form-control" id="last_name"
                                   value="{{ old('last_name') }}"
                                   placeholder="@lang('fields.last_name')">
                        </div>
                        <div class="form-group">
                            <label for="password">@lang('fields.password')</label>
                            <input name="password" type="password" class="form-control" id="password"
                                   placeholder="@lang('fields.password')">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">@lang('fields.password_confirmation')</label>
                            <input name="password_confirmation" type="password" class="form-control"
                                   id="password_confirmation"
                                   placeholder="@lang('fields.password_confirmation')">
                        </div>

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
