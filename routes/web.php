<?php

use App\Http\Controllers\Google2FAController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwoFactorController;

Route::get('/dashboard',[HomeController::class,'redirectCustomize'])->middleware(['auth','verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/2fa/enable', [Google2FAController::class, 'enable'])->name('2fa.enable');
    Route::post('/2fa/verify', [Google2FAController::class, 'verify'])->name('2fa.verify');
});
// Challenge 2FA lors de la connexion (sans middleware auth)
Route::get('/2fa/challenge', [Google2FAController::class, 'showChallenge'])->name('2fa.challenge');
Route::post('/2fa/verify-login', [Google2FAController::class, 'verifyLogin'])->name('2fa.verify.login');
require __DIR__ . '/front.php';
require __DIR__ . '/admin.php';

require __DIR__.'/auth.php';
