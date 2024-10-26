<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subpesanan extends Model
{
    use HasFactory;
    
    protected $table = 'subpesanan';

    protected $fillable = [
        'pesanan_id',
        'menu_id',
        'nama_id',
        'quantity',
        'harga',
        'total'
    ];
}
