<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PasswordRestoreController;
use App\Http\Controllers\ZincapiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get("/register/validate", [RegisterController::class, "verify"]);
Route::get("/password/validate", [PasswordRestoreController::class, "verify"]);

Route::view("checkout/success", "checkout.success")->name("checkout.success");
Route::view("checkout/failure", "checkout.failure")->name("checkout.failure");

Route::post("/zinc/request_succeeded", [ZincapiController::class, "requestSucceeded"]);
Route::post("/zinc/request_failed", [ZincapiController::class, "requestFailed"]);
Route::post("/zinc/tracking_obtained", [ZincapiController::class, "trackingObtained"]);
Route::post("/zinc/status_updated", [ZincapiController::class, "statusUpdated"]);