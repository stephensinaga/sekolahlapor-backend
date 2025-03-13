<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\User;
use App\Models\Assignment;

class AdminReportController extends Controller
{
    public function index() {
        $reports = Report::where('status', 'pending')->get();
        $officers = User::where('role', 'petugas')->get(); // Ambil semua petugas
        return view('admin.index', compact('reports', 'officers'));
    }

    // Menerima atau menolak laporan
    public function verify(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        if ($request->status == 'accepted') {
            // Tampilkan modal pemilihan petugas
            return redirect()->route('admin.reports.assignForm', $id);
        } else {
            // Jika ditolak, langsung update status
            $report->status = 'rejected';
            $report->save();
            return redirect()->route('admin.reports.index')->with('success', 'Laporan ditolak!');
        }
    }


    // Menampilkan halaman untuk assign petugas
    public function assignForm($id) {
        $report = Report::findOrFail($id);
        $officers = User::where('role', 'officer')->get();
        return view('admin.assign', compact('report', 'officers'));
    }

    // Meneruskan laporan ke petugas
    public function assign(Request $request, $id) {
        $request->validate(['officer_id' => 'required|exists:users,id']);

        Assignment::create([
            'report_id' => $id,
            'officer_id' => $request->officer_id,
            'status' => 'assigned'
        ]);

        $report = Report::findOrFail($id);
        $report->status = 'accepted';
        $report->save();

        return redirect()->route('admin.reports.index')->with('success', 'Laporan diteruskan ke petugas!');
    }
}
