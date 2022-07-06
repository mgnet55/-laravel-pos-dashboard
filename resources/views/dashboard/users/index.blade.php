@extends('layouts.dashboard')

@section('content')
    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.admins')</h1>

            <ol class="breadcrumb">
                <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a>
                </li>
                <li class="active"> @lang('site.admins')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title mb-3">@lang('site.admins')</h3>
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="name" id="name" class="form-control"
                                       placeholder="@lang('operations.search')">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">
                                    @lang('operations.search') <i class="fa fa-search"></i>
                                </button>
                                <a class="btn btn-success"
                                   href="{{route('dashboard.users.create')}}">@lang('operations.add') <i
                                        class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.box-header -->
                {{-- Start Table --}}
                @if($users->count())
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
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
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <a href="{{ route('dashboard.users.edit',$user->id)}}" class="btn btn-info btn-sm">
                                        @lang('operations.edit') <i class="fa fa-edit"></i>
                                    </a>
                                    <form style="display: inline-block"
                                          action="{{ route('dashboard.users.destroy',$user->id) }}"
                                          method="post">
                                        @csrf
                                        @method('delete')

                                        <button type="submit" class="btn btn-danger btn-sm">
                                            @lang('operations.delete') <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <h2>@lang('messages.no_data')</h2>
                @endif
                {{-- End Table --}}
            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
