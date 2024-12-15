<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Promotion extends Model
{
    use HasFactory;

    protected $table = 'promotions'; 
    protected $fillable = [
        'menu_id',
        'show_on_dashboard',
        'discount'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
