<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Import semua controller yang dibutuhkan
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\RecommendationController;

// Controller untuk Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CriteriaController as AdminCriteriaController;
use App\Http\Controllers\Admin\SubCriteriaController as AdminSubCriteriaController;
use App\Http\Controllers\Admin\InvestmentInstrumentController as AdminInvestmentInstrumentController;
use App\Http\Controllers\Admin\ScoreController as AdminScoreController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- RUTE PUBLIK (SEBELUM LOGIN) ---
Route::get('/', function () {
    return view('welcome');
})->name('landing');

// Autentikasi
Route::get('/login', [LoginRegisterController::class, 'login'])->name('login');
Route::post('/login', [LoginRegisterController::class, 'authenticate']);
Route::get('/register', [LoginRegisterController::class, 'register'])->name('register');
Route::post('/register', [LoginRegisterController::class, 'store']);
Route::post('/logout', [LoginRegisterController::class, 'logout'])->name('logout');


// --- SEMUA RUTE DI BAWAH INI BUTUH LOGIN ---
Route::middleware(['auth'])->group(function () {

    // Pengarah utama setelah login
    Route::get('/dashboard', function () {
        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('home');
    })->name('dashboard');

    // Rute untuk User Biasa
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // INI DIA RUTE YANG HILANG
    Route::get('/articles', [ArticlesController::class, 'index'])->name('articles');

    Route::get('/user/recommendation', [RecommendationController::class, 'index'])->name('user.recommendation');
    Route::post('/user/recommendation/calculate', [RecommendationController::class, 'calculate'])->name('user.recommendation.calculate');

    // Pengaturan Profil User
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::get('/profile/history', [ProfileController::class, 'history'])->name('profile.history');
    
    Route::get('/investment/{type}', [InvestmentController::class, 'show'])->name('investment.show');


    // --- GRUP RUTE KHUSUS ADMIN ---
    Route::middleware('checkrole:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('criterias', AdminCriteriaController::class);
        Route::resource('sub-criterias', AdminSubCriteriaController::class);
        Route::resource('investment-instruments', AdminInvestmentInstrumentController::class);
        Route::get('scores', [AdminScoreController::class, 'index'])->name('scores.index');
        Route::post('scores', [AdminScoreController::class, 'store'])->name('scores.store');
        Route::resource('articles', AdminArticleController::class);
    });
});
