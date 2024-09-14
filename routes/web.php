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


Route::get('/', [FrontController::class, 'index']);
Route::get('/urun-listesi', [ProductController::class, 'list']);
Route::get('/urun-detay', [ProductController::class, 'detail']);
Route::get('/sepet', [CardController::class, 'card']);
Route::get('/odeme', [CheckoutController::class, 'index']);
Route::get('/siparislerim', [MyOrdersController::class, 'index']);
Route::get('/siperislerim-detay', [MyOrdersController::class, 'detail']);

//throttle yaparak provider içinde registiration oluşturduğumuz limitleri verebiliriz daha fazla özelleştirme için bu yöntem  basit  olaratak  alttaki yöntemi kullanacağım
Route::middleware('throttle:registration')->group(function () {
    Route::get('kayit-ol', [RegisterController::class, 'showForm'])->name("register");
    Route::post('kayit-ol', [RegisterController::class, 'register']);
});

Route::get('/dogrula/{token}', [RegisterController::class, 'verify'])->name('verify');
// throttle alternatif yöntemde throttle:60,1  dakikada 60 istek atılabiliceğini belirtir
Route::get('giris', [LoginController::class, 'showForm'])->name('login')->middleware("throttle:60,60");
Route::post('giris', [LoginController::class, 'login']);

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.index');
});
