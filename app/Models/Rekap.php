<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekap extends Model
{
    use HasFactory;

    // Table
    protected $table = 'rekap';
    protected $primaryKey = 'id_rekap';

    // Fillable
        protected $fillable = ['tanggal', 'id_wisata','id_hotel', 'wisatawan_nusantara', 'wisatawan_mancanegara', 'total_pendapatan', 'kamar_terjual', ];

    // dates
    protected $dates = ['tanggal'];

    protected $casts = [
        'tanggal' => 'date:Y-m-d'
    ];


    // Timestamp
    public $timestamps = false;

    // Relation
    public function wisata()
    {
        return $this->belongsTo(Wisata::class, 'id_wisata', 'id_wisata');
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'id_hotel', 'id_hotel');
    }

    // Getters
    public function getNamaWisata()
    {
        return $this->wisata->nama_wisata;
    }
}
