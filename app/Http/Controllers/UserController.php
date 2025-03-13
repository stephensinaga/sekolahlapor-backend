<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\ReportHistory;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // ✅ Dashboard: Menampilkan semua laporan sebagai berita (untuk user dan admin)
    // public function dashboard()
    // {
    //     $reports = Report::with('user')->latest()->paginate(10);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Dashboard - Semua Laporan',
    //         'data' => $reports
    //     ], 200);
    // }

    // // ✅ Ambil daftar laporan user sendiri
    // public function index()
    // {
    //     $reports = Report::where('user_id', Auth::id())->latest()->paginate(10);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'List Laporan Saya',
    //         'data' => $reports
    //     ], 200);
    // }

    // // ✅ Detail laporan (Admin bisa melihat semua, User hanya bisa melihat laporan sendiri)
    // public function show($id)
    // {
    //     $query = Report::where('id', $id)->with('user', 'histories');

    //     if (Auth::user()->role !== 'admin') {
    //         // Jika bukan admin, hanya bisa melihat laporan sendiri
    //         $query->where('user_id', Auth::id());
    //     }

    //     $report = $query->firstOrFail();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Detail Laporan',
    //         'data' => $report
    //     ], 200);
    // }

    // // ✅ Simpan laporan baru
    // public function store(Request $request)
    // {
    //     // Pastikan pengguna sudah login dengan token yang valid
    //     if (!Auth::check()) {
    //         return response()->json(['message' => 'Unauthorized'], 401);
    //     }

    //     $request->validate([
    //         'category' => 'required|string|in:Lingkungan,Kriminal,Sosial,Lalu Lintas',
    //         'photo_1' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    //         'photo_2' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    //         'photo_3' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    //         'description' => 'required|string',
    //         'latitude' => 'required|numeric|between:-90,90',
    //         'longitude' => 'required|numeric|between:-180,180',
    //         'address' => 'required|string',
    //     ]);

    //     // Proses menyimpan laporan
    //     $photo1 = $request->file('photo_1')->store('reports', 'public');
    //     $photo2 = $request->file('photo_2')->store('reports', 'public');
    //     $photo3 = $request->file('photo_3')->store('reports', 'public');

    //     $report = Report::create([
    //         'user_id' => Auth::id(),
    //         'category' => $request->category,
    //         'photo_1' => $photo1,
    //         'photo_2' => $photo2,
    //         'photo_3' => $photo3,
    //         'description' => $request->description,
    //         'latitude' => $request->latitude,
    //         'longitude' => $request->longitude,
    //         'address' => $request->address,
    //         'status' => 'pending',
    //     ]);

    //     return response()->json(['message' => 'Laporan berhasil dikirim', 'report' => $report], 201);
    // }

    // // ✅ Update status laporan oleh admin
    // public function updateStatus(Request $request, $id)
    // {
    //     if (Auth::user()->role !== 'admin') {
    //         return response()->json(['message' => 'Anda tidak memiliki izin'], 403);
    //     }

    //     $request->validate([
    //         'status' => 'required|in:pending,in_progress,accepted,rejected',
    //     ]);

    //     $report = Report::findOrFail($id);
    //     $report->update(['status' => $request->status]);

    //     // Simpan riwayat perubahan status
    //     ReportHistory::create([
    //         'report_id' => $report->id,
    //         'admin_id' => Auth::id(),
    //         'status' => $request->status,
    //     ]);

    //     return response()->json(['message' => 'Status laporan diperbarui', 'report' => $report]);
    // }

    // // ✅ Hapus laporan (hanya admin)
    // public function destroy($id)
    // {
    //     if (Auth::user()->role !== 'admin') {
    //         return response()->json(['message' => 'Anda tidak memiliki izin'], 403);
    //     }

    //     $report = Report::findOrFail($id);
    //     $report->histories()->delete();
    //     $report->delete();

    //     return response()->json(['message' => 'Laporan berhasil dihapus']);
    // }
}
