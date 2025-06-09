<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvestmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// LANDING PAGE AWAL (PUBLIK - SEBELUM LOGIN)
Route::get('/', function () {
    return view('welcome');
})->name('landing');

// Authentication Routes (ini juga harus bisa diakses publik)
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
            // Setelah user biasa login, arahkan ke rute 'home'
            return redirect()->route('home');
        }
    })->name('home'); // Nama rute ini adalah 'dashboard'

    // Rute Halaman Utama (Home) InvestWise untuk user yang sudah login
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Rute lain yang diakses oleh user yang sudah login
    // Ini adalah rute yang sebelumnya ada di grup 'user.'
    Route::get('/user/recommendation', [RecommendationController::class, 'index'])->name('user.recommendation');
    Route::post('/user/recommendation/calculate', [RecommendationController::class, 'calculate'])->name('user.recommendation.calculate');
    
    // Rute umum lain yang membutuhkan autentikasi
    Route::get('/articles', [ArticlesController::class, 'index'])->name('articles');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/investment/{type}', [InvestmentController::class, 'show'])->name('investment.show');


    // Route untuk Admin (hanya admin yang sudah login)
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard'); // Dashboard khusus admin
        })->name('dashboard');
        // Tambahkan lebih banyak rute khusus admin di sini
        // Contoh: Route::get('/manage-instruments', [AdminController::class, 'instruments'])->name('instruments');
    });

    // Catatan: Grup 'user.' di bawah ini Dihapus atau Diubah.
    // Karena rute utama user setelah login adalah '/home', dan '/user/recommendation'
    // sudah dipindahkan ke grup middleware 'auth' utama di atas.
    // Jika ada rute spesifik user lain yang masih memerlukan prefix '/user',
    // bisa buat grup terpisah atau pertimbangkan kembali strukturnya.
    /*
    // Contoh jika Anda ingin tetap ada grup user dengan prefix '/user'
    Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
        // Jika Anda masih ingin ada halaman dashboard khusus user selain '/home'
        // Route::get('/dashboard', function () {
        //     return view('user.dashboard');
        // })->name('dashboard');

        // Rute rekomendasi sudah dipindahkan ke grup 'auth' utama di atas
        // Route::get('/recommendation', [App\Http\Controllers\RecommendationController::class, 'index'])->name('recommendation');
        // Route::post('/recommendation/calculate', [App\Http\Controllers\RecommendationController::class, 'calculate'])->name('recommendation.calculate');
    });
    */
});