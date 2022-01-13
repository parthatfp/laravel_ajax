<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

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
    return view('layouts.app');
});

Route::get('/employee', [EmployeeController::class, 'index'])->name('allEmployeeList');
Route::get('/fetch-amployee', [EmployeeController::class, 'fetchEmployee'])->name('employee.fetch');
Route::post('/employee', [EmployeeController::class, 'store'])->name('employee.store');
Route::get('/edit-employee/{id}', [EmployeeController::class, 'editEmployee'])->name('employee.edit');
Route::post('/update-employee/{id}', [EmployeeController::class, 'updateEmployee'])->name('employee.update');
Route::delete('/delete-employee/{id}', [EmployeeController::class, 'deleteEmployee'])->name('employee.delete');

Route::get('/product', [ProductController::class, 'index'])->name('allproductList');
// Route::get('/fetch-amployee', [ProductController::class, 'fetchproduct'])->name('product.fetch');
Route::post('/product', [ProductController::class, 'store'])->name('product.store');
Route::get('/edit-product/{id}', [ProductController::class, 'editproduct'])->name('product.edit');
Route::post('/update-product/{id}', [ProductController::class, 'updateproduct'])->name('product.update');
Route::delete('/delete-product/{id}', [ProductController::class, 'deleteproduct'])->name('product.delete');
Route::post('/active-product/{id}', [ProductController::class, 'activeProduct'])->name('activeProduct');
Route::post('/inactive-product/{id}', [ProductController::class, 'inactiveProduct'])->name('inactiveProduct');