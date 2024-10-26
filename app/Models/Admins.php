<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admins extends Model
{
    use HasFactory;

    // Menentukan nama tabel (opsional, jika tabel mengikuti konvensi Laravel, tidak perlu)
    protected $table = 'admins';

    // Menentukan field yang bisa diisi
    protected $fillable = [
        'nama' => 'required|string|max:255',
            'nohp' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'foto' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:255',    
    ];
}
