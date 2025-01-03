<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dokumen;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreDokumenRequest;
use App\Http\Requests\UpdateDokumenRequest;

class DokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokumen = Dokumen::latest()->get();

        return view('admin.dokumen.index', compact('dokumen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $year = now()->year;
        $lastDocument = Dokumen::whereYear('created_at', $year)->orderBy('id', 'desc')->first();
        $lastNumber = $lastDocument ? intval(substr($lastDocument->no_dokumen, 4, -5)) : 0;
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT); // Format: 0001
        $noDokumen = "Dok-$newNumber-$year";
        return view('admin.dokumen.create', compact('noDokumen'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDokumenRequest $request)
    {
        $request->validate([
            'nama_dokumen' => 'required|max:255',
            'uraian_singkat' => 'required',
            'tanggal_dokumen' => 'required|date_format:Y-m-d',
            'jenis_dokumen' => 'required',
            'diunggah_oleh' => 'required',
            'penerima' => 'required|max:255',
            'menu_referensi' => 'required|max:255',
            'file' => 'required|file|max:4096',
            'status' => 'required',
            'tingkat' => 'required',
        ]);

        // Generate nomor dokumen unik
        $year = now()->year;
        $lastDocument = Dokumen::whereYear('created_at', $year)->orderBy('id', 'desc')->first();
        $lastNumber = $lastDocument ? intval(substr($lastDocument->no_dokumen, 4, -5)) : 0;
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT); // Format: 0001
        $noDokumen = "Dok-$newNumber-$year";

        // Buat data dokumen baru
        Dokumen::create([
            'no_dokumen' => $noDokumen,
            'nama_dokumen' => $request->nama_dokumen,
            'uraian_singkat' => $request->uraian_singkat,
            'tanggal_dokumen' => $request->tanggal_dokumen,
            'jenis_dokumen' => $request->jenis_dokumen,
            'diunggah_oleh' => $request->diunggah_oleh,
            'penerima' => $request->penerima,
            'menu_referensi' => $request->menu_referensi,
            'file' => $request->file->store('files'), // Simpan file
            'status' => $request->status,
            'tingkat' => $request->tingkat,
        ]);
        
        if ($request->hasFile('file')) {
            $fileFileName = $request->file('file')->store('file-dokumen');
            $validateData['file'] = $fileFileName;
        }

        toast()->success('Berhasil', 'Data dokumen berhasil ditambahkan');
        return redirect()->route('dokumen')->withInput();
    }


    /**
     * Display the specified resource.
     */
    public function show(Dokumen $dokumen)
    {
        return view('admin.dokumen.show', compact('dokumen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dokumen $dokumen)
    {
        return view('admin.dokumen.edit', compact('dokumen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDokumenRequest $request, Dokumen $dokumen)
    {
        try {
            $rules = [
                'nama_dokumen' => 'required|max:255',
                'uraian_singkat' => 'required',
                'tanggal_dokumen' => 'required|date_format:Y-m-d',
                'jenis_dokumen' => 'required',
                'diunggah_oleh' => 'required',
                'penerima' => 'required|max:255',
                'menu_referensi' => 'required|max:255',
                'file' => 'file|max:4096',
                'status' => 'required',
                'tingkat' => 'required',
            ];
            $validateData = $request->validate($rules);

            if ($request->hasFile('file')) {
                if ($dokumen->file) {
                    // Delete old image
                    Storage::delete($dokumen->file);
                }
                // Store new image in storage
                $validateData['file'] = $request->file('file')->store('file-dokumen');
            } else {
                // Keep old image if no new image is uploaded
                $validateData['file'] = $dokumen->file;
            }

            $dokumen->update($validateData);

            alert()->success('Berhasil', 'Dokumen berhasil diubah');
            return redirect('/dokumen')->withInput();
        } catch (\Exception $e) {
            dd($e->getMessage());

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dokumen $dokumen)
    {
        // Hapus gambar jika ada
        if ($dokumen->file) {
            Storage::delete($dokumen->file);
        }

        Dokumen::destroy($dokumen->id);
        
        // Menampilkan notifikasi sukses dan redirect
        alert()->success('Success', 'Dokumen berhasil dihapus');
        return redirect('/dokumen')->withInput();

    }
}
