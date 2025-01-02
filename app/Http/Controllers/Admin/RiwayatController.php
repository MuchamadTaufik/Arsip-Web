<?php

namespace App\Http\Controllers\Admin;

use App\Models\Riwayat;
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
    public function update(UpdateRiwayatRequest $request, Riwayat $riwayat)
    {
        //
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
