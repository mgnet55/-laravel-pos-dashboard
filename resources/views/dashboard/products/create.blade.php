@extends('layouts.dashboard')

@section('breadcrumb')
    <h1>@lang('site.products')</h1>

    <ol class="breadcrumb">
        <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')
            </a>
        </li>
        <li><a href="{{route('dashboard.products.index')}}">@lang('site.products')</a>
        <li class="active"> @lang('operations.create')</li>
    </ol>
@endsection

@section('content-header')
    @lang('operations.create')
@endsection

@section('content-body')
    <!-- /.box-header -->
    @include('partials._errors')
    <!-- form start -->
    <form role="form" method="post" action="{{route('dashboard.products.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="box-body">
            @foreach(LaravelLocalization::getSupportedLanguagesKeys() as $locale)
                <div class="form-group">
                    <label for="name">@lang('fields.'.$locale.'.name')</label>
                    <input name="name[{{$locale}}]" type="text" class="form-control" id="name" required
                           value="{{ old('name.'.$locale) }}" placeholder="@lang('fields.'.$locale.'.name')">
                </div>

                <div class="form-group">
                    <label for="description">@lang('fields.'.$locale.'.description')</label>
                    <textarea name="description[{{$locale}}]" type="text" class="form-control" id="description" required
                              placeholder="@lang('fields.'.$locale.'.description')">{{ old('description.'.$locale) }}</textarea>
                </div>
            @endforeach

            <div class="form-group">
                <label for="image">@lang('fields.image')</label>
                <input name="image" type="file" class="form-control" id="image"
                       onchange="readURL(this);"
                       accept="image/gif, image/jpeg, image/png" placeholder="@lang('fields.image')">
                <img id="imagePreview" src="data:," alt="Image Preview" height="50" onerror="this.style.display='none'"
                     class="img-thumbnail">

            </div>

            <div class="form-group">
                <label for="purchase_price">@lang('fields.purchase_price')</label>
                <input name="purchase_price" type="number" step="0.5" min="1" class="form-control" id="purchase_price"
                       required
                       value="{{ old('purchase_price') }}" placeholder="@lang('fields.purchase_price')">
            </div>

            <div class="form-group">
                <label for="sell_price">@lang('fields.sell_price')</label>
                <input name="sell_price" type="number" step="0.5" min="1" class="form-control" id="sell_price" required
                       value="{{ old('sell_price') }}" placeholder="@lang('fields.sell_price')">
            </div>

            <div class="form-group">
                <label for="stock">@lang('fields.stock')</label>
                <input name="stock" type="number" step="1" class="form-control" id="stock" required
                       value="{{ old('stock') }}" placeholder="@lang('fields.stock')">
            </div>

            <div class="form-group">
                <label for="category_id">@lang('fields.category')</label>
                <x-categories.dropdown :name="'category_id'"
                                       :selected="old('category_id')"></x-categories.dropdown>
            </div>


            <button type="submit" class="btn btn-primary">@lang('operations.create')</button>

        </div>


    </form>

@endsection
@section('js')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#imagePreview').attr('src', e.target.result).height(150).show('fast', 'swing');
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
