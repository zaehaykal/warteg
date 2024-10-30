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

        if ($pengguna->isEmpty()) {
            return response()->json([
                'message' => 'Tidak ada data pengguna ditemukan.',
                'data' => []
            ], 404);
        }

        return response()->json([
            'message' => 'Data pengguna berhasil diambil.',
            'data' => $pengguna
        ], 200);
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

            return response()->json(['message' => 'Berhasil input data', 'data' => $pengguna], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menyimpan data', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $pengguna = Pengguna::find($id);

        if (!$pengguna) {
            return response()->json(['message' => 'Pengguna tidak ditemukan'], 404);
        }

        $request->validate([
            'nama' => 'nullable|string|max:255',
            'nohp' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'nullable|string|email|max:255|unique:pengguna,email,' . $id,
            'password' => 'nullable|string|min:8',
        ]);

        // Menangani upload foto jika ada
        if ($request->hasFile('foto')) {
            if ($pengguna->foto && file_exists(public_path('uploads/' . $pengguna->foto))) {
                unlink(public_path('uploads/' . $pengguna->foto));
            }

            $filename = time() . '.' . $request->file('foto')->getClientOriginalExtension();
            $request->file('foto')->move(public_path('uploads'), $filename);
            $pengguna->foto = $filename; // Update nama file di database
        }

        // Mengupdate data pengguna
        $pengguna->fill($request->only(['nama', 'nohp', 'alamat', 'email']));

        // Mengupdate password hanya jika diisi
        if ($request->filled('password')) {
            $pengguna->password = Hash::make($request->password);
        }

        $pengguna->save();

        return response()->json(['message' => 'Berhasil Memperbarui Pengguna', 'data' => $pengguna], 200 > 299);
    }

    public function destroy($id)
    {
        $pengguna = Pengguna::find($id);
        if (!$pengguna) {
            return response()->json(['message' => 'Pengguna Tidak Ditemukan']);
        }
        $pengguna->delete();
        return response()->json(['message' => 'Pengguna Berhasil Dihapus']);
    }
}
