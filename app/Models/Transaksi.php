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
    protected $fillable = ['waktu_transaksi', 'id_wisata', 'id_user', 'jenis_wisatawan', 'jumlah_tiket', 'total_pendapatan'];

    // dates
    protected $dates = ['waktu_transaksi'];
    
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

    public function receipt()
    {
        return $this->hasMany(Receipt::class, 'id_transaksi', 'id_transaksi');
    }
}
