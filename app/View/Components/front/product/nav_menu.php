<?php

namespace App\View\Components\front\product;

use Illuminate\View\Component;

class nav_menu extends Component
{
    public $categories;
    public $brands;
    public $search;

    public function __construct($categories, $brands, $search)
    {
        $this->categories = $categories;
        $this->brands = $brands;
        $this->search = $search;
    }
    public function render()
    {
        return view('components.front.product.nav_menu');
    }
}
