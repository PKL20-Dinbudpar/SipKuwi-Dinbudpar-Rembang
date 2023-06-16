<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapWisata extends Model
{
    use HasFactory;

    // Table
    protected $table = 'rekap_wisata';
    protected $primaryKey = 'id_rekap';

    // Fillable
        protected $fillable = ['tanggal', 'id_wisata', 'wisatawan_nusantara', 'wisatawan_mancanegara', 'total_pendapatan', 'id_user'];

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
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
