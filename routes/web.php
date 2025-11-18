<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageProxyController;
use App\Http\Controllers\PreOrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Central Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Pre-Order Form Routes with rate limiting
Route::prefix('pre-order')->middleware(['throttle:30,1'])->group(function () {
    // Start pre-order (redirects to Filament wizard)
    Route::get('/start', [PreOrderController::class, 'start'])->name('pre-order.start');
    
    // Success page after order completion
    Route::get('/success', [PreOrderController::class, 'success'])->name('pre-order.success');
    
    // Order confirmation (with order number)
    Route::get('/confirmation/{registration}', [PreOrderController::class, 'confirmation'])
        ->name('pre-order.confirmation');
    
    // Payment routes
    Route::get('/payment/success/{order}', [PreOrderController::class, 'paymentSuccess'])
        ->name('pre-order.payment.success');
    
    Route::get('/payment/cancel/{order}', [PreOrderController::class, 'paymentCancel'])
        ->name('pre-order.payment.cancel');
});

// Additional pages
Route::get('/privacy-policy', function () {
    return view('pages.privacy-policy');
})->name('privacy-policy');

Route::get('/terms-of-service', function () {
    return view('pages.terms-of-service');
})->name('terms-of-service');

Route::get('/cancellation-refund-policy', function () {
    return view('pages.cancellation-policy');
})->name('cancellation-policy');

// Image proxy routes with rate limiting
Route::prefix('images')->middleware(['auth', 'signed', 'throttle:60,1'])->group(function () {
    Route::get('/proxy/{disk}/{path}', [ImageProxyController::class, 'proxy'])
        ->where('path', '.*')
        ->name('images.proxy');
    
    Route::get('/s3-temporary/{path}', [ImageProxyController::class, 'temporaryS3Url'])
        ->where('path', '.*')
        ->name('images.s3-temporary');
});

Route::prefix('downloads')->middleware(['auth', 'signed', 'throttle:30,1'])->group(function () {
    Route::get('/photo/{photo}/{order}/{download}', [DownloadController::class, 'downloadPhoto'])
        ->name('downloads.photo');

    Route::get('/batch/{order}/{download}', [DownloadController::class, 'downloadBatch'])
        ->name('downloads.batch');
});

// Health check endpoint for deployment monitoring
Route::get('/up', function () {
    return response()->json(['status' => 'ok', 'timestamp' => now()]);
})->name('health');
