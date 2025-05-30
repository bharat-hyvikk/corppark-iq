<?php

use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\OfficeController;
use App\Http\Controllers\Api\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post("login", [LoginController::class, "login"])->name("login");
Route::middleware('authApi')->group(function () {
    Route::post("office_and_vehicle_details", [OfficeController::class, "officeVehicleDetails"])->name("office_and_vehicle_details");

    // office_and_vehicle_list
    Route::post("office_and_vehicle_list", [OfficeController::class, "officeVehicleList"])->name("office_and_vehicle_list");

    // check_in_status in vehicleController 
    Route::post("check_in_status", [VehicleController::class, "checkInStatus"])->name("check_in_status");
    // api for dashboard 
    Route::post("dashboard", [DashboardController::class, "dashboard"])->name("dashboard");
    // api to get list of offices no 
    Route::post("office_list", [OfficeController::class, "officeList"])->name("office_list");
    // api for logout 
    Route::post("logout", [LoginController::class, "logout"])->name("logout");
});
