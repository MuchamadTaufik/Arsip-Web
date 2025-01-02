<?php

namespace App\Http\Controllers\Admin;

use App\Models\Riwayat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreRiwayatRequest;
use App\Http\Requests\UpdateRiwayatRequest;

class RiwayatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRiwayatRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Riwayat $riwayat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Riwayat $riwayat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateRiwayat(UpdateRiwayatRequest $request, Riwayat $riwayat)
    {
        DB::beginTransaction();
        try {
            // Validasi data riwayat
            $validated = $request->validate([
                'nama_instansi' => 'required|string|max:255',
                'jabatan' => 'required|string|max:255',
                'tahun' => 'required|numeric|digits:4',
                'file_pendukung' => 'nullable|file|max:2048|mimes:pdf,doc,docx'
            ], [
                'nama_instansi.required' => 'Nama instansi wajib diisi',
                'jabatan.required' => 'Jabatan wajib diisi',
                'tahun.required' => 'Tahun wajib diisi',
                'tahun.numeric' => 'Tahun harus berupa angka',
                'tahun.digits' => 'Tahun harus 4 digit',
                'file_pendukung.max' => 'Ukuran file maksimal 2MB',
                'file_pendukung.mimes' => 'Format file harus PDF, DOC, atau DOCX'
            ]);

            // Update file pendukung jika ada
            if ($request->hasFile('file_pendukung')) {
                if ($riwayat->file_pendukung) {
                    Storage::delete($riwayat->file_pendukung);
                }
                $validated['file_pendukung'] = $request->file('file_pendukung')
                                                    ->store('file-pendukung');
            }

            $riwayat->update($validated);
            
            DB::commit();
            toast()->success('Berhasil', 'Riwayat pegawai berhasil diperbarui');
            return back();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating riwayat: ' . $e->getMessage());
            toast()->error('Gagal', 'Terjadi kesalahan saat memperbarui riwayat');
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Cari Biodata berdasarkan ID
            $riwayat = Riwayat::where('id', $id)->firstOrFail();

            if ($riwayat->file_pendukung && Storage::exists($riwayat->file_pendukung)) {
                Storage::delete($riwayat->file_pendukung); // Menghapus file pendukung
            }

            // Hapus record biodata
            $riwayat->delete();
    
            // Menampilkan pesan sukses
            alert()->success('Success', 'Riwayat berhasil dihapus');
            return redirect()->route('pegawai')->withInput();
            
        } catch (\Exception $e) {
            // Menangani kesalahan jika terjadi
            alert()->error('Error', 'Gagal menghapus riwayat');
            return redirect()->route('pegawai')->withInput();
        }
    }
}
