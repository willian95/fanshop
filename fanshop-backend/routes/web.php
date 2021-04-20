<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PasswordRestoreController;
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