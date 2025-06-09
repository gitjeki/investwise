<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecommendationsController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvestmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// LANDING PAGE AWAL (PUBLIK - SEBELUM LOGIN)
// Hanya route ini yang bisa diakses tanpa login.
Route::get('/', function () {
    return view('welcome'); // Menampilkan resources/views/welcome.blade.php
})->name('landing');

// Authentication Routes (ini juga harus bisa diakses publik)
Route::get('/login', [LoginRegisterController::class, 'login'])->name('login');
Route::post('/login', [LoginRegisterController::class, 'authenticate']);
Route::get('/register', [LoginRegisterController::class, 'register'])->name('register');
Route::post('/register', [LoginRegisterController::class, 'store']);
Route::post('/logout', [LoginRegisterController::class, 'logout'])->name('logout');


// -------------- SEMUA RUTE DI BAWAH INI MEMBUTUHKAN LOGIN --------------
Route::group(['middleware' => ['auth']], function () {

    // Setelah login, arahkan ke halaman utama InvestWise
    // Jika home.blade.php adalah halaman utama InvestWise, arahkan ke sana.
    // Jika Anda punya dashboard khusus untuk user setelah login, arahkan ke sana.
    // Untuk skenario ini, mari kita asumsikan setelah login langsung ke Home InvestWise.
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    // Jika HomeController::index() menampilkan user.home.blade.php, maka ini yang benar.
    // Jika Anda ingin nama rutenya tetap 'home', bisa diubah:
    // Route::get('/home', [HomeController::class, 'index'])->name('home');
    // Lalu di LoginRegisterController, set $redirectTo = '/home';

    // INVESTWISE AUTHENTICATED ROUTES (Hanya bisa diakses setelah login)
    // Semua rute ini harus berada di dalam grup middleware 'auth'.
    Route::get('/home', [HomeController::class, 'index'])->name('home'); // Ini adalah home InvestWise yang sekarang di bawah auth
    Route::get('/recommendations', [RecommendationsController::class, 'index'])->name('recommendations');
    Route::get('/articles', [ArticlesController::class, 'index'])->name('articles');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/investment/{type}', [InvestmentController::class, 'show'])->name('investment.show');


    // Route untuk Admin (hanya admin yang sudah login)
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard'); // Dashboard khusus admin
        })->name('dashboard');
        // Tambahkan lebih banyak rute khusus admin di sini
    });

    // Route untuk User (hanya user yang sudah login)
    // Sebaiknya, rute user dashboard ini dipisah jika ada konten spesifik user yang beda dari home.
    Route::middleware('role:user')->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', function () {
            return view('user.home'); // Dashboard khusus user
        })->name('home');
        // Tambahkan lebih banyak rute khusus user di sini
    });
});