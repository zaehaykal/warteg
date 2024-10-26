<?php

namespace App\Http\Controllers;

use App\Models\pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index()
    {
        $pengguna = pengguna::all();
        return response()->json($pengguna);
    }

    public function show($id)
    {
        $pengguna = pengguna::find($id);
        if (!$pengguna) { // Memeriksa jika pengguna tidak ditemukan
            return response()->json(['message' => 'Pengguna Tidak Ditemukan'], 404);
        }
        return response()->json($pengguna);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nohp' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'required|string|email|max:255|unique:pengguna', // Validasi email unik
            'password' => 'required|string|min:8', // Validasi password minimum 8 karakter
        ]);

        $filename = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
        }
 
        $pengguna = pengguna::create([
            'nama' => $request->nama,
            'nohp' => $request->nohp,
            'alamat' => $request->alamat,
            'foto' => $filename, // Menggunakan nama file yang diupload
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Berhasil input data', 'data' => $pengguna], 201);
    }
    
}
