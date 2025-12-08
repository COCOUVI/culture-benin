<?php

use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\ContenuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LangueController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TypeContenuController;
use App\Http\Controllers\TypeMediaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('/admin')->middleware(['auth','admin.ou.manager'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::resource('langues', LangueController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('type_media', TypeMediaController::class);
    Route::resource('type_contenu', TypeContenuController::class);
    Route::resource('users', UserController::class);
    Route::resource('regions', RegionController::class);
    Route::resource('contenus', ContenuController::class);

    Route::resource('medias', MediaController::class);
    Route::resource('commentaires', CommentaireController::class);
});
