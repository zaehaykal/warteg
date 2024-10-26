<?php

namespace App\Http\Controllers;

use App\Models\Pengguna; // Use singular and camel case
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Log;

class PenggunaController extends Controller
{
    public function index()
    {
        $pengguna = Pengguna::all();
        return response()->json($pengguna);
    }

    public function show($id)
    {
        $pengguna = Pengguna::find($id);
        if (!$pengguna) { // Check if user is not found
            return response()->json(['message' => 'Pengguna tidak ditemukan'], 404);
        }
        return response()->json($pengguna);
    }

    public function store(Request $request)
    {
        // Validasi permintaan yang masuk
        $request->validate([
            'nama' => 'required|string|max:255',
            'nohp' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'required|string|email|max:255|unique:pengguna', // Kembali ke nama tabel yang benar
            'password' => 'required|string|min:8', // Validasi panjang minimum password
        ]);

        // Menangani upload file
        $filename = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
        }

        try {
            // Membuat pengguna baru
            $pengguna = Pengguna::create([
                'nama' => $request->nama,
                'nohp' => $request->nohp,
                'alamat' => $request->alamat,
                'foto' => $filename,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                
            ]);

            return response()->json(['message' => 'Berhasil input data', 'data' => $pengguna], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menyimpan data', 'error' => $e->getMessage()], 500);
        }
    }
}
