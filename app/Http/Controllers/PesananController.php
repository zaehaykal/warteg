<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Subpesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with('subpesanan')->get();

        return response()->json([
            'success' => true,
            'listOrder' => $pesanan,
        ], 200);
    }
    public function showOrderMenu()
    {

        $subpesanan = Subpesanan::with('menu')->get();


        if ($subpesanan->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada subpesanan ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $subpesanan,
        ]);
    }

    public function showOrder($id)
    {
        $pesanan = Pesanan::where('id', $id)
            ->with(['subpesanan.menu'])
            ->first();

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data pesanan berhasil ditemukan.',
            'dataOrder' => [
                'pesanan' => $pesanan,
            ],
        ], 200);
    }

    public function show($id)
    {
        $pesanan = Pesanan::with('subpesanan')->find($id);

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $pesanan,
        ], 200);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama' => 'required|string|max:255',
            'nohp' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'total_harga' => 'required|numeric',
            'status' => 'required|string|in:pending,completed,canceled',
            'menu_items' => 'required|array',
            'menu_items.*.menu_id' => 'required|exists:menu,id',
            'menu_items.*.nama' => 'required|string',
            'menu_items.*.foto' => 'nullable|string',
            'menu_items.*.kategori' => 'nullable|string',
            'menu_items.*.jumlah' => 'required|integer',
            'menu_items.*.harga' => 'required|numeric',
        ]);


        $pesanan = Pesanan::create([
            'user_id' => $validated['user_id'],
            'nama' => $validated['nama'],
            'nohp' => $validated['nohp'],
            'alamat' => $validated['alamat'],
            'total_harga' => $validated['total_harga'],
            'status' => $validated['status'],
        ]);

        $subPesananList = [];

        foreach ($validated['menu_items'] as $menu_item) {

            $fotoPath = $menu_item['foto'] ?? null;


            $subPesanan = Subpesanan::create([
                'pesanan_id' => $pesanan->id,
                'menu_id' => $menu_item['menu_id'],
                'nama' => $menu_item['nama'],
                'foto' => $fotoPath,
                'kategori' => $menu_item['kategori'],
                'jumlah' => $menu_item['jumlah'],
                'harga' => $menu_item['harga'],
            ]);


            $subPesananList[] = $subPesanan;
        }


        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibuat.',
            'pesanan' => $pesanan,
            'subPesanan' => $subPesananList,
        ], 201);
    }





































































    public function destroy($id)
    {

        $pesanan = Pesanan::find($id);

        if (!$pesanan) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan.',
            ], 404);
        }


        foreach ($pesanan->subpesanan as $subpesanan) {
            if ($subpesanan->foto) {
                $fotoPath = public_path($subpesanan->foto);
                if (file_exists($fotoPath)) {
                    unlink($fotoPath);
                }
            }
        }


        $pesanan->subpesanan()->delete();


        $pesanan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pesanan dan foto terkait berhasil dihapus.',
        ], 200);
    }
}
