<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'home']);
Route::get('/gerar-exercicios', [MainController::class, 'gerarExercicios']);
Route::get('/imprimir-exercicios', [MainController::class, 'imprimirExercicios']);
Route::get('/exportar-exercicios', [MainController::class, 'exportarExercicios']);
