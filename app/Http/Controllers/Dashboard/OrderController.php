<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::latest()->with(['products', 'client' => fn($q) => $q->select(['id', 'name'])])->paginate();

        return view('dashboard.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
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
