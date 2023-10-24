<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\EmployeesController;

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

Route::get('/products', [
    ProductsController::class, 'index'
]);

Route::get('/products/getProduct/{id}', [
    ProductsController::class, 'getProduct'
]);

Route::post('/products/create', [
    ProductsController::class, 'create'
]);

Route::put('/products/update', [
    ProductsController::class, 'update'
]);

Route::delete('/products/destroy/{id}', [
    ProductsController::class, 'destroy'
]);

Route::get('/products/majorStock', [
    ProductsController::class, 'getProductWithMajorStock'
]);

Route::get('/sales/mostSold', [
    SalesController::class, 'getMostSoldProduct'
]);

Route::get('/sales', [
    SalesController::class, 'index'
]);

Route::post('/sales/create', [
    SalesController::class, 'create'
]);

Route::get('/categories', [
    CategoriesController::class, 'index'
]);

Route::get('/employees', [
    EmployeesController::class, 'index'
]);