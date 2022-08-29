@extends('layouts.dashboard')


@section('breadcrumb')
    <h1>@lang('site.orders')</h1>

    <ol class="breadcrumb">
        <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')
            </a>
        </li>
        <li><a href="{{route('dashboard.clients.index')}}">@lang('site.clients')</a>
        <li><a href="{{route('dashboard.clients.orders.index',$order->client)}}">@lang('site.orders')</a>
        <li class="active"> @lang('operations.create')</li>
    </ol>
@endsection

@section('content-header')
    @lang('operations.edit_order') #{{$order->id}} ,Issued : {{$order->created_at}}
@endsection

@section('content-body')

    <!-- /.box-header -->
    @include('partials._errors')

@endsection
@section('content-footer')
    @php
        $order_products_ids = $order->products->pluck('id')->toArray()
    @endphp
    <div class="row">

        {{--Products Section --}}
        <div class="col-md-6">
            <div class="box box-default">
                {{--Content Header--}}
                <div class="box-header with-border">
                    <h3 class="box-title mb-3">
                        @lang('site.categories')
                    </h3>
                </div>
                <div class="box-body">

                    @foreach ($categories as $category)
                        @if($category->products)
                            <div class="panel-group">

                                <div class="panel panel-info">

                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse"
                                               href="#category-{{$category->id}}">{{ $category->name[app()->getLocale()] }}</a>
                                        </h4>
                                    </div>

                                    <div id="category-{{$category->id}}" class="panel-collapse collapse">

                                        <div class="panel-body">

                                            @if ($category->products->count() > 0)

                                                <table class="table table-hover">
                                                    <tr>
                                                        <th>@lang('fields.name')</th>
                                                        <th>@lang('fields.stock')</th>
                                                        <th>@lang('fields.price')</th>
                                                        <th>@lang('operations.add')</th>
                                                    </tr>

                                                    @foreach ($category->products as $product)
                                                        <tr>
                                                            <td>{{ $product->localized_name }}</td>
                                                            <td>{{ $product->stock }}</td>
                                                            <td>{{ $product->sell_price }}</td>
                                                            <td>
                                                                <a href="#"
                                                                   id="product-{{ $product->id }}"
                                                                   data-name="{{ $product->localized_name }}"
                                                                   data-id="{{ $product->id }}"
                                                                   data-price="{{ $product->sell_price }}"
                                                                   data-stock="{{ $product->stock }}"
                                                                    @class([
                                                                        'btn btn-success btn-sm add-product-btn',
                                                                        'disabled'=>in_array($product->id,$order_products_ids)])>
                                                                    <i class="fa fa-plus"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </table><!-- end of table -->

                                            @else
                                                <h5>@lang('site.no_records')</h5>
                                            @endif

                                        </div><!-- end of panel body -->

                                    </div><!-- end of panel collapse -->

                                </div><!-- end of panel primary -->

                            </div><!-- end of panel group -->
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        {{--Order Items Section--}}
        <div class="col-md-6">
            <div class="box box-default">
                {{--Content Header--}}

                <div class="box-body">
                    {{--Client information section--}}
                    <div class="box box-widget widget-user">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-aqua-active">
                            <h3 class="widget-user-username">{{$order->client->name}}</h3>
                            <h5 class="widget-user-desc"><i class="fa fa-envelope"></i> {{$order->client->email}}</h5>
                            <h5 class="widget-user-desc"><i class="fa fa-map-marker"></i> {{$order->client->address}}
                            </h5>
                            <h5 class="widget-user-desc">
                                <i class="fa fa-phone"></i> {{$order->client->phone[0]}},
                                <i class="fa fa-phone"></i> {{$order->client->phone[1]}}
                            </h5>
                        </div>
                    </div>

                    {{--Order items Section--}}
                    <form action="{{ route('dashboard.orders.update', $order->id) }}" method="post">

                        @method('PUT')
                        @csrf

                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>@lang('site.product')</th>
                                <th>@lang('fields.quantity')</th>
                                <th>@lang('fields.price')</th>
                                <th>@lang('fields.total')</th>
                                <th></th>
                            </tr>
                            </thead>

                            <tbody class="order-list">
                            @foreach($order->products as $product)
                                <tr>
                                    <td>{{$product->localized_name}}</td>
                                    <td><input type="number" step="1" min="1"
                                               max="{{$product->stock+ $product->pivot->quantity}}" value={{$product->pivot->quantity}}
                                               name="products[{{$product->id}}]"
                                               class="form-control input-sm order-item"
                                               data-price="{{$product->sell_price}}"></td>
                                    <td>{{$product->sell_price}}</td>
                                    <td class="total-price">{{$product->sell_price*$product->pivot->quantity}}</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger remove-product-btn"
                                                data-id="product-{{$product->id}}"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>

                        </table><!-- end of table -->

                        <h4>@lang('fields.total') : <span id="total_order_cost">{{$order->total_price}}</span></h4>

                        <button class="btn btn-primary btn-block" id="add-order-form-btn"><i
                                class="fa fa-floppy-o"></i> @lang('operations.update')</button>

                    </form>

                </div>
            </div>
        </div>

    </div>

@endsection

@section('js')
    <script src="{{asset('assets/js/custom.js')}}"></script>
@endsection
0
