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
