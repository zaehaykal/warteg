<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        // Mengambil semua data dari tabel 'menu'
        $menus = Menu::all();
        return response()->json($menus);
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string',
            'harga' => 'required|numeric',
            'kategori' => 'required|string',
        ]);

        // Menyimpan data ke dalam tabel menu
        $menu = Menu::create($request->all());

        // Mengembalikan response json
        return response()->json($menu, 201);
    }


    public function show($id)
    {
        // Menampilkan data menu berdasarkan ID
        $menu = Menu::find($id);
        if (!$menu) {
            return response()->json(['message' => 'Menu not found'], 404);
        }
        return response()->json($menu);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'string',
            'harga' => 'numeric',
            'kategori' => 'string',
        ]);

        // Mengupdate data menu berdasarkan ID
        $menu = Menu::find($id);
        if (!$menu) {
            return response()->json(['message' => 'Menu not found'], 404);
        }

        $menu->update($request->only(['nama', 'harga', 'kategori']));
        return response()->json($menu);
    }

    public function destroy($id)
    {
        // Menghapus data menu berdasarkan ID
        $menu = Menu::find($id);
        if (!$menu) {
            return response()->json(['message' => 'Menu not found'], 404);
        }

        $menu->delete();
        return response()->json(['message' => 'Menu deleted successfully']);
    }
}
