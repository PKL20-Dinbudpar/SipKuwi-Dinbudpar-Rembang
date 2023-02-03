<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\ResetPassword;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\SignUp;
use App\Http\Livewire\DaftarHotel;
use App\Http\Livewire\DaftarTransaksi;
use App\Http\Livewire\DaftarUser;
use App\Http\Livewire\DaftarWisata;
use App\Http\Livewire\EditRekap;
use App\Http\Livewire\EditRekapHotel;

use App\Http\Livewire\LaravelExamples\UserProfile;
use App\Http\Livewire\RekapBulanan;
use App\Http\Livewire\RekapHotelBulanan;
use App\Http\Livewire\RekapHotelTahunan;
use App\Http\Livewire\RekapKunjungan;
use App\Http\Livewire\RekapKunjunganHotel;
use App\Http\Livewire\RekapTahunan;
use App\Http\Livewire\TicketingWisata;
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
            return redirect('/rekap-kunjungan-wisata');
        } else if (Auth::user()->role == 'hotel'){
            return redirect('/rekap-kunjungan-hotel');
        }
    } else {
        return redirect('/login');
    }
})->name('home');

// Auth Routes
// Route::get('/sign-up', SignUp::class)->name('sign-up');
Route::get('/login', Login::class)->name('login');
Route::get('/login/forgot-password', ForgotPassword::class)->name('forgot-password');
Route::get('/reset-password/{id}',ResetPassword::class)->name('reset-password')->middleware('signed');

// Route for Dinas
Route::middleware(['auth', 'user-role:dinas'])->group(function () {
    Route::get('/rekap-wisata', RekapBulanan::class)->name('rekap-wisata-harian');
    Route::get('/rekap-wisata-bulanan', RekapTahunan::class)->name('rekap-wisata-bulanan');
    Route::get('/edit-rekap-wisata:{idWisata?}', EditRekap::class)->name('edit-rekap-wisata');
    Route::get('/daftar-wisata', DaftarWisata::class)->name('daftar-wisata');

    Route::get('/rekap-hotel', RekapHotelBulanan::class)->name('rekap-hotel-harian');
    Route::get('/rekap-hotel-bulanan', RekapHotelTahunan::class)->name('rekap-hotel-bulanan');
    Route::get('/edit-rekap-hotel:{idHotel?}', EditRekapHotel::class)->name('edit-rekap-hotel');
    Route::get('/daftar-hotel', DaftarHotel::class)->name('daftar-hotel');

    Route::get('/daftar-user', DaftarUser::class)->name('daftar-user');
});

// Route for Wisata
Route::middleware(['auth', 'user-role:wisata'])->group(function () {
    Route::get('/ticketing', TicketingWisata::class)->name('ticketing');
    Route::get('/daftar-transaksi', DaftarTransaksi::class)->name('daftar-transaksi');
    Route::get('/rekap-kunjungan-wisata', RekapKunjungan::class)->name('rekap-kunjungan-wisata');
});

Route::middleware(['auth', 'user-role:hotel'])->group(function () {
    Route::get('/rekap-kunjungan-hotel', RekapKunjunganHotel::class)->name('rekap-kunjungan-hotel');
});

Route::middleware('auth')->group(function () {
    Route::get('/user-profile', UserProfile::class)->name('user-profile');
});

