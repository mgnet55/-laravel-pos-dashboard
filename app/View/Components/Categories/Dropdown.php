<?php

namespace App\View\Components\Categories;

use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Dropdown extends Component
{
    public Collection $categories;
    public string $currentLocale;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public $selected = 0, public string $name = 'category_id')
    {
        $this->categories = Category::all();
        $this->currentLocale = LaravelLocalization::getCurrentLocale();

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.categories.dropdown');
    }
}
