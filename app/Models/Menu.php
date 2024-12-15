<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';

    protected $fillable = [
        'nama',
        'harga',
        'kategori',
        'foto',
    ];

    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }
    public function subpesanan()
    {
        return $this->hasMany(Subpesanan::class, 'menu_id', 'id');
    }
}
