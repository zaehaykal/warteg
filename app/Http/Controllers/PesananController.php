<?php

namespace App\Http\Controllers;

use App\Models\pesanan;
use App\Models\subpesanan;
use Illuminate\Http\Request;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;

class PesananController extends Controller
{
    public function index()
    {
        // Mendapatkan semua pesanan
        return pesanan::all();
    }

    public function store(Request $request)
    {
        // Validasi dan menyimpan pesanan baru
        $request->validate([
            'pengguna_id' => 'required|integer',
            'total_harga' => 'required|numeric',
            'tanggal_pesanan' => 'required|date'
        ]);

        $pesanan = pesanan::create($request->all());

        return response()->json($pesanan, 200);
    }

    public function show($id)
    {
        // Mendapatkan pesanan berdasarkan ID
        $pesanan = pesanan::find($id);

        if (!$pesanan) {
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        }

        return $pesanan;
    }

    public function destroy($id)
    {
        // Menghapus pesanan berdasarkan ID
        $pesanan = pesanan::find($id);

        if (!$pesanan) {
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        }   

        $pesanan->delete();

        return response()->json(['message' => 'Pesanan berhasil dihapus']);
    }
}
