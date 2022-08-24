<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientOrderRequest;
use App\Http\Requests\UpdateClientOrderRequest;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;

class ClientOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Client $client)
    {
        $orders = $client->orders()->latest()->with('products',)->get();
        $orders->append(['total_price', 'total_products']);

        return view('dashboard.clients.orders.index', compact('orders', 'client'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Client $client)
    {
        $categories = Category::with('products')->get();

        return view('dashboard.clients.orders.create', compact('client', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreClientOrderRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Client $client, StoreClientOrderRequest $request)
    {
        $order_products = $request->validated('products');
        $products = Product::find(array_keys($order_products));

        \DB::beginTransaction();

        try {
            $order_products = array_map(function ($id, $quantity) use ($products) {
                $product = $products->find($id);
                $product->decrement('stock', $quantity);
                return ['product_id' => $id, 'quantity' => $quantity, 'unit_price' => $product->sell_price];
            }, array_keys($order_products), $order_products);

            $order = $client->orders()->create();
            $order->products()->sync($order_products);
            \DB::commit();

            \Session::flash('success', 'orders created successfully');
            return redirect(status: 200)->route('dashboard.clients.orders.index', $client);

        } catch (\Exception $e) {
            \DB::rollBack();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Client $client, Order $order)
    {
        $order->load(['client', 'products' => function ($q) {
            $q->select(['products.id', 'products.name']);
        }])->append('total_price');

        return view('dashboard.orders.show', compact('order'));
    }

    /*      *
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateClientOrderRequest $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Client $client, Order $order)
    {
        $order->load('products');
        \DB::beginTransaction();
        try {
            $order->products->each(function ($product) {
                $product->increment('stock', $product->pivot->quantity);
            });
            $order->delete();
            \DB::commit();
            \Session::flash('success', 'Order Deleted Successfully');

            return redirect(status: 200)->route('dashboard.clients.orders.index', $client);

        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect(status: 400)->route('dashboard.clients.orders.index', $client);

        }

    }
}
