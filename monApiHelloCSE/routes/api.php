<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\CommentaireController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', [LoginController::class, 'login']);

//Endpoint Public
Route::get('/profils/public', [ProfilController::class, 'indexPublic']);

// Endpoints protégés par authentification
Route::middleware('auth:sanctum')->group(function () {
    // Profils
    Route::post('/profils', [ProfilController::class, 'store']);
    Route::put('/profils/{profil}', [ProfilController::class, 'update']); // Ou PATCH
    Route::delete('/profils/{profil}', [ProfilController::class, 'destroy']);
    Route::get('/profils/{profil}', [ProfilController::class, 'show']); // Endpoint pour voir un profil avec son statut (authentifié)

    // Commentaires
    Route::post('/profils/{profil}/commentaires', [CommentaireController::class, 'store']);

});
