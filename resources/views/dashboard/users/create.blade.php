@extends('layouts.dashboard')

@section('breadcrumb')
    <h1>@lang('site.admins')</h1>

    <ol class="breadcrumb">
        <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')
            </a>
        </li>
        <li><a href="{{route('dashboard.users.index')}}">@lang('site.admins')</a>
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
    <form role="form" method="post" action="{{route('dashboard.users.store')}}" enctype="multipart/form-data">
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
                <label for="image">@lang('fields.image')</label>
                <input name="image" type="file" class="form-control" id="image"
                       onchange="readURL(this);"
                       accept="image/gif, image/jpeg, image/png" placeholder="@lang('fields.image')">
                <img id="imagePreview" src="data:," alt="Image Preview" onerror="this.style.display='none'"
                     class="img-thumbnail">

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

            <div class="form-group">
                <label for="">@lang('site.permissions')</label>

                <div class="nav-tabs-custom">
                    {{--    Tabs Header     --}}
                    <ul class="nav nav-tabs">
                        @foreach($models as $model)
                            <li class="{{$loop->first?'active':''}}"><a href="#{{$model}}"
                                                                        data-toggle="tab">@lang('site.'.$model)</a>
                            </li>
                        @endforeach
                    </ul>
                    {{--    Tabs Body Content     --}}

                    <div class="tab-content">
                        @foreach($models as $model)

                            <div class="tab-pane {{$loop->first?'active':''}}" id="{{$model}}">
                                @foreach($permissions as $permission)
                                    <label class="mx-5">
                                        @lang('operations.'.$permission)
                                        <input name="permissions[]" value="{{$model.'-'.$permission}}"
                                               type="checkbox">
                                    </label>
                                @endforeach

                            </div>

                        @endforeach
                    </div>
                </div>
            </div>
            {{-- End Permissions  --}}
        </div>

        {{-- Persmissions--}}
        <button type="submit" class="btn btn-primary">Submit</button>

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
