@php
    $userPermissions = auth()->user()->permissions;
@endphp

@extends('layouts.dashboard')

@section('breadcrumb')
    <h1>@lang('site.categories')</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
        </li>
        <li class="active"> @lang('site.categories')</li>
    </ol>
@endsection

@section('content-header')
    @lang('site.categories')
@endsection

@section('content-body')
    <div class="row" style="margin-bottom: 15px">
        <form action="{{route('dashboard.categories.index')}}" method="GET">

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

                @if(in_array('categories-create',$userPermissions))
                    <a class="btn btn-success"
                       href="{{route('dashboard.categories.create')}}">@lang('operations.create') <i
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

    @if($categories->count())
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                @foreach(LaravelLocalization::getSupportedLanguagesKeys() as $locale)
                    <th>@lang('fields.'.$locale.'.name')</th>
                @endforeach
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    @foreach(LaravelLocalization::getSupportedLanguagesKeys() as $locale)
                        <td>{{$category->name[$locale]??''}}</td>
                    @endforeach
                    <td>
                        <a class="btn btn-success btn-sm {{in_array('products-read',$userPermissions)? '': 'disabled'}}"
                           href="{{ route('dashboard.products.index',['category'=>$category->id]) }}">@lang('site.products')
                            <i class=" fa fa-tags"></i>
                        </a>
                        
                        @if(in_array('categories-update',$userPermissions))
                            <a class="btn btn-info btn-sm"
                               href="{{route('dashboard.categories.edit',$category)}}">@lang('operations.edit') <i
                                    class="fa fa-edit"></i></a>
                        @else

                            <button class="btn btn-info btn-sm" disabled>@lang('operations.edit')
                                <i class="fa fa-edit"></i>
                            </button>
                        @endif

                        @if(in_array('categories-delete',$userPermissions))
                            <form action="{{ route('dashboard.categories.destroy',$category) }}"
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
    {{ $categories->withQueryString()->links() }}
@endsection
