<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::when($SearchName = request('search'), fn($query) => $query->filterByName($SearchName))
            ->when($searchCategory = request('category'), fn($query) => $query->filterByCategory($searchCategory))
            ->latest()
            ->paginate();
        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $product = new Product($request->validated());

        if ($request->has('image')) {
            Image::make($request->image)->resize(250, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path('app/uploads/product-images/'
                . $ImageName = Str::slug($product->name['en'], '-') . time() . '.' . $request->file('image')->getClientOriginalExtension()
            ));
            $product->image = $ImageName;
        }

        $product->save();
        session()->flash('success', __('messages.added_successfully'));
        return redirect(status: 200)->route('dashboard.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('dashboard.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateProductRequest $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        // prepare data
        $updatedData = $request->safe()->except(['permissions', 'image']);
        // if image has been uploaded replace the old one or save it with hashed name
        if ($request->has('image')) {
            // save image
            Image::make($request->image)->resize(150, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path('app/uploads/product-images/'
                . $updatedData['image'] = Str::slug($product->name['en'], '-')
                    . time()
                    . '.' . $request->file('image')->getClientOriginalExtension()
            ));
        }
        $product->update($updatedData);
        session()->flash('success', __('messages.updated_successfully'));

        return redirect(status: 200)->route('dashboard.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        $product->image = null;
        session()->flash('success', __('messages.updated_successfully'));
        return redirect(status: 200)->route('dashboard.products.index');
    }
}
