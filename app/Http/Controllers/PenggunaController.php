<?php

namespace App\Http\Controllers;

use App\Http\Resources\pengguna\PenggunaResources;
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

    public function imageUpload($id)
    {
        // Ambil pengguna berdasarkan ID jika perlu
        $pengguna = Pengguna::find($id);
        if (!$pengguna) {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan.');
        }

        return view('uploadImage', compact('pengguna')); // Pass pengguna to view if needed
    }


    public function show($id)
    {
        $pengguna = Pengguna::find($id);
        if (!$pengguna) { // Check if user is not found
            return response()->json(['message' => 'Pengguna tidak ditemukan'], 404);
        }
        //return response()->json($pengguna);

        return new PenggunaResources($pengguna);
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

    public function getImage($image)
    {
        $url = 'http://localhost/warteg/public/uploads/' . $image;

        // Inisiasi cURL
        $ch = curl_init($url);

        // Setel opsi cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        // Eksekusi cURL
        $result = curl_exec($ch);

        // Cek apakah ada error
        if (curl_errno($ch)) {
            curl_close($ch);
            return 'Error: ' . curl_error($ch);
        }

        curl_close($ch);

        // Kembalikan hasil
        return $result;
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $pengguna = Pengguna::where('email', $request->email)->first();

        if (!$pengguna || !Hash::check($request->password, $pengguna->password)) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        $token = bin2hex(random_bytes(16)); // Contoh token acak sederhana
        return response()->json(['message' => 'Login berhasil', 'token' => $token, 'data' => new PenggunaResources($pengguna)], 200);
    }

    
}
