<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Import semua controller yang dibutuhkan
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvestmentController;
use App\Models\InvestmentInstrument;
use App\Models\Criteria;
use App\Models\CalculationHistory;
use App\Http\Controllers\Admin\InvestmentInstrumentController as AdminInvestmentInstrumentController;

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

// --- RUTE PUBLIK (SEBELUM LOGIN) ---
Route::get('/', function () {
    return view('welcome'); // Menampilkan resources/views/welcome.blade.php
})->name('landing');

// Autentikasi
Route::get('/login', [LoginRegisterController::class, 'login'])->name('login');
Route::post('/login', [LoginRegisterController::class, 'authenticate']);
Route::get('/register', [LoginRegisterController::class, 'register'])->name('register');
Route::post('/register', [LoginRegisterController::class, 'store']);
Route::post('/logout', [LoginRegisterController::class, 'logout'])->name('logout');


// --- SEMUA RUTE DI BAWAH INI BUTUH LOGIN ---
Route::middleware(['auth'])->group(function () {

    // Rute dashboard utama yang mengarahkan berdasarkan role setelah login
    Route::get('/dashboard', function () {
        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            // Setelah user biasa login, arahkan ke rute 'home'
            return redirect()->route('home');
        }
    })->name('home'); // Nama rute ini adalah 'dashboard'

    // Rute untuk User Biasa
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Rute lain yang diakses oleh user yang sudah login
    // Ini adalah rute yang sebelumnya ada di grup 'user.'
    Route::get('/user/recommendation', [RecommendationController::class, 'intro'])->name('user.recommendation.intro');
    Route::post('/user/recommendation/calculate', [RecommendationController::class, 'calculate'])->name('user.recommendation.calculate');
    Route::get('/user/recommendation/questions/{step?}', [App\Http\Controllers\RecommendationController::class, 'showQuestion'])->name('user.recommendation.questions');
    Route::post('/user/recommendation/questions/submit', [App\Http\Controllers\RecommendationController::class, 'submitQuestion'])->name('user.recommendation.submit_question');

    // Rute umum lain yang membutuhkan autentikasi
    Route::get('/articles', [ArticlesController::class, 'index'])->name('articles');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::get('/profile/history', [ProfileController::class, 'history'])->name('profile.history');
    
    Route::get('/investment/{type}', [InvestmentController::class, 'show'])->name('investment.show');

    // Rute untuk menampilkan history perhitungan di profil user
    Route::get('/profile/history', [ProfileController::class, 'history'])->name('profile.history');


    // Route untuk Admin (hanya admin yang sudah login)
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            $jumlahInstrument = InvestmentInstrument::count();
            $jumlahKriteria = Criteria::count();
            $jumlahPerhitungan = CalculationHistory::count();
    
            $rekomendasiTeratas = [];
            $latestHistory = CalculationHistory::latest()->first();
            if ($latestHistory) {
                $rekomendasiTeratas = $latestHistory->calculated_rankings;
            }
    
            return view('admin.dashboard', compact('jumlahInstrument', 'jumlahKriteria', 'jumlahPerhitungan', 'rekomendasiTeratas'));
        })->name('dashboard');
        Route::resource('investment-instruments', AdminInvestmentInstrumentController::class); // Ini akan membuat index, create, store, edit, update, show, destroy
        
        Route::resource('criterias', AdminCriteriaController::class);

        // ... rute subcriterias tambahan (jika ada) ...
        Route::get('criterias/{criteria}/subcriterias', [AdminCriteriaController::class, 'manageSubCriterias'])->name('criterias.subcriterias.index');// ...
        // Tambahkan lebih banyak rute khusus admin di sini
        // Contoh: Route::get('/manage-instruments', [AdminController::class, 'instruments'])->name('instruments');
    });
});