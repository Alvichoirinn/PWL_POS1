<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\AuthController;


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
// Jobsheet 7 Praktikum 1 nomor 5
Route::pattern('id', '[0-9]+'); // artinya ketika ada parameter {id}, maka harus beruapa angka

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware(['auth'])->group(function () { // artinya semua route di dalam group ini harus login dulu

    // Route::get('/', function () {return view('welcome');});

    // Praktikum 4 Jobsheet 3 (Implementasi DB Facade)
    // Route::get('/level', [LevelController::class, 'index']);

    // // Praktikum 5 Jobsheet 3 
    // Route::get('/kategori', [KategoriController::class, 'index']);

    // // Praktikum 6 Jobsheet 3
    // Route::get('/user', [UserController::class, 'index']);

    // // Praktikum 2.6 Jobsheet 4
    // Route::get('/user/tambah', [UserController::class, 'tambah']);

    // // Praktikum 2.6 Jobsheet 4
    // Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);

    // // Praktikum 2.6 Jobsheet 4 nomor 12
    // Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);

    // // Praktikum 2.6 Jobsheet 4 nomor 15
    // Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);

    // // Praktikum 2.6 Jobsheet 4 nomor 18
    // Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);

    // Praktikum 2 (Penerapan Layouting) Jobsheet 5 nomor 4
    Route::get('/', [WelcomeController::class, 'index']);

    // Praktikum 3 (Implementasi jQuery Datatable di AdminLTE) Jobsheet 5 nomor 3
    Route::prefix('user')->middleware(['authorize:ADM, MNG'])->group(function () {
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
        Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // untuk tampilkan form confirm delete user Ajax (jobsheet 6)
        Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // untuk hapus data user ajax (jobsheet 6)
        Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user
    });

    // Tugas Jobsheet 5
    Route::prefix('level')->middleware(['authorize:ADM'])->group(function () {
        Route::get('/', [LevelController::class, 'index']);       // Halaman daftar level
        Route::post('/list', [LevelController::class, 'list']);   // Data level untuk datatables (JSON)
        Route::get('/create', [LevelController::class, 'create']); // Form tambah level
        Route::post('/', [LevelController::class, 'store']);       // Simpan level baru
        Route::get('/create_ajax', [LevelController::class, 'create_ajax']); // menampilkan halaman form tambah user ajax (jobsheet 6)
        Route::post('/ajax', [LevelController::class, 'store_ajax']); // menyimpan data user baru ajax (jobsheet 6)
        Route::get('/{id}', [LevelController::class, 'show']);     // Detail level
        Route::get('/{id}/edit', [LevelController::class, 'edit']); // Form edit level
        Route::put('/{id}', [LevelController::class, 'update']);   // Simpan perubahan
        Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']); // menampilkan halaman form edit user Ajax (jobsheet 6)
        Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']); // menyimpan perubahan data user Ajax (jobsheet 6)
        Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); // untuk tampilkan form confirm delete user Ajax (jobsheet 6)
        Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); // untuk hapus data user ajax (jobsheet 6)
        Route::delete('/{id}', [LevelController::class, 'destroy']); // Hapus level
    });


    // Routes for m_kategori
    Route::prefix('kategori')->middleware(['authorize:ADM, MNG, STF'])->group(function () {
        Route::get('/', [KategoriController::class, 'index']);       // Halaman daftar kategori
        Route::post('/list', [KategoriController::class, 'list']);   // Data kategori untuk datatables (JSON)
        Route::get('/create', [KategoriController::class, 'create']); // Form tambah kategori
        Route::post('/', [KategoriController::class, 'store']);       // Simpan kategori baru
        Route::get('/create_ajax', [KategoriController::class, 'create_ajax']); // menampilkan halaman form tambah user ajax (jobsheet 6)
        Route::post('/ajax', [KategoriController::class, 'store_ajax']); // menyimpan data user baru ajax (jobsheet 6)
        Route::get('/{id}', [KategoriController::class, 'show']);     // Detail kategori
        Route::get('/{id}/edit', [KategoriController::class, 'edit']); // Form edit kategori
        Route::put('/{id}', [KategoriController::class, 'update']);   // Simpan perubahan kategori
        Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']); // menampilkan halaman form edit user Ajax (jobsheet 6)
        Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']); // menyimpan perubahan data user Ajax (jobsheet 6)
        Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); // untuk tampilkan form confirm delete user Ajax (jobsheet 6)
        Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); // untuk hapus data user ajax (jobsheet 6)
        Route::delete('/{id}', [KategoriController::class, 'destroy']); // Hapus kategori
    });

    // Routes for m_supplier
    Route::prefix('supplier')->middleware(['authorize:ADM, MNG, STF'])->group(function () {
        Route::get('/', [SupplierController::class, 'index']);       // Halaman daftar supplier
        Route::post('/list', [SupplierController::class, 'list']);   // Data supplier untuk datatables (JSON)
        Route::get('/create', [SupplierController::class, 'create']); // Form tambah supplier
        Route::post('/', [SupplierController::class, 'store']);       // Simpan supplier baru
        Route::get('/create_ajax', [SupplierController::class, 'create_ajax']); // menampilkan halaman form tambah user ajax (jobsheet 6)
        Route::post('/ajax', [SupplierController::class, 'store_ajax']); // menyimpan data user baru ajax (jobsheet 6)
        Route::get('/{id}', [SupplierController::class, 'show']);     // Detail supplier
        Route::get('/{id}/edit', [SupplierController::class, 'edit']); // Form edit supplier
        Route::put('/{id}', [SupplierController::class, 'update']);   // Simpan perubahan supplier
        Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']); // menampilkan halaman form edit user Ajax (jobsheet 6)
        Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']); // menyimpan perubahan data user Ajax (jobsheet 6)
        Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); // untuk tampilkan form confirm delete user Ajax (jobsheet 6)
        Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // untuk hapus data user ajax (jobsheet 6)
        Route::delete('/{id}', [SupplierController::class, 'destroy']); // Hapus supplier
    });

    // Routes for m_barang
    Route::prefix('barang')->middleware(['authorize:ADM, MNG, STF'])->group(function () {
        Route::get('/', [BarangController::class, 'index']);       // Halaman daftar barang
        Route::post('/list', [BarangController::class, 'list']);   // Data barang untuk datatables (JSON)
        Route::get('/create', [BarangController::class, 'create']); // Form tambah barang
        Route::post('/', [BarangController::class, 'store']);       // Simpan barang baru
        Route::get('/create_ajax', [BarangController::class, 'create_ajax']); // menampilkan halaman form tambah user ajax (jobsheet 6)
        Route::post('/ajax', [BarangController::class, 'store_ajax']); // menyimpan data user baru ajax (jobsheet 6)
        Route::get('/{id}', [BarangController::class, 'show']);     // Detail barang
        Route::get('/{id}/edit', [BarangController::class, 'edit']); // Form edit barang
        Route::put('/{id}', [BarangController::class, 'update']);   // Simpan perubahan barang
        Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']); // menampilkan halaman form edit user Ajax (jobsheet 6)
        Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']); // menyimpan perubahan data user Ajax (jobsheet 6)
        Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // untuk tampilkan form confirm delete user Ajax (jobsheet 6)
        Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // untuk hapus data user ajax (jobsheet 6)
        Route::delete('/{id}', [BarangController::class, 'destroy']); // Hapus barang
    });


});