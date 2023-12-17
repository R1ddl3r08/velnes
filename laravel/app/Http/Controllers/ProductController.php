<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('product_category')->get();
        $productCategories = ProductCategory::with('products')->get();
        $totalItems = $products->count();
        $totalStockValue = 0;
        foreach($products as $product){
            $stockValue = $product['price'] * $product['quantity'];
            $totalStockValue += $stockValue;
        }
        return view('products', compact('products', 'productCategories', 'totalItems', 'totalStockValue'));
    }

    public function product($id)
    {
        $product = Product::where('id', $id)->get();

        if(!$product){
            return response()->json('Product not found');
        }

        return response()->json($product);
    }

    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required|string',
            'product_category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric',
            'cost_price' => 'required|numeric',
            'part_number' => 'required|string',
            'vat' => 'required|not_in:0',
            'quantity' => 'required|integer',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }
    
        $product = Product::create($request->all());
    
        return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'product_category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric',
            'cost_price' => 'required|numeric',
            'part_number' => 'required|string',
            'vat' => 'required',
            'quantity' => 'required|integer',
        ]);

        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $product->update($validatedData);

        return response()->json(['message' => 'Product updated successfully', 'product' => $product]);
    }

    public function delete($id)
    {
        $product = Product::find($id);

        if(!$product){
            return response()->json('Product not found', 400);
        }

        $product->delete();
        return response()->json('Product deleted successfully', 200);
    }

    public function search(Request $request)
    {
        $categoryId = $request->input('category_id');
        $searchQuery = $request->input('search_query');

        $query = Product::query();

        if ($categoryId && $categoryId != 0) {
            $query->where('product_category_id', $categoryId);
        }

        if ($searchQuery) {
            $query->where('name', 'like', '%' . $searchQuery . '%');
        }

        $filteredProducts = $query->with('product_category')->get();

        return response()->json(['products' => $filteredProducts]);
    }

    public function filter(Request $request)
    {
        $categoryId = $request->input('category_id');
        $searchQuery = $request->input('search_query');

        if($categoryId == 0){
            $filteredProducts = Product::with('product_category')->get();
        } else {
            $filteredProducts = Product::where('product_category_id', $categoryId)
            ->with('product_category')
            ->get();
        }

        return response()->json($filteredProducts);
    }
}
