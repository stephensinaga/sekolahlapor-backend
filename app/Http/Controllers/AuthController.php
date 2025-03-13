<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function registerApi(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'user', // Default role untuk pengguna API
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully!',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    // ✅ API: Login (hanya untuk "user" dan "petugas")
    public function loginApi(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        //  Periksa apakah email terdaftar
        if (!User::where('email', $request->email)->exists()) {
            return response()->json(['message' => 'Email tidak terdaftar'], 404);
        }

        //  Cek apakah login berhasil
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        $user = Auth::user();

        //  Hanya "user" dan "petugas" yang boleh login via API
        if (!in_array($user->role, ['user', 'petugas'])) {
            Auth::logout();
            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'Login successful!',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function getUser()
    {
        return response()->json([
            'user' => Auth::user()
        ]);
    }

    public function getProfile()
    {
        $user = Auth::user(); // Mendapatkan data user yang sedang login
        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    // ✅ API: Logout (Hapus Semua Token)
    public function logoutApi(Request $request)
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    // Web: Menampilkan halaman login
    public function loginview()
    {
        return view('auth/login');
    }

    // Web: Login hanya untuk "admin" dan "superadmin"
    public function loginWeb(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withErrors(['error' => 'Email atau password salah']);
        }

        $user = Auth::user();

        if (!in_array($user->role, ['admin', 'superadmin'])) {
            Auth::logout();
            return back()->withErrors(['error' => 'Akses ditolak']);
        }

        return redirect()->route('Dashboard'); // ✅ Pastikan route-nya benar
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Logout berhasil!');
    }
}
