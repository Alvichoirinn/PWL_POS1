<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Praktikum 4 Jobsheet 3 (Implementasi DB Facade)
Route::get('/level', [LevelController::class, 'index']);

// Praktikum 5 Jobsheet 3 
Route ::get('/kategori', [KategoriController::class, 'index']);