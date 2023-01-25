<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    // Table
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $fillable = ['waktu_transaksi', 'id_wisata', 'id_user', 'id_tiket', 'jumlah_tiket', 'total_pendapatan'];

    // Timestamp
    public $timestamps = false;

    // Relation
    public function wisata()
    {
        return $this->belongsTo(Wisata::class, 'id_wisata', 'id_wisata');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'id_tiket', 'id_tiket');
    }

    // Getter
    public function getWisata()
    {
        return $this->wisata->nama_wisata;
    }

    public function getPengguna()
    {
        return $this->pengguna->nama;
    }

    public function getTiket()
    {
        return $this->tiket->nama_tiket;
    }

    public function getJumlahTiket()
    {
        return $this->jumlah_tiket;
    }

    public function getTotalPendapatan()
    {
        return 'Rp. ' . number_format($this->total_pendapatan, 0, ',', '.');
    }

    public function formatPendapatan($value)
    {
        return 'Rp. ' . number_format($value, 0, ',', '.');
    }

    public function getWaktuTransaksi()
    {
        return $this->waktu_transaksi;
    }

    public function getWaktuTransaksiAttribute($value)
    {
        return date('d-m-Y H:i:s', strtotime($value));
    }

    public function getJumlahTransaksiHarian()
    {
        return $this->whereDate('waktu_transaksi', date('Y-m-d'))->count();
    }

    public function getJumlahTransaksiBulanan()
    {
        return $this->whereMonth('waktu_transaksi', date('m'))->count();
    }

    public function getJumlahTransaksiTahunan()
    {
        return $this->whereYear('waktu_transaksi', date('Y'))->count();
    }

    // Getter by id_wisata
    public function getJumlahTransaksiHarianWisata($id_wisata)
    {
        return $this->whereDate('waktu_transaksi', date('Y-m-d'))->where('id_wisata', $id_wisata)->count();
    }
    
    public function getJumlahTransaksiBulananWisata($id_wisata)
    {
        return $this->whereMonth('waktu_transaksi', date('Y-m'))->where('id_wisata', $id_wisata)->count();
    }

    public function getJumlahTransaksiTahunanWisata($id_wisata)
    {
        return $this->whereYear('waktu_transaksi', date('Y'))->where('id_wisata', $id_wisata)->count();
    }

    public function getJumlahTiketHarianWisata($id_wisata)
    {
        return $this->whereDate('waktu_transaksi', date('Y-m-d'))->where('id_wisata', $id_wisata)->sum('jumlah_tiket');
    }

    public function getJumlahTiketBulananWisata($id_wisata)
    {
        return $this->whereMonth('waktu_transaksi', date('Y-m'))->where('id_wisata', $id_wisata)->sum('jumlah_tiket');
    }

    public function getJumlahTiketTahunanWisata($id_wisata)
    {
        return $this->whereYear('waktu_transaksi', date('Y'))->where('id_wisata', $id_wisata)->sum('jumlah_tiket');
    }

    public function getPendapatanHarianWisata($id_wisata)
    {
        return $this->formatPendapatan($this->whereDate('waktu_transaksi', date('Y-m-d'))->where('id_wisata', $id_wisata)->sum('total_pendapatan'));
    }

    public function getPendapatanBulananWisata($id_wisata)
    {
        return $this->formatPendapatan($this->whereMonth('waktu_transaksi', date('Y-m'))->where('id_wisata', $id_wisata)->sum('total_pendapatan'));
    }

    public function getPendapatanTahunanWisata($id_wisata)
    {
        return $this->formatPendapatan($this->whereYear('waktu_transaksi', date('Y'))->where('id_wisata', $id_wisata)->sum('total_pendapatan'));
    }
}
