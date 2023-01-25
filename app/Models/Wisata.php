<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Wisata extends Model
{
    use HasFactory;

    // Table
    protected $table = 'wisata';
    protected $primaryKey = 'id_wisata';
    protected $fillable = ['nama_wisata', 'alamat', 'id_kecamatan'];

    // Timestamp
    public $timestamps = false;

    // Relation
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id_kecamatan');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'id_wisata', 'id_wisata');
    }

    public function pengguna()
    {
        return $this->hasMany(Pengguna::class, 'id_wisata', 'id_wisata');
    }

    public function tiket()
    {
        return $this->hasMany(Tiket::class, 'id_wisata', 'id_wisata');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_wisata', 'id_wisata');
    }

    public function rekap()
    {
        return $this->hasMany(Rekap::class, 'id_wisata', 'id_wisata');
    }

    // Getter
    public function getKecamatan()
    {
        return $this->kecamatan->nama_kecamatan;
    }

    public function getNamaWisata()
    {
        return $this->nama_wisata;
    }

    public function getAlamat()
    {
        return $this->alamat;
    }

    public function getPengguna()
    {
        return $this->pengguna->count();
    }

    public function getTiket()
    {
        return $this->tiket->count();
    }
}
