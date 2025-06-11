<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecommendationController; // Pastikan ini RecommendationController, bukan RecommendationsController
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\Admin\CriteriaController as AdminCriteriaController; // Alias untuk Admin Criteria Controller

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

// LANDING PAGE AWAL (PUBLIK - SEBELUM LOGIN)
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

    // Rute dashboard utama yang mengarahkan berdasarkan role setelah login.
    // Ini adalah rute yang akan diakses setelah LoginRegisterController mengarahkan.
    // Pastikan LoginRegisterController mengarahkan ke 'home' atau 'admin.dashboard' langsung.
    // Rute ini berfungsi sebagai penangkap jika ada rute 'dashboard' lain yang masih dipanggil.
    Route::get('/dashboard', function () {
        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            // User biasa login, arahkan ke rute 'home'
            return redirect()->route('home');
        }
    })->name('dashboard'); // Nama rute ini adalah 'dashboard'


    // Rute Halaman Utama (Home) InvestWise untuk user yang sudah login
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // --- Rute untuk Alur Rekomendasi (Multistep Form) ---
    // Halaman pengantar rekomendasi. Ini menggantikan rute 'user.recommendation' yang lama.
    Route::get('/user/recommendation', [RecommendationController::class, 'intro'])->name('user.recommendation.intro');
    // Halaman pertanyaan preferensi (dengan parameter step opsional)
    Route::get('/user/recommendation/questions/{step?}', [RecommendationController::class, 'showQuestion'])->name('user.recommendation.questions');
    // Menyimpan jawaban pertanyaan dan pindah ke pertanyaan berikutnya
    Route::post('/user/recommendation/questions/submit', [RecommendationController::class, 'submitQuestion'])->name('user.recommendation.submit_question');
    // Proses perhitungan dan menampilkan hasil. Ini adalah rute POST akhir.
    Route::post('/user/recommendation/calculate', [RecommendationController::class, 'calculateAndShowResults'])->name('user.recommendation.calculate');
    // Halaman untuk melihat hasil rekomendasi (jika diakses langsung dari history atau lainnya)
    Route::get('/user/recommendation/results', [RecommendationController::class, 'showResults'])->name('user.recommendation.results');


    // Rute umum lain yang membutuhkan autentikasi
    Route::get('/articles', [ArticlesController::class, 'index'])->name('articles');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/investment/{type}', [InvestmentController::class, 'show'])->name('investment.show');

    // Rute untuk menampilkan history perhitungan di profil user
    Route::get('/profile/history', [ProfileController::class, 'showHistory'])->name('profile.history');


    // Route untuk Admin (hanya admin yang sudah login)
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard'); // Dashboard khusus admin
        })->name('dashboard'); // Nama rute ini adalah 'admin.dashboard'
        
        // --- CRUD untuk Kriteria ---
        // Menggunakan Route::resource untuk operasi CRUD standar (index, create, store, show, edit, update, destroy)
        Route::resource('criterias', AdminCriteriaController::class);
        // Rute khusus untuk mengelola sub-kriteria di bawah kriteria tertentu
        Route::get('criterias/{criteria}/subcriterias', [AdminCriteriaController::class, 'manageSubCriterias'])->name('criterias.subcriterias.index');
        Route::post('criterias/{criteria}/subcriterias', [AdminCriteriaController::class, 'storeSubCriteria'])->name('criterias.subcriterias.store');
        Route::put('subcriterias/{subcriteria}', [AdminCriteriaController::class, 'updateSubCriteria'])->name('subcriterias.update');
        Route::delete('subcriterias/{subcriteria}', [AdminCriteriaController::class, 'destroySubCriteria'])->name('subcriterias.destroy');

        // Tambahkan rute untuk CRUD instrumen investasi dan skornya jika diperlukan di masa mendatang
        // Route::resource('investment-instruments', AdminInvestmentController::class);
    });
});