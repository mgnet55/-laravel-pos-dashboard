@extends('layouts.dashboard')

@section('breadcrumb')
    <h1>@lang('site.admins')</h1>

    <ol class="breadcrumb">
        <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')
            </a>
        </li>
        <li><a href="{{route('dashboard.users.index')}}">@lang('site.admins')</a>
        <li class="active"> @lang('operations.edit')</li>
    </ol>
@endsection

@section('content-header')
    @lang('operations.edit')
@endsection

@section('content-body')
    <!-- /.box-header -->
    @include('partials._errors')
    <!-- form start -->
    <form role="form" method="post" action="{{route('dashboard.categories.update',$category)}}">
        @csrf
        @method('PATCH')
        <div class="box-body">

            @foreach(LaravelLocalization::getSupportedLanguagesKeys() as $locale)
                <div class="form-group">
                    <label for="name">@lang('fields.'.$locale.'.name')</label>
                    <input name="name[{{$locale}}]" type="text" class="form-control" id="name" required
                           value="{{ old('name['.$locale.']',$category->name[$locale]) }}"
                           placeholder="@lang('fields.'.$locale.'.name')">
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary">@lang('operations.update')</button>

        </div>


    </form>

@endsection
