<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PreOrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Pre-Order Form Routes
Route::prefix('pre-order')->group(function () {
    // Start pre-order (redirects to Filament wizard)
    Route::get('/start', [PreOrderController::class, 'start'])->name('pre-order.start');
    
    // Success page after order completion
    Route::get('/success', [PreOrderController::class, 'success'])->name('pre-order.success');
    
    // Order confirmation (with order number)
    Route::get('/confirmation/{registration}', [PreOrderController::class, 'confirmation'])
        ->name('pre-order.confirmation');
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

