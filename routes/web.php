<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthorityController;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('admindashboard');
})->name('dashboard');

// Package Route 
Route::get('/package', [PackageController::class, 'index'])->name('package');
Route::post('/package/store', [PackageController::class, 'store'])->name('package.store');
Route::post('/package/update', [PackageController::class, 'update'])->name('package.update');
Route::get('/package/delete/{id}', [PackageController::class, 'delete'])->name('package.delete');

// Customet Registration Form 
Route::get('/customer/form', [CustomerController::class, 'index'])->name('customer.form');
Route::post('/customer/form/post', [CustomerController::class, 'store'])->name('customer.form.post');

// Admin Route 
Route::get('/adminlist' , [AuthorityController::class , 'index'])->name('adminlist');
Route::post('/createadmin' , [AuthorityController::class , 'create'])->name('create.newadmin');
Route::post('/editadmin/{id}' , [AuthorityController::class , 'edit'])->name('admin.edit');
Route::get('/deleteadmin/{id}' , [AuthorityController::class , 'delete'])->name('admin.delete');
