<?php

namespace App\Http\Controllers;

use App\Models\Admins; // Ganti dengan nama model yang sesuai
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Menampilkan semua data admin
    public function index()
    {
        $admins = Admins::all(); // Mengambil semua data admin
        return response()->json($admins); // Mengembalikan data dalam format JSON
    }

    // Menyimpan data admin baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string',
            'nomorhp' => 'required|string',
            'jenkel' => 'required|string',
            'role' => 'required|string',
            'email' => 'required|string|email|unique:admins',
            'password' => 'required|string|min:8',
        ]);

        // Membuat data admin baru dengan hashing password
        $admin = Admins::create([
            'nama' => $request->nama,
            'nomorhp' => $request->nomorhp,
            'jenkel' => $request->jenkel,
            'role' => $request->role,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash password
        ]);

        return response()->json($admin, 201); // Mengembalikan data admin yang baru dibuat
    }

    // Menampilkan data admin berdasarkan ID
    public function show($id)
    {
        $admin = Admins::find($id); // Mencari admin berdasarkan ID

        if (!$admin) {
            return response()->json(['message' => 'Admin not found'], 404); // Menangani jika admin tidak ditemukan
        }

        return response()->json($admin); // Mengembalikan data admin
    }

    // Memperbarui data admin berdasarkan ID
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'string',
            'nomorhp' => 'string',
            'jenkel' => 'string',
            'role' => 'string',
            'email' => 'string|email|unique:admins,email,' . $id,
            'password' => 'string|min:8',
        ]);

        $admin = Admins::find($id); // Mencari admin berdasarkan ID

        if (!$admin) {
            return response()->json(['message' => 'Admin not found'], 404); // Menangani jika admin tidak ditemukan
        }

        // Mengupdate data admin
        $admin->update(array_merge($request->only(['nama', 'nomorhp', 'jenkel', 'role', 'email']), [
            'password' => $request->password ? Hash::make($request->password) : $admin->password // Hash password jika ada
        ]));

        return response()->json($admin); // Mengembalikan data admin yang telah diperbarui
    }

    // Menghapus data admin berdasarkan ID
    public function destroy($id)
    {
        $admin = Admins::find($id); // Mencari admin berdasarkan ID

        if (!$admin) {
            return response()->json(['message' => 'Admin not found'], 404); // Menangani jika admin tidak ditemukan
        }

        $admin->delete(); // Menghapus data admin

        return response()->json(['message' => 'Admin deleted successfully']); // Mengembalikan pesan sukses
    }
}
