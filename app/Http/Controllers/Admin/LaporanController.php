<?php

namespace App\Http\Controllers\Admin;

use App\Models\Unit;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Exports\PegawaiExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\PDF;

class LaporanController extends Controller
{
    public function index()
    {
        $units = Unit::all();
        $hubunganKerjas = Pegawai::distinct()->pluck('hubungan_kerja');
        return view('admin.laporan.index', compact('units', 'hubunganKerjas'));
    }

    public function export(Request $request)
    {
        $query = Pegawai::with(['unit', 'biodata'])
            ->when($request->unit_id, function($q) use ($request) {
                return $q->where('unit_id', $request->unit_id);
            })
            ->when($request->status, function($q) use ($request) {
                return $q->where('status', $request->status);
            })
            ->when($request->hubungan_kerja, function($q) use ($request) {
                return $q->where('hubungan_kerja', $request->hubungan_kerja);
            });
        
            $filters = [
                'unit' => $request->unit_id ? Unit::find($request->unit_id)->name : null,
                'status' => $request->status,
                'hubungan_kerja' => $request->hubungan_kerja
            ];

        if ($request->format === 'pdf') {
            $pegawais = $query->get();

            $pdf = app(PDF::class);
            $pdf->loadView('admin.laporan.pdf', compact('pegawais', 'request', 'filters'));
            return $pdf->download('laporan-pegawai.pdf');
        }

        return Excel::download(new PegawaiExport($query, $filters), 'laporan-pegawai.xlsx');
    }
}
