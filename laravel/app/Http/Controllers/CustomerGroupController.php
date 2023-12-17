<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerGroup;
use Illuminate\Support\Facades\Validator;

class CustomerGroupController extends Controller
{
    public function index()
    {
        $customerGroups = CustomerGroup::with('customers')->get();

        return response()->json($customerGroups, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:customer_groups,name',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $customerGroup = CustomerGroup::create([
            'name' => $request->input('name'),
        ]);

        return response()->json(['message' => 'Customer group created successfully', 'customer_group' => $customerGroup], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:customer_groups,name,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $customerGroup = CustomerGroup::find($id);

        if (!$customerGroup) {
            return response()->json(['message' => 'Customer group not found'], 404);
        }

        $customerGroup->update([
            'name' => $request->input('name'),
        ]);

        return response()->json(['message' => 'Customer group updated successfully', 'customer_group' => $customerGroup]);
    }


    public function delete(Request $request, $id)
    {
        $customerGroup = CustomerGroup::find($id);

        if(!$customerGroup){
            return response()->json('Customer group not found', 404);
        }

        $customerGroup->delete();

        return response()->json('User deleted successfully', 200);
    }

    public function getCustomerGroup($id)
    {
        $customerGroup = CustomerGroup::find($id);

        if(!$customerGroup){
            return response()->json('Customer not found', 404);
        }

        return response()->json($customerGroup);
    }
}
