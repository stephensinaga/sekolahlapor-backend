<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Report;
use App\Models\ReportStatusHistory;


class OfficerReportController extends Controller
{

    // Lihat semua laporan yang ditugaskan ke petugas
    public function index(Request $request) {
        $officerId = $request->user()->id;

        $assignments = Assignment::where('officer_id', $officerId)
            ->with('report') // Load laporan terkait
            ->get()
            ->map(function ($assignment) {
                return [
                    'assignment_id' => $assignment->id, // Pastikan assignment_id ikut
                    'status' => $assignment->status,
                    'report' => $assignment->report, // Data laporan
                ];
            });

        return response()->json($assignments);
    }

    // Lihat detail laporan tertentu
    public function show($id) {
        $assignment = Assignment::where('id', $id)->with('report')->first();

        if (!$assignment) {
            return response()->json(['error' => 'Laporan tidak ditemukan'], 404);
        }

        return response()->json($assignment);
    }

    // Update status laporan oleh petugas
    public function updateStatus(Request $request, $id) {
        $request->validate([
            'status' => 'required|in:in_progress,completed'
        ]);
    
        $assignment = Assignment::find($id);
        if (!$assignment) {
            return response()->json(['error' => 'Tugas tidak ditemukan'], 404);
        }
    
        // Perbarui status assignment
        $assignment->status = $request->status;
        $assignment->save();
    
        // Jika status berubah menjadi 'in_progress', ubah status report juga
        $report = Report::find($assignment->report_id);
        if ($report) {
            $report->status = $request->status;
            $report->save();
    
            // Simpan perubahan ke dalam timeline
            ReportStatusHistory::create([
                'report_id' => $report->id,
                'status' => $request->status,
                'updated_by' => auth()->id(),
            ]);
        }
    
        return response()->json(['message' => 'Status tugas dan laporan diperbarui!']);
    }

    public function completeAssignment(Request $request, $id) {
        $assignment = Assignment::find($id);
        if (!$assignment) {
            return response()->json(['error' => 'Tugas tidak ditemukan'], 404);
        }
    
        if ($assignment->status !== 'in_progress') {
            return response()->json(['error' => 'Tugas tidak dapat diselesaikan karena tidak sedang dalam proses'], 400);
        }
    
        // Perbarui status assignment
        $assignment->status = 'completed';
        $assignment->save();
    
        // Perbarui status report
        $report = Report::find($assignment->report_id);
        if ($report) {
            $report->status = 'completed';
            $report->save();
    
            // Simpan ke dalam timeline status laporan
            ReportStatusHistory::create([
                'report_id' => $report->id,
                'status' => 'completed',
                'updated_by' => auth()->id(),
            ]);
        }
    
        return response()->json(['message' => 'Tugas berhasil diselesaikan!']);
    }
    

}
