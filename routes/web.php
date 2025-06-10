<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// Pastikan semua controller di-import di sini
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvestmentController;
// TAMBAHKAN IMPORT UNTUK CONTROLLER ADMIN
use App\Http\Controllers\Admin\DashboardController; // Jika Anda membuatnya
use App\Http\Controllers\Admin\CriteriaController;
use App\Http\Controllers\Admin\SubCriteriaController;
use App\Http\Controllers\Admin\InvestmentInstrumentController;
use App\Http\Controllers\Admin\ScoreController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// LANDING PAGE AWAL (PUBLIK - SEBELUM LOGIN)
Route::get('/', function () {
    return view('welcome');
})->name('landing');

// Authentication Routes
Route::get('/login', [LoginRegisterController::class, 'login'])->name('login');
Route::post('/login', [LoginRegisterController::class, 'authenticate']);
Route::get('/register', [LoginRegisterController::class, 'register'])->name('register');
Route::post('/register', [LoginRegisterController::class, 'store']);
Route::post('/logout', [LoginRegisterController::class, 'logout'])->name('logout');


// -------------- SEMUA RUTE DI BAWAH INI MEMBUTUHKAN LOGIN --------------
Route::group(['middleware' => ['auth']], function () {

    // Rute dashboard utama yang mengarahkan berdasarkan role setelah login
    Route::get('/dashboard', function () {
        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('home');
        }
    })->name('dashboard');

    // Rute Halaman Utama (Home) InvestWise untuk user yang sudah login
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // ... rute-rute user lainnya ...
    Route::get('/user/recommendation', [RecommendationController::class, 'index'])->name('user.recommendation');
    Route::post('/user/recommendation/calculate', [RecommendationController::class, 'calculate'])->name('user.recommendation.calculate');
    Route::get('/articles', [ArticlesController::class, 'index'])->name('articles');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/investment/{type}', [InvestmentController::class, 'show'])->name('investment.show');


    // ==========================================================
    // ==         INI BAGIAN YANG PERLU ANDA LENGKAPI          ==
    // ==========================================================
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        
        // Dashboard khusus admin (Gunakan controller jika ada logika data)
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Rute untuk CRUD Kriteria Utama
        Route::resource('criterias', CriteriaController::class);

        // Rute untuk CRUD Sub-Kriteria
        Route::resource('sub-criterias', SubCriteriaController::class);

        // Rute untuk CRUD Instrumen Investasi
        Route::resource('investment-instruments', InvestmentInstrumentController::class);

        // Rute untuk Halaman Input Skor
        Route::get('scores', [ScoreController::class, 'index'])->name('scores.index');
        Route::post('scores', [ScoreController::class, 'store'])->name('scores.store');
    });

});