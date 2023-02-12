<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    // Table
    protected $table = 'receipt';
    protected $primaryKey = 'id';
    protected $fillable = ['id_transaksi', 'id_tiket', 'jumlah_tiket', 'total_pendapatan'];

    // Timestamp
    public $timestamps = false;

    // Relation
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }

    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'id_tiket', 'id_tiket');
    }
}
