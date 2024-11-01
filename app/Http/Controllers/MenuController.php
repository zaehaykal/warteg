<?php

namespace App\Http\Controllers;

use App\Models\Menu; // Pastikan ini sesuai dengan namespace model Menu
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        // Mengambil semua data dari tabel 'menu'
        $menus = Menu::all();

        if ($menus->isEmpty()) {
            return response()->json([
                'message'=>'Tidak ada Data',
                'data' => []
            ], 404);
        }
        return response()->json([
            'message'=> 'Data berhasil di muat',
            'data' => $menus]);
        
    }

    public function show($id)
    {
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json(['message' => 'Menu not found'], 404);
        }

        return response()->json($menu);
    }

    // Menyimpan data menu baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|string|max:225',
            'kategori' => 'required|string|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max size 2MB
        ]);

        // Mengupload file foto
        $filename = null; // Inisialisasi variabel filename
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename); // Menyimpan file di folder 'public/uploads'
        }

        // Membuat  data menu baru
        $menu = Menu::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'kategori' => $request->kategori,
            'foto' => $filename, // Menyimpan nama file di database
        ]);

        return response()->json(['message' => 'Berhasil input data', 'data' => $menu], 201);
    }

    public function update(Request $request, $id)
    {
        // Mencari menu berdasarkan ID
        $menu = Menu::find($id);

        // Validasi input
        $request->validate([
            'nama' => 'nullable|string|max:255',
            'harga' => 'nullable|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max size 2MB
        ]);

        if (!$menu) {
            return response()->json(['message' => 'Menu tidak ditemukan'], 404);
        }

        // Proses upload foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($menu->foto) {
                // Hapus foto dari folder uploads
                if (file_exists(public_path('uploads/' . $menu->foto))) {
                    unlink(public_path('uploads/' . $menu->foto)); // Menghapus foto yang sudah ada
                }
            }
            // Simpan foto baru dan update path di database
            $filename = time() . '.' . $request->file('foto')->getClientOriginalExtension();
            $request->file('foto')->move(public_path('uploads'), $filename);
            $menu->foto = $filename; // Update nama file di database
        }

        // Mengupdate data menu, termasuk nama, harga, dan kategori
        $menu->update($request->only(['nama', 'harga', 'kategori']));

        return response()->json(['message' => 'Berhasil memperbarui data', 'data' => $menu], 200);
    }

    public function destroy($id)
    {
        $menu = Menu::find($id); // Mencari menu berdasarkan ID

        if (!$menu) {
            return response()->json(['message' => 'menu not found'], 404); // Menangani jika menu tidak ditemukan
        }

        $menu->delete(); // Menghapus data menu

        return response()->json(['message' => 'menu deleted successfully']); // Mengembalikan pesan sukses
    }
}
