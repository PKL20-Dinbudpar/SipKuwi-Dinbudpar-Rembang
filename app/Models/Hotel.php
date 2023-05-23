<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    // table
    protected $table = 'hotel';

    // primary key
    public $primaryKey = 'id_hotel';
    protected $fillable = ['nama_hotel', 'alamat', 'id_kecamatan'];

    // timestamps
    public $timestamps = false;

    // relationships
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id_kecamatan');
    }

    public function user()
    {
        return $this->hasMany(User::class, 'id_hotel', 'id_hotel');
    }
    public function rekap()
    {
        return $this->hasMany(RekapHotel::class, 'id_hotel', 'id_hotel');
    }
}
