@extends('layouts.app')
@section('title', 'Products')
@section('page-name')
    <h1 id="calendarTitle">Products</h1>
@endsection
@section('productsActive', 'active')
@section('content')
    <div class="products">
        <div class="products-nav">
            <button id="productsIndexBtn" class="active">Products</button>
            <button id="productCategoriesBtn">Categories</button>
            <div class="alert alert-success"></div>
        </div>
        <div class="products-products">
            <div class="actions">
                <form>
                    <div class="form-group search">
                        <input type="search" class="form-control" name="products-search" placeholder="Search" id="products-search">
                    </div>
                    <div class="form-group">
                        <select name="product-categories" id="product-categories" class="form-control">
                            <option value="0">All categories</option>
                            @foreach($productCategories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="low-stock-products" id="low-stock-products">
                        <label for="low-stock-products">Low stock</label>
                    </div>
                </form>
                <div class="buttons">
                    <button>Import products</button>
                    <button id="productCreateButton">New products</button>
                </div>
            </div>
            <div class="products-info">
                <div class="total-items">
                    <p>total items</p>
                    <p class="total">{{ $totalItems }}</p>
                </div>
                <div class="total-stock-value">
                    <p>total stock value</p>
                    <p class="total">&euro;{{ $totalStockValue }}</p>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>name</th>
                        <th>category</th>
                        <th>price</th>
                        <th>stock</th>
                        <th>stock value</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr id="{{ $product->id }}">
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->product_category->name }}</td>
                            <td>&euro;{{ $product->price }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>&euro;{{ $product->price * $product->quantity }}</td>
                            <td>
                                <button class="productCrudModalButton"><img src="{{ asset('svg/three-dots.svg') }}" alt=""></button>
                                <div class="crudModal productCrudModal">
                                    <button class="editProductButton" data-id="{{ $product->id }}">
                                        <img src="{{ asset('svg/pen.svg') }}" alt="">
                                        Edit
                                    </button>
                                    <button class="deleteProductButton" data-id="{{ $product->id }}">
                                        <img src="{{ asset('svg/trash-grey.svg') }}" alt="">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="modal" id="productCreateModal">
            <div class="product-create">
                <div class="window">
                    <div class="header">
                        <h2>New product</h2>
                        <button class="closeModal" id="closeProductCreateModalButton"><img src="{{ asset('svg/close.svg') }}" alt=""></button>
                    </div>
                    <form action="" id="product-store">
                        <div class="inner-form">
                            <div class="form-group">
                                <label for="name">Name*</label>
                                <input type="text" ida="name" name="name" class="form-control">
                                <span id="name-error" class="error-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="product_category_id">Product category</label>
                                <select name="product_category_id" id="product_category_id" class="form-control">
                                    <option value="0">Select</option>
                                    @foreach($productCategories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <span id="product_category_id-error" class="error-message"></span>
                            </div>
                            <div class="form-group half">
                                <label for="price">Sales price</label>
                                <input type="text" id="price" name="price" class="form-control">
                                <span id="price-error" class="error-message"></span>
                            </div>
                            <div class="form-group half">
                                <label for="cost_price">Cost price</label>
                                <input type="text" id="cost_price" name="cost_price" class="form-control">
                                <span id="cost_price-error" class="error-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="vat">Vat</label>
                                <select name="vat" id="vat" class="form-control">
                                    <option value="0">Select</option>
                                    <option value="5">5%</option>
                                    <option value="10">10%</option>
                                    <option value="15">15%</option>
                                </select>
                                <span id="vat-error" class="error-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="part_number">Part number</label>
                                <input type="text" name="part_number" id="part_number" class="form-control">
                                <span id="part_number-error" class="error-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Current stock</label>
                                <input type="text" name="quantity" id="quantity" class="form-control">
                                <span id="quantity-error" class="error-message"></span>
                            </div>
                        </div>
                        <div class="footer">
                            <button type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal" id="editProductModal">
            <div class="product-create">
                <div class="window">
                    <div class="header">
                        <h2>Edit product</h2>
                        <button class="closeModal" id="closeEditProductModal"><img src="{{ asset('svg/close.svg') }}" alt=""></button>
                    </div>
                    <form action="" id="product-update">
                        <div class="inner-form">
                            <div class="form-group">
                                <label for="name">Name*</label>
                                <input type="text" id="name" name="name" class="form-control">
                                <span id="update-name-error" class="error-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="product_category_id">Category</label>
                                <select name="product_category_id" id="product_category_id" class="form-control">
                                    <option value="0">Select</option>
                                    @foreach($productCategories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <span id="update-product_category_id-error" class="error-message"></span>
                            </div>
                            <div class="form-group half">
                                <label for="price">Sales price</label>
                                <input type="text" id="price" name="price" class="form-control">
                                <span id="update-price-error" class="error-message"></span>
                            </div>
                            <div class="form-group half">
                                <label for="cost_price">Cost price</label>
                                <input type="text" id="cost_price" name="cost_price" class="form-control">
                                <span id="update-cost_price-error" class="error-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="vat">Vat</label>
                                <select name="vat" id="vat" class="form-control">
                                    <option value="0" selected disabled>Select</option>
                                    <option value="5">5%</option>
                                    <option value="10">10%</option>
                                    <option value="15">15%</option>
                                </select>
                                <span id="update-vat-error" class="error-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="part_number">Part number</label>
                                <input type="text" name="part_number" id="part_number" class="form-control">
                                <span id="update-part_number-error" class="error-message"></span>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Current stock</label>
                                <input type="text" name="quantity" id="quantity" class="form-control">
                                <span id="update-quantity-error" class="error-message"></span>
                            </div>
                        </div>
                        <div class="footer">
                            <button type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="products-categories">
            <div class="product-category-actions">
                <button id="createProductCategoryButton">New category</button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>name</th>
                        <th>products</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productCategories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->products->count() }}</td>
                            <td>
                                <button class="productCategoryCrudModalButton"><img src="{{ asset('svg/three-dots.svg') }}" alt=""></button>
                                <div class="crudModal productCategoryCrudModal">
                                <button class="editProductCategoryButton" data-id="{{ $category->id }}">
                                    <img src="{{ asset('svg/pen.svg') }}" alt="">
                                    Edit
                                </button>
                                <button class="deleteProductCategoryButton" data-id="{{ $category->id }}">
                                    <img src="{{ asset('svg/trash-grey.svg') }}" alt="">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="modal" id="productCategoryCreateModal">
            <div class="product-create">
                <div class="window">
                    <div class="header">
                        <h2>New product category</h2>
                        <button class="closeModal" id="closeProductCategoryCreateModalButton"><img src="{{ asset('svg/close.svg') }}" alt=""></button>
                    </div>
                    <form action="" id="product-categories-store">
                        <div class="inner-form">
                            <div class="form-group">
                                <label for="product-category-name">Name*</label>
                                <input type="text" id="product-category-name" name="name" class="form-control">
                                <span id="product-category-name-error" class="error-message"></span>
                            </div>
                        </div>
                        <div class="footer">
                            <button type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal" id="editProductCategoryModal">
            <div class="product-create">
                <div class="window">
                    <div class="header">
                        <h2>Edit product category</h2>
                        <button class="closeModal" id="closeEditProductCategoryModal"><img src="{{ asset('svg/close.svg') }}" alt=""></button>
                    </div>
                    <form action="" id="product-categories-update">
                        <div class="inner-form">
                            <div class="form-group">
                                <label for="update-product-category-name">Name*</label>
                                <input type="text" id="update-product-category-name" name="name" class="form-control">
                                <span id="update-product-category-name-error" class="error-message"></span>
                            </div>
                        </div>
                        <div class="footer">
                            <button type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @vite(['resources/js/products.js'])
@endsection