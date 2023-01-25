<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;

    // Table
    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    protected $fillable = ['username', 'password', 'nama', 'role', 'id_wisata'];

    // Timestamp
    public $timestamps = false;

    // Relation
    public function wisata()
    {
        return $this->belongsTo(Wisata::class, 'id_wisata', 'id_wisata');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_pengguna', 'id_pengguna');
    }

    // Getter
    public function getWisata()
    {
        return $this->wisata->nama_wisata;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getNama()
    {
        return $this->nama;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getTransaksi()
    {
        return $this->transaksi->count();
    }
}
