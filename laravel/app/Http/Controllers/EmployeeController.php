<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;
use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeController extends Controller
{
    use SoftDeletes;

    public function index()
    {
        $employees = Employee::with('services')->get();

        return response()->json(['employees' => $employees]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $filteredEmployees = Employee::with('services')
        ->where('name', 'like', '%' . $query . '%')
        ->orWhere('email', 'like', '%' . $query . '%')
        ->get();

        return response()->json(['employees' => $filteredEmployees]);
    }

    public function getDeletedEmployees()
    {
        $deletedEmployees = Employee::with('services')->onlyTrashed()->get();

        return response()->json(['employees' => $deletedEmployees]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,unknown',
            'email' => 'required|email|unique:employees,email',
            'phone_number' => 'required|string',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'services' => 'required|array',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $bookableOnline = $request->has('bookable_online') ? 1 : 0;
    
        $employee = Employee::create([
            'name' => $request->input('name'),
            'gender' => $request->input('gender'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'bookable_online' => $bookableOnline,
            'user_id' => 1,
        ]);
    
        if($employee){
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $photoPath = $photo->store('employee_photos', 'public');
        
                $employee->photo_path = $photoPath;
                $employee->save();
            }
        
            $services = $request->input('services');
            foreach ($services as $service) {
                DB::table('services_employees')->insert([
                    'service_id' => $service,
                    'employee_id' => $employee->id,
                ]);
            }
        
            return response()->json(['message' => 'Employee created successfully'], 201);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,unknown',
            'email' => 'required|email|unique:employees,email,' . $id,
            'phone_number' => 'required|string',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'services' => 'required|array',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }
    
        $employee = Employee::find($id);
    
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }
    
        $employee->name = $request->input('name');
        $employee->gender = $request->input('gender');
        $employee->email = $request->input('email');
        $employee->phone_number = $request->input('phone_number');
    
        $employee->bookable_online = $request->has('bookable_online') ? 1 : 0;
    
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('employee_photos', 'public');
    
            $employee->photo_path = $photoPath;
        }
    
        $employee->save();
    
        $services = $request->input('services');
        $employee->services()->sync($services);
    
        return response()->json(['message' => 'Employee updated successfully'], 200);
    }
    

    public function delete(Request $request, $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $employee->delete();

        return response()->json(['message' => 'Employee soft deleted successfully'], 200);
    }

    public function getServiceCategoriesWithServices()
    {
        $categoriesWithServices = ServiceCategory::with('services')->get();
        return response()->json($categoriesWithServices);
    }

    public function getEmployeeDetails($id)
    {
        $employee = Employee::with('services')->where('id', $id)->get();
        if($employee){
            return response()->json($employee);
        }
    }

    public function getEmployeeServices($id)
    {
        $services = $employee->services;

        return response()->json($services);
    }

}
