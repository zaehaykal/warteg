<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'nohp',
        'alamat',
        'total_harga',
        'status'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
 
    public function subpesanan()
    {
        return $this->hasMany(Subpesanan::class);
    }
}
