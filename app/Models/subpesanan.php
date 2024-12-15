<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subpesanan extends Model
{
    use HasFactory;

    protected $table = 'subpesanan';

    protected $fillable = [
        'pesanan_id',
        'menu_id',
        'nama',
        'foto',
        'kategori',
        'jumlah',
        'harga'
    ];
 
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id', 'id');
    }

 
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }
}
