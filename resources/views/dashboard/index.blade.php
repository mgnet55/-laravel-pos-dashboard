@extends('layouts.dashboard')

@section('content')
    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.dashboard')</h1>

            <ol class="breadcrumb">
                <li class="active"><a href="{{route('dashboard.index')}}"><i
                            class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
            </ol>
        </section>

        <section class="content">

            <h1>This is Dashboard</h1>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
