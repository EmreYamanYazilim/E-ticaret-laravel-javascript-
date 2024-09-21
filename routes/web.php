<?php

use App\Http\Controllers\Front\CardController;
use App\Http\Controllers\Front\CheckoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\MyOrdersController;
use App\Http\Controllers\Front\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;


Route::get('/', [FrontController::class, 'index'])->name('index');
Route::get('/urun-listesi', [ProductController::class, 'list']);
Route::get('/urun-detay', [ProductController::class, 'detail']);
Route::get('/sepet', [CardController::class, 'card']);
Route::get('/odeme', [CheckoutController::class, 'index']);
Route::get('/siparislerim', [MyOrdersController::class, 'index'])->name('order.index');
Route::get('/siperislerim-detay', [MyOrdersController::class, 'detail'])->name('order.detail');

Route::prefix('admin')->name('admin.')->middleware(['auth','admin-check'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
});
/* Auth işlemleri*/

//throttle yaparak provider içinde registiration oluşturduğumuz limitleri verebiliriz daha fazla özelleştirme için bu yöntem  basit  olaratak  alttaki yöntemi kullanacağım
Route::prefix('kayit-ol')->middleware('throttle:registration')->group(function () {
    Route::get('/', [RegisterController::class, 'showForm'])->name("register");
    Route::post('/', [RegisterController::class, 'register']);
});
// throttle alternatif yöntemde throttle:60,1  dakikada 60 istek atılabiliceğini belirtir
Route::prefix('giris')->middleware('throttle:60,60')->group(function () {
    Route::get('/', [LoginController::class, 'showForm'])->name('login');
    Route::post('/', [LoginController::class, 'login']);
});
Route::post('/cikis', [LoginController::class, 'logout'])->name('logout');
Route::get('/dogrula/{token}', [RegisterController::class, 'verify'])->name('verify');
