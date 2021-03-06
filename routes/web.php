<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/redirect',[HomeController::class,'redirect']);
Route::get('/',[HomeController::class,'index']);

Route::get('/product',[AdminController::class,'product'])->middleware('auth');
Route::post('/uploadProduct',[AdminController::class,'uploadProduct']);
Route::get('/products',[AdminController::class,'products'])->middleware('auth');
Route::delete('/products/{product}/delete',[AdminController::class,'destroy'])->middleware('auth');
Route::get('/products/{product}/update',[AdminController::class,'updateProduct'])->middleware('auth');
Route::post('/products/{product}/updated',[AdminController::class,'updateDProduct']);

Route::post('/carts/{product}',[HomeController::class,'addcart']);
Route::get('/carts/mycart',[HomeController::class,'mycarts'])->middleware('auth');
Route::get('/carts/{cart}/delete',[HomeController::class,'destroy'])->middleware('auth');
Route::post('/orders',[HomeController::class,'confirmOrder']);
Route::get('/admin_order',[AdminController::class,'orders']);
Route::get('/deliver/{order}',[AdminController::class,'deliver'])->middleware('auth');

