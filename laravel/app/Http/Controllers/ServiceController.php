<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function service($id)
    {
        $service = Service::with('employees')->where('id', $id)->first();

        if (!$service) {
            return response()->json('Service not found', 404);
        }

        return response()->json($service, 200);
    }

    public function services()
    {
        $services = Service::with('category')->get();
        $serviceCategories = ServiceCategory::with('services')->get();

        return response()->json(['serviceCategories' => $serviceCategories]);
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('search_query');

        $query = Service::query();

        $query->where('name', 'like', '%' . $searchQuery . '%');

        $filteredServices = $query->get();

        return response()->json(['services' => $filteredServices]);
    }

    public function getServiceCategories()
    {
        $serviceCategories = ServiceCategory::get();

        return response()->json($serviceCategories);
    }

    public function getServicesByCategory($id)
    {
        $services = Service::where('service_category_id', $id)->get();

        return response()->json($services);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'service_category' => 'required|exists:service_categories,id',
            'price' => 'required|numeric',
            'duration' => 'required|numeric',
            'employees' => 'required',
            'employees.*' => 'exists:employees,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $service = Service::create([
            'name' => $request->input('name'),
            'service_category_id' => $request->input('service_category'),
            'price' => $request->input('price'),
            'duration' => $request->input('duration'),
            'bookable_online' => $request->input('bookable_online', 0),
        ]);

        $service->employees()->attach($request->input('employees'));

        return response()->json(['message' => 'Service created successfully']);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'service_category' => 'required|exists:service_categories,id',
            'price' => 'required|numeric',
            'duration' => 'required|numeric',
            'employees' => 'required',
            'employees.*' => 'exists:employees,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $service = Service::findOrFail($id);

        $service->update([
            'name' => $request->input('name'),
            'service_category_id' => $request->input('service_category'),
            'price' => $request->input('price'),
            'duration' => $request->input('duration'),
            'bookable_online' => $request->input('bookable_online', 0),
        ]);

        $service->employees()->sync($request->input('employees'));

        return response()->json(['message' => 'Service updated successfully']);
    }

    public function delete(Request $request, $id)
    {
        $service = Service::find($id);

        if(!$service){
            return response()->json('Service group not found', 404);
        }

        $service->delete();

        return response()->json('User deleted successfully', 200);
    }
}
