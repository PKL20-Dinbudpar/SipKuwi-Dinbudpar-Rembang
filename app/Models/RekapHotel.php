<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapHotel extends Model
{
    use HasFactory;

    // Table
    protected $table = 'rekap_hotel';
    protected $primaryKey = 'id_rekap';

    // Fillable
    protected $fillable = ['tanggal', 'id_hotel', 'pengunjung_nusantara', 'pengunjung_mancanegara', 'kamar_terjual', ];

    // dates
    protected $dates = ['tanggal'];

    protected $casts = [
        'tanggal' => 'date:Y-m-d'
    ];


    // Timestamp
    public $timestamps = false;

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'id_hotel', 'id_hotel');
    }
}
