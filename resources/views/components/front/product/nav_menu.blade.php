<link rel="stylesheet" href="{{ asset('assets/front/css/product-nav.css') }}">

<section class="">
    <div class="my-5 container " id="product-nav-menu">
        <nav class="navbar navbar-expand-lg navbar-light container d-flex justify-content-end">
            <!-- <a class="navbar-brand" href="https://bootstrapcreative.com/">Mega Dropdown</a> -->
            <button class="navbar-toggler p-2 " type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            aria-haspopup="true" aria-expanded="false" data-toggle="dropdown">
                            <span> CATEGORIES</span>
                            @if($categories && $categories->count())
                            <img class="mx-2 drop-down-arrow" width="10px" src="{{ asset('assets/front/img/product/arrow-down-filled-triangle-svgrepo-com.svg') }}" alt="">
                            @endif
                        </a>
                        @if($categories->count())
                        <div class="dropdown-menu m-0 p-0 normal-menu width-max-content" aria-labelledby="navbarDropdown">
                            @foreach($categories as $category)
                            @if($category->subcategories && $category->subcategories->count())
                            <!-- Nested dropdown -->
                            <div class="dropdown-submenu w-100">
                                <span class="nav-link dropdown-item dropdown-toggle" >
                                    <a class="nav-link d-inline" href="{{route('front.products-category',$category->id)}}"> {{ $category->name }}</a>
                                    @if($category->subcategories->count())
                                    <img class="mx-2 drop-down-arrow" width="10px" src="{{ asset('assets/front/img/product/arrow-down-filled-triangle-svgrepo-com.svg') }}" alt="">
                                    @endif
                                </span>
                                @if($category->subcategories->count())
                                <div class="dropdown-menu p-0 width-max-content">
                                    @foreach($category->subcategories as $subcategory)
                                    <a class="nav-link dropdown-item w-100" href="{{route('front.products-sub-category',$subcategory->id)}}"> {{ $subcategory->name }}</a>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            @else
                            <a class="nav-link dropdown-item" href="{{route('front.products-category',$category->id)}}">{{ $category->name }}</a>
                            @endif
                            @endforeach
                        </div>
                        @endif
                    </li>


                    <li class="nav-item dropdown brand-section-nav">
                        <a class="nav-link dropdown-toggle" href="javascript:void(0);" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span> BRANDS</span>
                            @if($brands->count())
                            <img class="mx-2 drop-down-arrow" width="10px" src="{{ asset('assets/front/img/product/arrow-down-filled-triangle-svgrepo-com.svg') }}" alt="">
                            @endif
                        </a>
                        @if($brands->count())
                        <div class="dropdown-menu full-width-menu" aria-labelledby="navbarDropdown">
                            <div class="container">
                                @foreach ($brands as $letter => $brandGroup)
                                <div class="letter-section mb-4">
                                    <h2>{{ $letter }}</h2>
                                    <div class="row">
                                        @foreach ($brandGroup as $brand)
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3 text-center">
                                            <a href="{{route('front.products-brand',$brand->id)}}">
                                                <div class="brand-item d-flex align-items-center text-dark">
                                                    <img src="{{ asset($brand->image) }}" alt="{{ $brand->name }}" class="brand-logo img-fluid mx-2">
                                                    <span>{{ $brand->name }}</span>
                                                </div>
                                            </a>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <!--  /.container  -->


                        </div>
                        @endif
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{route('front.products-top-selling')}}" id="navbarDropdown" role="button">
                            TOP SELLINGs
                        </a>
                    </li>
                </ul>
                <form action="{{ route('front.products-search') }}" method="GET">
                    <div class="form-group m-0">
                        <div class="input-group ">
                            <input type="text" value="{{isset($search) ? $search : ''}}" class="form-control" placeholder="Search Keyword" name="search">
                            <div class="input-group-append">
                                <button class="btn" type="submit"><i class="ti-search"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </nav>
    </div>
</section>
