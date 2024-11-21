<?php

namespace App\View\Components;

use Illuminate\View\Component;

class relatedProductSlider extends Component
{
    public $relatedProducts;

    public function __construct($relatedProducts)
    {
        $this->relatedProducts = $relatedProducts;
    }

    public function render()
    {
        return view('components.related-product-slider');
    }
}
