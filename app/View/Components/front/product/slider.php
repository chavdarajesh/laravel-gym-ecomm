<?php

namespace App\View\Components\front\product;

use Illuminate\View\Component;

class slider extends Component
{
    public $topSellingProducts;
    public $sliderClass;

    public function __construct($topSellingProducts, $sliderClass)
    {
        $this->topSellingProducts = $topSellingProducts;
        $this->sliderClass = $sliderClass;
    }

    public function render()
    {
        return view('components.front.product.slider');
    }
}
