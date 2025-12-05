<?php

use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
Route::get('/', [HomeController::class, 'accueil'])->name('accueil');

Route::prefix('contenus')->group(function () {

    Route::get('/', [HomeController::class, 'all'])->name('contenus.all');
    Route::get('/detail/{contenu}', [HomeController::class, 'ShowContentDetail'])->name('contenu.detail')->middleware(['auth','a_payé']);
    Route::post('/{contenu}/commentaires', [HomeController::class, 'StoreUserComment'])
        ->middleware(['auth'])
        ->name('comment.store');
    Route::patch('/commentaires/{commentaire}', [CommentaireController::class, 'UpdateUserComment'])
        ->middleware(['auth'])
        ->name('comment.update');
    Route::delete('/commentaires/{commentaire}', [HomeController::class, 'destroy'])
        ->middleware(['auth', 'verified'])
        ->name('commentaires.destroy.user');
});
Route::post('/paiement/callback/',[PaymentController::class,'callback'])->name('paiement.callback');
Route::prefix('media')->group(function () {

    Route::get('/', [HomeController::class, 'showmedias'])->name('media.all');
    Route::get('/{media}',[HomeController::class, 'OneMedia'])->name('media.detail');

});
