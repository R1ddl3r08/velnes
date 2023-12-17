<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Validator;

class ServiceCategoryController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:service_categories,name',
            'color' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $serviceCategory = ServiceCategory::create([
            'name' => $request->input('name'),
            'color' => $request->input('color'),
        ]);

        return response()->json(['message' => 'Service category created successfully', 'serviceCategory' => $serviceCategory], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:service_categories,name,' . $id,
            'color' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $serviceCategory = ServiceCategory::find($id);

        if (!$serviceCategory) {
            return response()->json(['message' => 'Service category not found'], 404);
        }

        $serviceCategory->update([
            'name' => $request->input('name'),
            'color' => $request->input('color'),
        ]);

        return response()->json(['message' => 'Service category updated successfully', 'customer_group' => $serviceCategory]);
    }

    public function delete(Request $request, $id)
    {
        $serviceCategory = ServiceCategory::find($id);

        if(!$serviceCategory){
            return response()->json('ServiceCategory group not found', 404);
        }

        $serviceCategory->delete();

        return response()->json('User deleted successfully', 200);
    }

    public function getServiceCategory($id)
    {
        $serviceCategory = ServiceCategory::find($id);

        if(!$serviceCategory){
            return response()->json('Service category not found', 404);
        }

        return response()->json($serviceCategory);
    }
}
