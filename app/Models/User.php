<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'phone',
        'alamat',
        'photo',
        'password',
        'role',
        'id_wisata',
        'id_hotel',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = ['deleted_at'];

    public function wisata()
    {
        return $this->belongsTo(Wisata::class, 'id_wisata', 'id_wisata');
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'id_hotel', 'id_hotel');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_user', 'id_user');
    }
    public function rekapWisata()
    {
        return $this->hasMany(RekapWisata::class, 'id_user', 'id_user');
    }
    public function rekapHotel()
    {
        return $this->hasMany(RekapHotel::class, 'id_user', 'id_user');
    }
}
