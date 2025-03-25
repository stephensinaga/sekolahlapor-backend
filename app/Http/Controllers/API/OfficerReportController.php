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
    
        // Perbarui status hanya untuk tugas petugas tertentu
        $assignment->status = $request->status;
        $assignment->save();
    
        // Simpan perubahan ke dalam timeline
        ReportStatusHistory::create([
            'report_id' => $assignment->report_id,
            'status' => $request->status,
            'updated_by' => auth()->id(),
        ]);
    
        // **Cek apakah semua tugas sudah completed**
        $allAssignmentsCompleted = Assignment::where('report_id', $assignment->report_id)
            ->where('status', '!=', 'completed')
            ->exists(); // Jika masih ada yang belum 'completed', maka false
    
        if (!$allAssignmentsCompleted) {
            // Jika semua tugas sudah 'completed', baru ubah status Report
            $report = Report::find($assignment->report_id);
            if ($report) {
                $report->status = 'completed';
                $report->save();
            }
        }
    
        return response()->json(['message' => 'Status tugas diperbarui!']);
    }
    
    

    public function completeAssignment(Request $request, $id) {
        $assignment = Assignment::find($id);
        if (!$assignment) {
            return response()->json(['error' => 'Tugas tidak ditemukan'], 404);
        }
    
        if ($assignment->status !== 'in_progress') {
            return response()->json(['error' => 'Tugas tidak dapat diselesaikan karena tidak sedang dalam proses'], 400);
        }
    
        // Ambil semua assignment yang terkait dengan laporan yang sama
        $relatedAssignments = Assignment::where('report_id', $assignment->report_id)->get();
    
        foreach ($relatedAssignments as $relatedAssignment) {
            $relatedAssignment->status = 'completed';
            $relatedAssignment->save();
        }
    
        // Perbarui status laporan utama (Report)
        $report = Report::find($assignment->report_id);
        if ($report) {
            $report->status = 'completed';
            $report->save();
    
            // Simpan perubahan ke dalam timeline status laporan
            ReportStatusHistory::create([
                'report_id' => $report->id,
                'status' => 'completed',
                'updated_by' => auth()->id(),
            ]);
        }
    
        return response()->json(['message' => 'Tugas berhasil diselesaikan untuk semua petugas!']);
    }
    
    

}
