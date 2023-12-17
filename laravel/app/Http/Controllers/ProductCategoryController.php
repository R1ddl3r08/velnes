<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }
    
        $product = ProductCategory::create($request->all());
    
        return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        $product = ProductCategory::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $product->update($validatedData);

        return response()->json(['message' => 'Product updated successfully', 'product' => $product]);
    }

    public function delete($id)
    {
        $product = ProductCategory::find($id);

        if(!$product){
            return response()->json('Product not found', 404);
        }

        $product->delete();

        return response()->json('Product deleted successfully', 200);
    }

    public function productCategory($id)
    {
        $category = ProductCategory::where('id', $id)->get();

        if(!$category){
            return response()->json('Category not found');
        }

        return response()->json($category);
    }
}
