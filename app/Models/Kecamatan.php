<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    // Table
    protected $table = 'kecamatan';
    protected $primaryKey = 'id_kecamatan';
    protected $fillable = ['id_kecamatan', 'nama_kecamatan'];

    // Timestamp
    public $timestamps = false;

    // Relation
    public function wisata()
    {
        return $this->hasMany(Wisata::class, 'id_kecamatan', 'id_kecamatan');
    }

    // Getter
    public function getNamaKecamatan()
    {
        return $this->nama_kecamatan;
    }

    public function getWisata()
    {
        return $this->wisata->count();
    }
}
