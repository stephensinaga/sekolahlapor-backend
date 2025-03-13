<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\City;
use App\Models\ReportStatusHistory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class ReportController extends Controller
{
    // Menampilkan semua laporan
    public function index()
    {
        $reports = Report::with('user')->latest()->get();
        return response()->json(['success' => true, 'data' => $reports]);
    }

    public function userReports(Request $request)
    {
        $user = auth()->user(); // Ambil user dari token

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan',
            ], 404);
        }

        $reports = Report::where('user_id', $user->id)->latest()->get();

        if ($reports->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Laporan tidak ditemukan',
            ], 404);
        }

        return response()->json($reports, 200);
    }

    // Menampilkan detail laporan berdasarkan ID
    public function show($id)
    {
        $report = Report::with('user')->find($id);
        if (!$report) {
            return response()->json(['success' => false, 'message' => 'Laporan tidak ditemukan'], 404);
        }
        return response()->json(['success' => true, 'data' => $report]);
    }

    // Membuat laporan baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_laporan' => 'required|string', // Hanya string, bukan array
            'photo_1' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'photo_2' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'photo_3' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'keterangan' => 'required|string',
            'kota' => 'required|string',
            'kecamatan' => 'required|string',
            'alamat' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Simpan gambar dengan nama unik
            $photo1Path = $request->file('photo_1')->store('reports', 'public');
            $photo2Path = $request->file('photo_2')->store('reports', 'public');
            $photo3Path = $request->file('photo_3')->store('reports', 'public');


            $report = Report::create([
                'user_id' => auth()->id(), // Pastikan user sudah login
                'category' => $request->jenis_laporan, // Disimpan sebagai string
                'photo_1' => $photo1Path,
                'photo_2' => $photo2Path,
                'photo_3' => $photo3Path,
                'description' => $request->keterangan,
                'kota' => $request->kota,
                'kecamatan' => $request->kecamatan,
                'address' => $request->alamat,
                'status' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Laporan berhasil dikirim',
                'data' => $report
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    // Mengupdate status laporan (Admin)
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,diterima,ditolak,diproses',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $report = Report::find($id);
        if (!$report) {
            return response()->json(['success' => false, 'message' => 'Laporan tidak ditemukan'], 404);
        }

        $report->status = $request->status;
        $report->save();

        return response()->json(['success' => true, 'message' => 'Status laporan diperbarui', 'data' => $report]);
    }

    // Menghapus laporan (Admin atau pemilik laporan)
    public function destroy(Request $request, $id)
    {
        $report = Report::find($id);
        if (!$report) {
            return response()->json(['success' => false, 'message' => 'Laporan tidak ditemukan'], 404);
        }

        if ($report->user_id !== $request->user()->id && !$request->user()->is_admin) {
            return response()->json(['success' => false, 'message' => 'Tidak memiliki izin untuk menghapus laporan ini'], 403);
        }

        $report->delete();
        return response()->json(['success' => true, 'message' => 'Laporan berhasil dihapus']);
    }

    public function getCities()
    {
        try {
            $cities = City::with('districts')->get(); // ✅ Pastikan districts ikut dimuat
            return response()->json($cities);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getReportHistory($id)
    {
        $history = ReportStatusHistory::where('report_id', $id)
            ->with('user') 
            ->orderBy('created_at', 'asc')
            ->get();
    
        Log::info('Report History Data:', $history->toArray()); // ✅ Tambahkan log
    
        return response()->json(['success' => true, 'data' => $history]);
    }
    

    
}
