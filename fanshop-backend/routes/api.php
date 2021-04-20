<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SearchController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PasswordRestoreController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\MercadoPagoStatusDetailController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\Admin\SalesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("search", [SearchController::class, "search"]);

Route::post("product", [ProductController::class, "info"]);

Route::post('login', [LoginController::class, 'login']);
Route::post('register', [RegisterController::class, "register"]);

Route::post("restore-password", [PasswordRestoreController::class, "restore"]);

Route::post("update-password", [PasswordRestoreController::class, "updatePassword"]);

Route::get("recommendations", [RecommendationController::class, "getRecommendations"]);

Route::group([

    'middleware' => 'api',

], function ($router) {

    Route::post('logout', [LoginController::class, 'logout']);
    Route::post('refresh', [LoginController::class, 'refresh']);
    Route::get('user', [LoginController::class, 'me']);

    Route::post("resend-register-email", [RegisterController::class, "resendEmail"]);

    Route::post("profile/update", [ProfileController::class, 'update']);

    Route::post("cart/store", [CartController::class, "store"]);
    Route::post("cart/delete", [CartController::class, "delete"]);
    Route::get("cart/fetch", [CartController::class, "fetch"]);
    Route::post("/cart/update", [CartController::class, "update"]);

    Route::post("checkout", [CheckoutController::class, 'checkout']);

    Route::get("purchase/fetch", [PurchaseController::class, "fetch"]);

    Route::get("mercado-pago-details", [MercadoPagoStatusDetailController::class, "getMercadoPagoDetails"]);

    Route::post("admin/sales/fetch", [SalesController::class, "fetch"]);

});
