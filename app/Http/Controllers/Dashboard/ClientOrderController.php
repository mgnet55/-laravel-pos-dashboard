<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientOrderRequest;
use App\Models\Category;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ClientOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
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
     * @return View
     */
    public function create(Client $client)
    {
        $categories = Category::with('products')->get();

        return view('dashboard.clients.orders.create', compact('client', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Client $client
     * @param StoreClientOrderRequest $request
     * @return RedirectResponse
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
            return redirect(status: 400)->route('dashboard.clients.orders.index', $client);
        }

    }

}
