<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\ResetPassword;
use App\Http\Livewire\Auth\SignUp;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Billing;
use App\Http\Livewire\DaftarTransaksi;
use App\Http\Livewire\DaftarUser;
use App\Http\Livewire\DaftarWisata;
use App\Http\Livewire\DinasHome;
use App\Http\Livewire\EditRekap;
use App\Http\Livewire\Profile;
use App\Http\Livewire\Tables;
use App\Http\Livewire\StaticSignIn;
use App\Http\Livewire\StaticSignUp;
use App\Http\Livewire\Rtl;

use App\Http\Livewire\LaravelExamples\UserProfile;
use App\Http\Livewire\LaravelExamples\UserManagement;
use App\Http\Livewire\RekapBulanan;
use App\Http\Livewire\RekapKunjungan;
use App\Http\Livewire\RekapKunjunganHotel;
use App\Http\Livewire\RekapTahunan;
use App\Http\Livewire\TicketingWisata;
use App\Http\Livewire\WisataHome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role == 'dinas'){
            return redirect('/rekap-wisata');
        } else if (Auth::user()->role == 'wisata'){
            return redirect('/wisata-home');
        }
    } else {
        return redirect('/login');
    }
})->name('home');

// Auth Routes
Route::get('/sign-up', SignUp::class)->name('sign-up');
Route::get('/login', Login::class)->name('login');
Route::get('/login/forgot-password', ForgotPassword::class)->name('forgot-password');
Route::get('/reset-password/{id}',ResetPassword::class)->name('reset-password')->middleware('signed');

// Route for Dinas
Route::middleware(['auth', 'user-role:dinas'])->group(function () {
    Route::get('/rekap-wisata', RekapBulanan::class)->name('rekap-wisata-bulanan');
    Route::get('/rekap-wisata-tahunan', RekapTahunan::class)->name('rekap-wisata-tahunan');
    Route::get('/edit-rekap-wisata{idWisata?}', EditRekap::class)->name('edit-rekap-wisata');
    Route::get('/daftar-wisata', DaftarWisata::class)->name('daftar-wisata');
    Route::get('/daftar-user', DaftarUser::class)->name('daftar-user');
});

// Route for Wisata
Route::middleware(['auth', 'user-role:wisata'])->group(function () {
    Route::get('/wisata-home', WisataHome::class)->name('home-wisata');
    Route::get('/ticketing', TicketingWisata::class)->name('ticketing');
    Route::get('/daftar-transaksi', DaftarTransaksi::class)->name('daftar-transaksi');
    Route::get('/rekap-kunjungan', RekapKunjungan::class)->name('rekap-kunjungan');
});

Route::middleware(['auth', 'user-role:hotel'])->group(function () {
    Route::get('/rekap-kunjungan-hotel', RekapKunjunganHotel::class)->name('rekap-kunjungan-hotel');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/billing', Billing::class)->name('billing');
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/tables', Tables::class)->name('tables');
    Route::get('/static-sign-in', StaticSignIn::class)->name('sign-in');
    Route::get('/static-sign-up', StaticSignUp::class)->name('static-sign-up');
    Route::get('/rtl', Rtl::class)->name('rtl');
    Route::get('/laravel-user-profile', UserProfile::class)->name('user-profile');
    Route::get('/laravel-user-management', UserManagement::class)->name('user-management');
});

