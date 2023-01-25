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
    protected $fillable = ['tanggal', 'id_wisata', 'wisatawan_domestik', 'wisatawan_mancanegara', 'total_pendapatan'];

    // dates
    protected $dates = ['tanggal'];

    // Timestamp
    public $timestamps = false;

    // Relation
    public function wisata()
    {
        return $this->belongsTo(Wisata::class, 'id_wisata', 'id_wisata');
    }

    // Getters
    public function getNamaWisata()
    {
        return $this->wisata->nama_wisata;
    }
}
