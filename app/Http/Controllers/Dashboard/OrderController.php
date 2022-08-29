<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateClientOrderRequest;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $orders = Order::latest()->with(['products', 'client' => fn($q) => $q->select(['id', 'name'])])->paginate();

        return view('dashboard.orders.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return Application|Factory|View
     */
    public function show(Order $order)
    {
        $order->load(['client', 'products' => function ($q) {
            $q->select(['products.id', 'products.name']);
        }])->append('total_price');

        return view('dashboard.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Order $order
     * @return Application|Factory|View
     */
    public function edit(Order $order)
    {

        $categories = Category::select(['id', 'name'])->with('products')->get();

        return view('dashboard.clients.orders.edit', compact('categories', 'order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Order $order
     * @param UpdateClientOrderRequest $request
     * @return void
     */
    public function update(Order $order, UpdateClientOrderRequest $request)
    {
        //dd([$order, $request->all()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Order $order
     * @return RedirectResponse
     */
    public function destroy(Order $order)
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

            return redirect(status: 200)->route('dashboard.orders.index');

        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect(status: 400)->route('dashboard.orders.index');

        }

    }
}
