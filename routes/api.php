<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisiteurController;
use App\Http\Controllers\FraisController;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

# @Input : json pwd_visiteur
//Route::post('/visiteur/initpwds',[VisiteurController::class, 'initPasswords']);

Route::post('/visiteur/login',[VisiteurController::class, 'login']);

Route::get('/visiteur/unauth',[VisiteurController::class, 'unauthorized'])->name('login');

Route::get('/visiteur/logout',[VisiteurController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/frais/{idFrais}', [FraisController::class, 'getFraisById'])->middleware('auth:sanctum');

Route::post('/frais/ajout', [FraisController::class, 'ajoutFrais'])->middleware('auth:sanctum');

Route::post('/frais/modif', [FraisController::class, 'modifFrais'])->middleware('auth:sanctum');

Route::delete('/frais/suppr', [FraisController::class, 'supprFrais'])->middleware('auth:sanctum');

Route::get('/frais/liste/{idVisiteur}', [FraisController::class, 'getListeVisiteur'])->middleware('auth:sanctum');
