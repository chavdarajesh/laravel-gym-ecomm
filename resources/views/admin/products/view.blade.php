@extends('admin.layouts.main')
@section('title', 'View Product')

@section('css')
<style>
    .gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 10px;
        padding: 10px;
    }

    .gallery-item {
        position: relative;
        overflow: hidden;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .gallery-item img {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.3s ease;
    }

    .gallery-item:hover {
        transform: scale(1.05);
    }

    .gallery-item:hover img {
        transform: scale(1.05);
    }

    .close-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 1.5em;
        color: #fff;
        background-color: rgba(0, 0, 0, 0.6);
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .close-icon:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }

    @media (max-width: 600px) {
        .gallery {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }
    }
</style>
@stop
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Products /</span> All Products /</span> View Product</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Products Setting</h5>
                <!-- Account -->
                <hr class="my-0" />
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="{{ $Product['image'] ? asset($Product['image']) : asset('assets/admin/img/avatars/dummy-image-square.jpg') }}"
                                alt="Product Image" class="d-block rounded" height="100" width="100"
                                id="uploadedAvatar" />
                            <div id="dvPreview">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label for="name" class="form-label">Name</label>
                            <input class="form-control" type="text" disabled id="name" name="name"
                                value="{{ $Product['name'] }}" />
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="brand" class="form-label">Brand</label>
                            <select disabled class="form-select select2 " id="brand"
                                name="brand">
                                @foreach ($Brands as $Brand)
                                <option {{ $Product['brand_id'] == $Brand->id ? 'selected' : ''  }} value="{{ $Brand->id }}">{{ $Brand->name }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="category" class="form-label">Category</label>
                            <select disabled class="form-select select2 " id="category"
                                name="category">
                                @foreach ($Categorys as $Category)
                                <option {{ $Product['category_id'] == $Category->id ? 'selected' : ''  }} value="{{ $Category->id }}">{{ $Category->name }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="subcategory" class="form-label">Sub Category</label>
                            <select disabled class="form-select select2 " id="subcategory"
                                name="subcategory">
                                @foreach ($subcategories as $subcategorie)
                                <option {{ $Product['subcategory_id'] == $subcategorie->id ? 'selected' : ''  }} value="{{ $subcategorie->id }}">{{ $subcategorie->name }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="flavors" class="form-label">Flavor</label>
                            <select disabled multiple class="form-select select2 " id="flavors"
                                name="flavors[]">
                                @foreach ($Flavors as $Flavor)
                                <option {{ in_array($Flavor->id, $Product->flavors->pluck('id')->toArray()) ? 'selected' : '' }} value="{{ $Flavor->id }}">{{ $Flavor->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="images" class="form-label">Images</label>
                            @if($Product->images->count() > 0)
                            <div class="mb-3 col-md-12">
                                <div class="gallery">
                                    @foreach($Product->images as $image)
                                    <div class="gallery-item" data-image-id="{{$image->id}}"><img src="{{ asset($image->image) }}" alt="Image">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="mb-3 col-md-12">
                            <label for="sizes" class="form-label">Size</label>
                            <select disabled multiple class="form-select select2 " id="sizes"
                                name="sizes[]">
                                @foreach ($Sizes as $Size)
                                <option {{ in_array($Size->id, $Product->sizes->pluck('id')->toArray()) ? 'selected' : '' }} value="{{ $Size->id }}">{{ $Size->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="priceInputsContainer" class="mb-3 col-md-12">
                            @foreach ($Product->sizes as $size)
                            <div class="mb-3 price-input" data-size-id="{{$size->id}}">
                                <label for="price_{{$size->id}}" class="form-label">Price for {{$size->name}}</label>
                                <input disabled type="number" value="{{$size->pivot->price}}" step="0.01" class="form-control" id="price_{{$size->id}}" name="prices[{{$size->id}}]" placeholder="Enter price for {{$size->name}}">
                            </div>
                            @endforeach

                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="description" class="form-label">Description</label>
                            <div class="form-control">
                                {!! html_entity_decode($Product['description']) !!}
                            </div>
                        </div>
                        <div class="mt-2">
                            <a href="{{ route('admin.products.edit', $Product->id) }}" class="btn btn-warning">Edit</a>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
                <!-- /Account -->
            </div>
        </div>
    </div>
</div>
@stop
