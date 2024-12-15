<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function index()
    {
        $users = User::all();

        if ($users->isEmpty()) {
            return response()->json([
                'message' => 'Tidak ada data pengguna ditemukan.',
                'data' => []
            ], 404);
        }
        return response()->json([
            'message' => 'Data pengguna berhasil diambil.',
            'data' => $users
        ], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email harus diisi',
            'password.required' => 'Password harus diisi',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Periksa kredensial Anda.'
            ], 401);
        }

        $tokenHasil = $user->createToken($user->name)->plainTextToken;
        $token = explode("|", $tokenHasil)[1];

        return response()->json([
            'message' => 'Login Berhasil',
            'token' => $token,
            'data' => $user,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Berhasil Logout'], 200);
    }

    public function me()
    {
        $data = Auth::user();

        return response()->json([
            'user' => [
                'id' => $data->id,
                'name' => $data->name,
                'nomorhp' => $data->nomorhp,
                'role' => $data->role,
                'email' => $data->email
            ]
        ], 200);
    }

    public function register(Request $request)
    {
        $request->validate([
            'role' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'nomorhp' => 'required|string|max:255',
            'foto' => 'nullable|file|mimes:jpeg,png,jpg,gif',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'alamat' => 'required|string|max:255',
            'jenkel' => 'required|string|max:255',
        ]);

        $filename = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $extension = $file->getClientOriginalExtension();
            $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif'];
            if (in_array(strtolower($extension), $allowedExtensions)) {
                $filename = time() . '.' . $extension;
                $file->move(public_path('uploads'), $filename);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Ekstensi file tidak didukung. Hanya file JPEG, JPG, PNG, dan GIF yang diperbolehkan.'
                ], 400);
            }
        }


        try {
            $user = User::create([
                'role' => $request->role,
                'name' => $request->name,
                'nomorhp' => $request->nomorhp,
                'foto' => $filename,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'alamat' => $request->alamat,
                'jenkel' => $request->jenkel,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Registrasi berhasil',
                'user' => $user,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal registrasi',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
