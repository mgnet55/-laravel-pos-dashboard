@php
    $userPermissions = auth()->user()->permissions;
@endphp

@extends('layouts.dashboard')

@section('breadcrumb')
    <h1>@lang('site.products')</h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
        </li>
        <li class="active"> @lang('site.products')</li>
    </ol>
@endsection

@section('content-header')
    @lang('site.products')
@endsection

@section('content-body')
    <div class="row" style="margin-bottom: 15px">
        <form action="{{route('dashboard.products.index')}}" method="GET">

            <div class="col-md-4">
                <label for="search" class="sr-only"></label>
                <input type="text" id="search" name="search" class="form-control"
                       placeholder="@lang('operations.search')" value="{{request('search')}}">
            </div>
            <div class="col-md-4">
                <label for="search" class="sr-only"></label>
                <x-categories.dropdown :name="'category'"
                                       :selected="request('category')"></x-categories.dropdown>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">
                    @lang('operations.search')
                    <i class="fa fa-search"></i>
                </button>

                @if(in_array('products-create',$userPermissions))
                    <a class="btn btn-success"
                       href="{{route('dashboard.products.create')}}">@lang('operations.create') <i
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

    @if($products->count())
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>@lang('fields.image')</th>
                @foreach(LaravelLocalization::getSupportedLanguagesKeys() as $locale)
                    <th>@lang('fields.'.$locale.'.name')</th>
                @endforeach
                <th>@lang('fields.purchase_price')</th>
                <th>@lang('fields.sell_price')</th>
                <th>@lang('fields.stock')</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td><img src="{{ $product->image_path }}" alt="product image" width="64px" class="img-rounded"></td>
                    @foreach(LaravelLocalization::getSupportedLanguagesKeys() as $locale)
                        <td>{{$product->name[$locale]??''}}</td>
                    @endforeach
                    <td>{{$product->purchase_price}}</td>
                    <td>{{$product->sell_price}}</td>
                    <td>{{$product->stock}}</td>

                    <td>
                        @if(in_array('products-update',$userPermissions))
                            <a class="btn btn-info btn-sm"
                               href="{{route('dashboard.products.edit',$product)}}">@lang('operations.edit') <i
                                    class="fa fa-edit"></i></a>
                        @else

                            <button class="btn btn-info btn-sm" disabled>@lang('operations.edit')
                                <i class="fa fa-edit"></i>
                            </button>
                        @endif

                        @if(in_array('products-delete',$userPermissions))
                            <form action="{{ route('dashboard.products.destroy',$product) }}"
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
    {{ $products->withQueryString()->links() }}
@endsection
