<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;


class AdminPetugasController extends Controller
{
    // Menampilkan daftar petugas
    public function index()
    {
        $petugas = User::where('role', 'petugas')->get();
        return view('admin.petugas.index', compact('petugas'));
    }

    // Menampilkan form tambah petugas
    public function create()
    {
        return view('admin.petugas.create');
    }

    // Menyimpan petugas baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'petugas', // Set peran sebagai petugas
        ]);

        return redirect()->route('admin.petugas.index')->with('success', 'Petugas berhasil ditambahkan!');
    }

    // Menampilkan form edit petugas
    public function edit($id)
    {
        $petugas = User::findOrFail($id);
        return view('admin.petugas.edit', compact('petugas'));
    }

    // Memperbarui data petugas
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|string|email|max:255|unique:users,email,$id",
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $petugas = User::findOrFail($id);
        $petugas->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return redirect()->route('admin.petugas.index')->with('success', 'Petugas berhasil diperbarui!');
        $petugas = User::findOrFail($id);
        $petugas->delete();

        return redirect()->route('admin.petugas.index')->with('success', 'Petugas berhasil dihapus!');
    }
}
