<?php


/*
|--------------------------------------------------------------------------
| cUrl Routes
|--------------------------------------------------------------------------
|
| Here is where you can register cUrl routes for your application. These
| routes are loaded by the RouteServiceProvider. Enjoy building your cUrls!
|
*/

use App\Http\Controllers\Curl\VehicleController;
use Illuminate\Support\Facades\Route;

Route::get('save-vehicle-manufacturers', [VehicleController::class, 'saveVehicleManufacturers']);
