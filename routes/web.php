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

Route::get( '/', function () {
    return view( 'welcome' );
} );

Auth::routes();

Route::get( '/', [ FrontController::class, 'index' ] )->name( 'home' );
Route::post( '/form/shipping/basic', [ FrontController::class, 'shippingFormSubmit' ] )->name( 'form.shipping' );
Route::get( '/form/shipping/carrier/{id}', [ FrontController::class, 'shippingCarrierForm' ] )->name( 'form.shipping.carrier' );
Route::post( '/form/shipping/carrier', [ FrontController::class, 'shippingCarrierSubmit' ] )->name( 'form.shipping.carrier.submit' );
Route::post( '/form/shipping/checkout', [ FrontController::class, 'shippingCheckout' ] )->name( 'form.shipping.checkout' );
Route::get( 'form/shipping/stripe/success/{id}', [ FrontController::class, 'shippingPaymentSuccess' ] )->name( 'form.shipping.stripe.success' );
Route::get( 'form/shipping/stripe/cancel/{id}', [ FrontController::class, 'ShippingPaymentCancel' ] )->name( 'form.shipping.stripe.cancel' );

Route::get( '/test', [ FrontController::class, 'test' ] )->name( 'test' );
Route::get( '/stamps/redirect', [ FrontController::class, 'stampAuthenticate' ] )->name( 'stamps.redirect' );

Route::get( '/home', [ HomeController::class, 'index' ] )->name( 'home' );
Route::get( '/admin/config/user-agreement', [ HomeController::class, 'configUserAgreementIndex' ] )->name( 'admin.config.user_agreement' );
Route::post( '/admin/config/user-agreement', [ HomeController::class, 'configUserAgreementSave' ] )->name( 'admin.config.user_agreement' );
Route::get( '/admin/config/address', [ HomeController::class, 'configAddressIndex' ] )->name( 'admin.config.address' );
Route::post( '/admin/config/address', [ HomeController::class, 'configAddressSave' ] )->name( 'admin.config.address' );
Route::get( '/admin/config/stamp-config', [ HomeController::class, 'configStampIndex' ] )->name( 'admin.config.stamp' );
Route::get( '/admin/config/stamp-config-authenticate', [ HomeController::class, 'authenticateStamp' ] )->name( 'admin.config.stamp.auth' );
