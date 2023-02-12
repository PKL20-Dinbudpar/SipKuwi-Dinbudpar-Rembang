<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;

    // Table
    protected $table = 'tiket';
    protected $primaryKey = 'id_tiket';
    protected $fillable = ['id_wisata', 'nama_tiket', 'harga', 'deskripsi'];

    // Timestamp
    public $timestamps = false;

    // Relation
    public function wisata()
    {
        return $this->belongsTo(Wisata::class, 'id_wisata', 'id_wisata');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_tiket', 'id_tiket');
    }

    public function receipt()
    {
        return $this->hasMany(Receipt::class, 'id_tiket', 'id_tiket');
    }
}
