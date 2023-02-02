<?php

use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
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

Auth::routes();

Route::get('/', [FrontController::class, 'index'])->name('home');
Route::post('/form/shipping', [FrontController::class, 'shippingFormSubmit'])->name('form.shipping');

Route::get('/test', [FrontController::class, 'test'])->name('test');
Route::get('/stamps/redirect', [FrontController::class, 'stampRedirect'])->name('stamps.redirect');

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/admin/config', [HomeController::class, 'configIndex'])->name('admin.config');
Route::post('/admin/config', [HomeController::class, 'configSave'])->name('admin.config');
