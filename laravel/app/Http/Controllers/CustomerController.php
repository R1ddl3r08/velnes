<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\Employee;
use App\Models\Service;
use App\Models\Product;
use App\Models\Appointment;
use App\Models\Room;
use App\Models\Tool;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with('groups')->get();
        $customerGroups = CustomerGroup::get();
        $employees = Employee::get();
        $services = Service::get();
        $products = Product::get();
        return view('customers', compact('customers', 'customerGroups', 'employees', 'services', 'products'));
    }

    public function customer($id)
    {
        $customer = Customer::with(['appointments', 'appointments.service', 'appointments.employee'])
            ->find($id);
        $employees = Employee::get();
        $services = Service::get();
        $rooms = Room::get();
        $tools = Tool::get();

        if (!$customer) {
            return back()->with('error', 'No customer found');
        }

        return view('customer', compact('customer', 'employees', 'services', 'rooms', 'tools'));
    }

    public function store(Request $request)
    {
        $validationRules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gender' => 'required|in:male,female,other',
            'email' => 'email|max:255|unique:customers,email',
            'phone' => 'string|max:20',
            'address' => 'string|max:255',
            'city' => 'string|max:255',
            'postal_code' => 'string|max:20',
            'warning' => 'nullable|string',
        ];

        $validator = validator($request->all(), $validationRules);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('employee_photos', 'public');
        }

        $customerData = $request->except('customer_groups');

        $customer = Customer::create($customerData);

        if ($request->filled('customer_groups') && $request->input('customer_groups') != 0 ) {
            $customerGroup = CustomerGroup::findOrFail($request->input('customer_groups'));
            DB::table('customers_groups')->insert([
                'customer_id' => $customer->id,
                'customer_group_id' => $customerGroup->id,
            ]);
        }

        return response()->json(['message' => 'Customer created successfully', 'customer' => $customer], 201);
    }

    public function update(Request $request, $id)
    {
        $validationRules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gender' => 'required|in:male,female,other',
            'email' => 'email|max:255|unique:customers,email',
            'phone' => 'string|max:20',
            'address' => 'string|max:255',
            'city' => 'string|max:255',
            'postal_code' => 'string|max:20',
            'warning' => 'nullable|string',
        ];

        $validator = validator($request->all(), $validationRules);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $customerData = $request->except('customer_groups');

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('customer_photos', 'public');
            $customerData['photo_path'] = $photoPath;
        }

        $customer = Customer::findOrFail($id);
        $customer->update($customerData);

        if ($request->filled('customer_groups') && $request->input('customer_groups') != 0) {
            $customerGroup = CustomerGroup::findOrFail($request->input('customer_groups'));
            DB::table('customers_groups')
                ->where('customer_id', $customer->id)
                ->delete();
            DB::table('customers_groups')->insert([
                'customer_id' => $customer->id,
                'customer_group_id' => $customerGroup->id,
            ]);
        }

        return response()->json(['message' => 'Customer updated successfully', 'customer' => $customer], 200);
    }

    public function getCustomer($id)
    {
        $customer = Customer::where('id', $id)->get();

        if(!$customer){
            return response()->json('Customer not found');
        }

        return response()->json($customer);
    }

    public function delete($id)
    {
        $customer = Customer::find($id);

        if(!$customer){
            return response()->json('Customer not found', 400);
        }

        $customer->delete();
        return response()->json('Customer deleted successfully', 200);
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('search_query');

        $query = Customer::query();

        // Add conditions to filter by first_name, last_name, email, and phone
        $query->where('first_name', 'like', '%' . $searchQuery . '%')
            ->orWhere('last_name', 'like', '%' . $searchQuery . '%')
            ->orWhere('email', 'like', '%' . $searchQuery . '%')
            ->orWhere('phone', 'like', '%' . $searchQuery . '%');

        $filteredCustomers = $query->with('groups')->get();

        return response()->json(['customers' => $filteredCustomers]);
    }

}
