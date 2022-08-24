@extends('layouts.dashboard')

@section('breadcrumb')
    <h1>@lang('site.order_details')</h1>

    <ol class="breadcrumb">
        <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')
            </a>
        </li>
        <li><a href="{{route('dashboard.clients.index')}}">@lang('site.clients')</a>
        <li><a href="{{route('dashboard.clients.orders.index',$order->client)}}">@lang('site.orders')</a>
        <li class="active"> @lang('operations.create')</li>
    </ol>
@endsection


@section('content-body')
    {{--<div class="row">

        Client information section
        <div class="col-md-4">
            <div class="box box-default">
                Content Header
                <div class="box-header with-border">
                    <h3 class="box-title mb-3">
                        @lang('site.client')
                    </h3>
                </div>
                <div class="box-body">

                    <div class="info-box">
                        <div class="info-box-content">
                            <span class="info-box-text">@lang('fields.name')</span>
                            <span class="info-box-number">{{$order->client->name}}</span>
                        </div>
                    </div>

                    <div class="info-box">
                        <div class="info-box-content">
                            <span class="info-box-text">@lang('fields.address')</span>
                            <span class="info-box-number">{{$order->client->address}}</span>
                        </div>
                    </div>
                    <div class="info-box">
                        <div class="info-box-content">
                            <span class="info-box-text">@lang('fields.phone')</span>
                            <span class="info-box-number">{{$order->client->phone[0]}}</span>
                        </div>
                    </div>
                    <div class="info-box">
                        <div class="info-box-content">
                            <span class="info-box-text">@lang('fields.phone_alt')</span>
                            <span class="info-box-number">{{$order->client->phone[1]}}</span>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        Order Items Section
        <div class="col-md-8">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title mb-3">
                        @lang('site.products')
                    </h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('fields.name')</th>
                            <th>@lang('fields.price')</th>
                            <th>@lang('fields.quantity')</th>
                            <th>@lang('fields.total')</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->products as $product)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $product->localized_name }}</td>
                                <td>{{ $product->pivot->unit_price }}</td>
                                <td>{{ $product->pivot->quantity }}</td>
                                <td>{{ $product->pivot->total_price }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>--}}
    <!-- /.box-header -->

    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> {{config('app.name')}}.
                    <small class="pull-right">Date:
                        <script>document.write(new Date().toLocaleDateString())</script>
                    </small>
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                From
                <address>
                    <strong>Admin, Inc.</strong><br>
                    795 Folsom Ave, Suite 600<br>
                    San Francisco, CA 94107<br>
                    Phone: (804) 123-5432<br>
                    Email: info@almasaeedstudio.com
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                To
                <address>
                    <strong>{{ $order->client->name }}John Doe</strong><br>
                    {{ $order->client->address }}795 Folsom Ave, Suite 600<br>
                    Phone: {{ $order->client->phone[0] }}<br>
                    Phone-Alt: {{ $order->client->phone[1] }}<br>
                    Email: {{ $order->client->email }}
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <b>Invoice #000000</b><br>
                <br>
                <b>Order ID:</b> {{$order->id}}<br>
                <b>Issued By:</b> {{auth()->user()->name}}
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>@lang('fields.name')</th>
                        <th>@lang('fields.unit_price')</th>
                        <th>@lang('fields.quantity')</th>
                        <th>@lang('fields.price')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->products as $product)
                        <tr>
                            <td>{{$loop->index}}</td>
                            <td>{{$product->localized_name}}</td>
                            <td>${{$product->pivot->unit_price}}</td>
                            <td>{{$product->pivot->quantity}}</td>
                            <td>${{$product->pivot->total_price}}</td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">
                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                    plugg
                    dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                </p>
            </div>
            <!-- /.col -->
            <div class="col-xs-6">
                <p class="lead">Amount Due 2/22/2014</p>

                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th style="width:50%">Subtotal:</th>
                            <td>${{$order->total_price}}</td>
                        </tr>
                        <tr>
                            <th>Tax (0%)</th>
                            <td>$ 0</td>
                        </tr>
                        <tr>
                            <th>Shipping:</th>
                            <td>$ 0</td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td>${{$order->total_price}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- this row will not appear when printing -->
        <div class="row no-print">
            <div class="col-xs-12">
                <a href="invoice-print.html" target="_blank" class="btn btn-default pull-right"><i
                        class="fa fa-print"></i>Print</a>
                <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit
                    Payment
                </button>
                <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                    <i class="fa fa-download"></i> Generate PDF
                </button>
                <form action="{{ route('dashboard.orders.destroy',$order) }}"
                      method="post"
                      style="display: inline-block">
                    @csrf
                    @method('delete')

                    <button type="submit" class="btn btn-danger pull-right" style="margin-right: 5px;">
                        @lang('operations.delete') <i class="fa fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </section>

    @include('partials._errors')

@endsection

@section('js')
    <script src="{{asset('assets/js/custom.js')}}"></script>
@endsection

