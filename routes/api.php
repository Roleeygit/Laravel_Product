<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

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

Route::group(["middleware" => ["auth:sanctum"]], function(){

    Route::post("/newproduct", [ProductController::class, "store"]);
    Route::put("/product{id}", [ProductController::class, "update"]);
    Route::delete("/product{id}", [ProductController::class, "destroy"]);

});

Route::post("/register", [AuthController::class, "signUp"]);
Route::post("/login", [AuthController::class, "signIn"]);
Route::get("/products", [ProductController::class, "index"]);
Route::get("/product{id}", [ProductController::class, "show"]);



