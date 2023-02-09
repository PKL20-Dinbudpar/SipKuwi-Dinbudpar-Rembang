<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\ResetPassword;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\SignUp;
use App\Http\Livewire\UserProfile;

// Dinas
use App\Http\Livewire\Dinas\DaftarHotel;
use App\Http\Livewire\Dinas\DaftarUser;
use App\Http\Livewire\Dinas\DaftarWisata;
use App\Http\Livewire\Dinas\EditRekap;
use App\Http\Livewire\Dinas\EditRekapHotel;
use App\Http\Livewire\Dinas\RekapWisataHarian;
use App\Http\Livewire\Dinas\RekapHotelHarian;
use App\Http\Livewire\Dinas\RekapHotelBulanan;
use App\Http\Livewire\Dinas\RekapWisataBulanan;
use App\Http\Livewire\Guest\Dashboard;
// Wisata
use App\Http\Livewire\Wisata\DaftarTransaksi;
use App\Http\Livewire\Wisata\RekapKunjungan;
use App\Http\Livewire\Wisata\TicketingWisata;

// Hotel
use App\Http\Livewire\Hotel\RekapKunjunganHotel;

// Guest
use App\Http\Livewire\Guest\KunjunganWisataBulanan;
use App\Http\Livewire\Guest\KunjunganWisataHarian;

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
        // return redirect('/dashboard');
    }
})->name('home');

// Auth Routes
// Route::get('/sign-up', SignUp::class)->name('sign-up');
Route::get('/login', Login::class)->name('login');
Route::get('/login/forgot-password', ForgotPassword::class)->name('forgot-password');
Route::get('/reset-password/{id}',ResetPassword::class)->name('reset-password')->middleware('signed');

// Guest Routes
Route::get('/dashboard', Dashboard::class)->name('dashboard');
Route::get('/wisata-harian', KunjunganWisataHarian::class)->name('kunjungan-wisata-harian');
Route::get('/wisata-bulanan', KunjunganWisataBulanan::class)->name('kunjungan-wisata-bulanan');

// Route for Dinas
Route::middleware(['auth', 'user-role:dinas'])->group(function () {
    Route::get('/rekap-wisata', RekapWisataHarian::class)->name('rekap-wisata-harian');
    Route::get('/rekap-wisata-bulanan', RekapWisataBulanan::class)->name('rekap-wisata-bulanan');
    Route::get('/edit-rekap-wisata:{idWisata?}', EditRekap::class)->name('edit-rekap-wisata');
    Route::get('/daftar-wisata', DaftarWisata::class)->name('daftar-wisata');

    Route::get('/rekap-hotel', RekapHotelHarian::class)->name('rekap-hotel-harian');
    Route::get('/rekap-hotel-bulanan', RekapHotelBulanan::class)->name('rekap-hotel-bulanan');
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

