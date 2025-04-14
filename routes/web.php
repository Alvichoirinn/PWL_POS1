<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangController;

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
Route::get('/kategori', [KategoriController::class, 'index']);

// Praktikum 6 Jobsheet 3
Route::get('/user', [UserController::class, 'index']);

// Praktikum 2.6 Jobsheet 4
Route::get('/user/tambah', [UserController::class, 'tambah']);

// Praktikum 2.6 Jobsheet 4
Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);

// Praktikum 2.6 Jobsheet 4 nomor 12
Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);

// Praktikum 2.6 Jobsheet 4 nomor 15
Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);

// Praktikum 2.6 Jobsheet 4 nomor 18
Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);

// Praktikum 2 (Penerapan Layouting) Jobsheet 5 nomor 4
Route::get('/', [WelcomeController::class, 'index']);

// Praktikum 3 (Implementasi jQuery Datatable di AdminLTE) Jobsheet 5 nomor 3
Route::group(['prefix' => 'user'], function(){
    Route::get('/', [UserController::class, 'index']); // menampilkan halaman awal user
    Route::post('/list', [UserController::class, 'list']); // menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create']); // menampilkan halaman form tambah user
    Route::post('/', [UserController::class, 'store']); // menyimpan data user baru
    Route::get('/create_ajax', [UserController::class, 'create_ajax']); // menampilkan halaman form tambah user ajax (jobsheet 6)
    Route::post('/ajax', [UserController::class, 'store_ajax']); // menyimpan data user baru ajax (jobsheet 6)
    Route::get('/{id}', [UserController::class, 'show']); // menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']); // menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']); // menyimpan perubahan data user
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); // menampilkan halaman form edit user Ajax (jobsheet 6)
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); // menyimpan perubahan data user Ajax (jobsheet 6)
    Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user
});

// Tugas Jobsheet 5
Route::group(['prefix' => 'level'], function() {
    Route::get('/', [LevelController::class, 'index']);       // Halaman daftar level
    Route::post('/list', [LevelController::class, 'list']);   // Data level untuk datatables (JSON)
    Route::get('/create', [LevelController::class, 'create']); // Form tambah level
    Route::post('/', [LevelController::class, 'store']);       // Simpan level baru
    Route::get('/{id}', [LevelController::class, 'show']);     // Detail level
    Route::get('/{id}/edit', [LevelController::class, 'edit']); // Form edit level
    Route::put('/{id}', [LevelController::class, 'update']);   // Simpan perubahan
    Route::delete('/{id}', [LevelController::class, 'destroy']); // Hapus level
});

// Routes for m_kategori
Route::group(['prefix' => 'kategori'], function() {
    Route::get('/', [KategoriController::class, 'index']);       // Halaman daftar kategori
    Route::post('/list', [KategoriController::class, 'list']);   // Data kategori untuk datatables (JSON)
    Route::get('/create', [KategoriController::class, 'create']); // Form tambah kategori
    Route::post('/', [KategoriController::class, 'store']);       // Simpan kategori baru
    Route::get('/{id}', [KategoriController::class, 'show']);     // Detail kategori
    Route::get('/{id}/edit', [KategoriController::class, 'edit']); // Form edit kategori
    Route::put('/{id}', [KategoriController::class, 'update']);   // Simpan perubahan kategori
    Route::delete('/{id}', [KategoriController::class, 'destroy']); // Hapus kategori
});

// Routes for m_supplier
Route::group(['prefix' => 'supplier'], function() {
    Route::get('/', [SupplierController::class, 'index']);       // Halaman daftar supplier
    Route::post('/list', [SupplierController::class, 'list']);   // Data supplier untuk datatables (JSON)
    Route::get('/create', [SupplierController::class, 'create']); // Form tambah supplier
    Route::post('/', [SupplierController::class, 'store']);       // Simpan supplier baru
    Route::get('/{id}', [SupplierController::class, 'show']);     // Detail supplier
    Route::get('/{id}/edit', [SupplierController::class, 'edit']); // Form edit supplier
    Route::put('/{id}', [SupplierController::class, 'update']);   // Simpan perubahan supplier
    Route::delete('/{id}', [SupplierController::class, 'destroy']); // Hapus supplier
});

// Routes for m_barang
Route::group(['prefix' => 'barang'], function() {
    Route::get('/', [BarangController::class, 'index']);       // Halaman daftar barang
    Route::post('/list', [BarangController::class, 'list']);   // Data barang untuk datatables (JSON)
    Route::get('/create', [BarangController::class, 'create']); // Form tambah barang
    Route::post('/', [BarangController::class, 'store']);       // Simpan barang baru
    Route::get('/{id}', [BarangController::class, 'show']);     // Detail barang
    Route::get('/{id}/edit', [BarangController::class, 'edit']); // Form edit barang
    Route::put('/{id}', [BarangController::class, 'update']);   // Simpan perubahan barang
    Route::delete('/{id}', [BarangController::class, 'destroy']); // Hapus barang
});
