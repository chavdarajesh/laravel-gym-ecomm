<?php

namespace App\View\Components\front\product;

use Illuminate\View\Component;

class nav_menu extends Component
{
    public $categories;
    public $brands;

    public function __construct($categories, $brands)
    {
        $this->categories = $categories;
        $this->brands = $brands;
    }
    public function render()
    {
        return view('components.front.product.nav_menu');
    }
}
