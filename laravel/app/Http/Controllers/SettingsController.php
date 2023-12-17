<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\ServiceCategory;

class SettingsController extends Controller
{
    public function index()
    {
        $serviceCategories = ServiceCategory::get();
        $employees = Employee::get();
        return view('settings', compact('serviceCategories', 'employees'));
    }
}
