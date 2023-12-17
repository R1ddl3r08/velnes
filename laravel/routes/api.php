<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CustomerGroupController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProductCategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Calendar
Route::get('/appointments/{date}/{range}/{employees}', [CalendarController::class, 'getAppointments']);


Route::get('/getAppointmentsByEmployee', [AppointmentController::class, 'getAppointmentsByEmployee']);

// Products
Route::get('/products/search', [ProductController::class, 'search']);
Route::get('/products/filter', [ProductController::class, 'filter']);
Route::post('/products/store', [ProductController::class, 'store']);
Route::post('/products/update/{id}', [ProductController::class, 'update']);
Route::post('/products/delete/{id}', [ProductController::class, 'delete']);
Route::get('/products/{id}', [ProductController::class, 'product']);
Route::delete('/products/{id}', [ProductController::class, 'delete']);

// Product categories
Route::post('/productCategories', [ProductCategoryController::class, 'store']);
Route::patch('/productCategories/{id}', [ProductCategoryController::class, 'update']);
Route::delete('/productCategories/{id}', [ProductCategoryController::class, 'delete']);
Route::get('/productCategories/{id}', [ProductCategoryController::class, 'productCategory']);

// Customers
Route::post('/customers/store', [CustomerController::class, 'store']);
Route::get('/customers/search', [CustomerController::class, 'search']);
Route::patch('/customers/update/{id}', [CustomerController::class, 'update']);
Route::get('/customers/{id}', [CustomerController::class, 'getCustomer']);
Route::delete('/customers/{id}', [CustomerController::class, 'delete']);

// Employees
Route::get('/employees', [EmployeeController::class, 'index']);
Route::post('/employees/store', [EmployeeController::class, 'store']);
Route::get('/employees/service-categories-with-services', [EmployeeController::class, 'getServiceCategoriesWithServices']);
Route::get('/employees/search', [EmployeeController::class, 'search']);
Route::get('/employees/deleted', [EmployeeController::class, 'getDeletedEmployees']);
Route::patch('/employees/update/{id}', [EmployeeController::class, 'update']);
Route::delete('/employees/{id}', [EmployeeController::class, 'delete']);
Route::get('/employee/{id}', [EmployeeController::class, 'getEmployeeDetails']);


// Customer groups
Route::get('/customerGroups', [CustomerGroupController::class, 'index']);
Route::post('/customerGroups/store', [CustomerGroupController::class, 'store']);
Route::patch('/customerGroups/update/{id}', [CustomerGroupController::class, 'update']);
Route::delete('/customerGroups/{id}', [CustomerGroupController::class, 'delete']);
Route::get('/customerGroups/{id}', [CustomerGroupController::class, 'getCustomerGroup']);

// Appointment
Route::post('/appointments/store', [AppointmentController::class, 'store']);
Route::patch('/appointments/update/{id}', [AppointmentController::class, 'update']);
Route::delete('/appointments/{id}', [AppointmentController::class, 'delete']);
Route::get('/appointment/{id}', [AppointmentController::class, 'appointment']);

//  Services
Route::get('/services', [ServiceController::class, 'services']);
Route::get('/services/search', [ServiceController::class, 'search']);
Route::get('/serviceCategories', [ServiceController::class, 'getServiceCategories']);
Route::post('/services', [ServiceController::class, 'store']);
Route::get('/service/{id}', [ServiceController::class, 'service']);
Route::patch('/services/{id}', [ServiceController::class, 'update']);
Route::delete('/services/{id}', [ServiceController::class, 'delete']);
Route::get('/services/category/{id}', [ServiceController::class, 'getServicesByCategory']);

// Service categories
Route::post('/serviceCategory', [ServiceCategoryController::class, 'store']);
Route::patch('/serviceCategory/{id}', [ServiceCategoryController::class, 'update']);
Route::delete('/serviceCategory/{id}', [ServiceCategoryController::class, 'delete']);
Route::get('/serviceCategory/{id}', [ServiceCategoryController::class, 'getServiceCategory']);

// Resources
Route::get('/resources', [ResourceController::class, 'index']);
Route::get('/resources/search', [ResourceController::class, 'search']);
Route::post('/resources', [ResourceController::class, 'store']);
Route::get('/resources/filter/{value}', [ResourceController::class, 'filter']);
Route::patch('/resources/{type}/{id}', [ResourceController::class, 'update']);
Route::delete('/resources/{type}/{id}', [ResourceController::class, 'delete']);
Route::get('/resource/{type}/{id}', [ResourceController::class, 'getResource']);

// Accounts
Route::get('/accounts', [AccountController::class, 'index']);
Route::get('/accounts/search', [AccountController::class, 'search']);
Route::post('/accounts', [AccountController::class, 'store']);
Route::get('/accounts/filter/{value}', [AccountController::class, 'filter']);
Route::patch('/accounts/{id}', [AccountController::class, 'update']);
Route::delete('/accounts/{id}', [AccountController::class, 'delete']);
Route::get('/account/{id}', [AccountController::class, 'getAccount']);