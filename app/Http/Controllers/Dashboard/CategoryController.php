<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::when($SearchText = request('search'), fn($query) => $query->filterByName($SearchText))
            ->latest()
            ->paginate();
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = new Category($request->validated());
        $category->save();
        session()->flash('success', __('messages.added_successfully'));
        return redirect(status: 200)->route('dashboard.categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategoryRequest $request
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        if ($category->wasChanged()) {
            session()->flash('success', __('messages.updated_successfully'));
        }

        return redirect(status: 200)->route('dashboard.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        if ($category->getKey() == 1) {
            return redirect(status: 400)->route('dashboard.categories.index');
        }

        \DB::beginTransaction();
        Product::where('category_id', $category->id)->update(['category_id' => 1]);
        $category->delete();
        \DB::commit();

        session()->flash('success', __('messages.deleted_successfully'));
        return redirect(status: 200)->route('dashboard.categories.index');

    }
}
