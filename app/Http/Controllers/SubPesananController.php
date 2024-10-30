<?php

namespace App\Http\Controllers;

use App\Models\subpesanan;
use Illuminate\Http\Request;

class SubpesananController extends Controller
{
    public function index($pesanan_id)
    {
        // Mendapatkan semua subpesanan untuk pesanan tertentu
        return subpesanan::where('pesanan_id', $pesanan_id)->get();
    }

    public function store(Request $request, $pesanan_id)
    {
        // Validasi dan menyimpan subpesanan baru
        $request->validate([
            'pesanan_id' => 'required|integer',
            'menu_id' => 'required|integer',
            'nama_menu' => 'required|string',
            'quantity' => 'required|integer',
            'harga' => 'required|integer',
            'total' => 'required|numeric'
        ]);

        $subpesanan = new subpesanan($request->all());
        $subpesanan->pesanan_id = $pesanan_id;
        $subpesanan->save();

        return response()->json($subpesanan, 201);
    }

    public function show($pesanan_id, $id)
    {
        // Mendapatkan subpesanan berdasarkan ID di pesanan tertentu
        $subpesanan = subpesanan::where('pesanan_id', $pesanan_id)->find($id);

        if (!$subpesanan) {
            return response()->json(['message' => 'Subpesanan tidak ditemukan'], 404);
        }

        return $subpesanan;
    }

    public function destroy($pesanan_id, $id)
    {
        // Menghapus subpesanan berdasarkan ID di pesanan tertentu
        $subpesanan = subpesanan::where('pesanan_id', $pesanan_id)->find($id);

        if (!$subpesanan) {
            return response()->json(['message' => 'Subpesanan tidak ditemukan'], 404);
        }

        $subpesanan->delete();

        return response()->json(['message' => 'Subpesanan berhasil dihapus']);
    }
}