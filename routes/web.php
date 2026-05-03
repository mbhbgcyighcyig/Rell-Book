<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Peminjam\DashboardController as PeminjamDashboard;
use App\Http\Controllers\Peminjam\BookController as PeminjamBook;
use App\Http\Controllers\Peminjam\LoanController as PeminjamLoan;
use App\Http\Controllers\Peminjam\ProfileController as PeminjamProfile;
use App\Http\Controllers\Peminjam\ReturnRequestController as PeminjamReturn;
use App\Http\Controllers\ReturnRequestController as StaffReturn;
use App\Http\Controllers\Peminjam\RatingController as PeminjamRating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

// ─── Admin Login Khusus ────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login',  [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('login.post');
    Route::post('/logout',[AdminLoginController::class, 'logout'])->name('logout');
});

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isPeminjam()
            ? redirect()->route('peminjam.dashboard')
            : redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// ─── Staff Routes (admin + petugas) ───────────────────────────────────────────
Route::middleware(['auth', 'role:admin,petugas'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('books', BookController::class);
    Route::resource('categories', CategoryController::class)->except(['show', 'create', 'edit']);

    Route::get('/loans',                    [LoanController::class, 'index'])->name('loans.index');
    Route::get('/loans/create',             [LoanController::class, 'create'])->name('loans.create');
    Route::post('/loans',                   [LoanController::class, 'store'])->name('loans.store');
    Route::get('/loan-history',             [LoanController::class, 'history'])->name('loans.history');
    Route::patch('/loans/{loan}/return',    [LoanController::class, 'returnBook'])->name('loans.return');
    Route::patch('/loans/{loan}/pay-fine',  [LoanController::class, 'payFine'])->name('loans.pay-fine');
    Route::patch('/loans/{loan}/confirm',   [LoanController::class, 'confirmLoan'])->name('loans.confirm');
    Route::patch('/loans/{loan}/reject',    [LoanController::class, 'rejectLoan'])->name('loans.reject');
    Route::get('/loans/{loan}/nota',        [LoanController::class, 'notaLoan'])->name('loans.nota');
    Route::get('/loans/{loan}',             [LoanController::class, 'show'])->name('loans.show');

    // Return Requests dari peminjam
    Route::get('/return-requests',                          [StaffReturn::class, 'index'])->name('returns.staff.index');
    Route::patch('/return-requests/{returnRequest}/confirm',[StaffReturn::class, 'confirm'])->name('returns.staff.confirm');
    Route::patch('/return-requests/{returnRequest}/reject', [StaffReturn::class, 'reject'])->name('returns.staff.reject');

    Route::get('/reports',               [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/loans',         [ReportController::class, 'loans'])->name('reports.loans');
    Route::get('/reports/popular-books', [ReportController::class, 'popularBooks'])->name('reports.popular-books');
    Route::get('/reports/fines',         [ReportController::class, 'fines'])->name('reports.fines');
});

// ─── Admin + Petugas — Data Petugas di halaman Anggota ───────────────────────
Route::middleware(['auth', 'role:admin,petugas'])->group(function () {
    Route::resource('members', MemberController::class);
});

// ─── Admin Only ────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/users',              [UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}',    [UserController::class, 'destroy'])->name('users.destroy');
});

// ─── Peminjam Routes ───────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:peminjam'])->prefix('peminjam')->name('peminjam.')->group(function () {
    Route::get('/dashboard',            [PeminjamDashboard::class, 'index'])->name('dashboard');
    Route::get('/books',                [PeminjamBook::class, 'index'])->name('books');
    Route::get('/books/{book}',         [PeminjamBook::class, 'show'])->name('book.detail');
    Route::get('/loans',                [PeminjamLoan::class, 'index'])->name('loans');
    Route::post('/loans/request',       [PeminjamLoan::class, 'request'])->name('loans.request');
    Route::delete('/loans/{loan}/cancel',[PeminjamLoan::class, 'cancelRequest'])->name('loans.cancel');
    Route::get('/loans/{loan}/nota',    [PeminjamLoan::class, 'nota'])->name('loans.nota');
    Route::get('/loans/{loan}',         [PeminjamLoan::class, 'show'])->name('loan.detail');    Route::get('/profile',              [PeminjamProfile::class, 'index'])->name('profile');
    Route::put('/profile',              [PeminjamProfile::class, 'update'])->name('profile.update');
    Route::put('/profile/password',     [PeminjamProfile::class, 'changePassword'])->name('profile.password');
    Route::post('/ratings',             [PeminjamRating::class, 'store'])->name('ratings.store');
    Route::delete('/ratings',           [PeminjamRating::class, 'destroy'])->name('ratings.destroy');
    Route::get('/returns',              [PeminjamReturn::class, 'index'])->name('returns.index');
    Route::post('/returns',             [PeminjamReturn::class, 'store'])->name('returns.store');
    Route::delete('/returns/{returnRequest}', [PeminjamReturn::class, 'cancel'])->name('returns.cancel');
    Route::get('/returns/{loan}/nota',  [PeminjamReturn::class, 'nota'])->name('returns.nota');
    Route::get('/about',                fn() => view('peminjam.about'))->name('about');
    Route::get('/ulasan',               [PeminjamRating::class, 'index'])->name('ulasan.index');});
