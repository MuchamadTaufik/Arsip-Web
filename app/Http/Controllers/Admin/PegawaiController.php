<?php

namespace App\Http\Controllers\Admin;

use App\Models\Unit;
use App\Models\Biodata;
use App\Models\Pegawai;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePegawaiRequest;
use App\Http\Requests\UpdatePegawaiRequest;

class PegawaiController extends Controller
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
        // Cek apakah ada biodata_id di session
        if (!session()->has('biodata_id')) {
            return redirect()->route('pegawai.create')
                ->with('error', 'Silakan isi biodata terlebih dahulu');
        }
        
        // Ambil data unit untuk dropdown
        $unit = Unit::all();
        
        // Ambil data biodata untuk foto preview
        $biodata = Biodata::find(session('biodata_id'));
        
        return view('admin.pegawai.kepegawaian.create', [
            'unit' => $unit,
            'biodata' => $biodata
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePegawaiRequest $request)
    {
        $validatedData = $request->validate([
            'unit_id' => 'required',
            'status' => 'required',
            'hubungan_kerja' => 'required',
            'jabatan' => 'required'
        ]);

        // Buat data kepegawaian baru
        $pegawai = Pegawai::create($validatedData);

        // Update biodata dengan pegawai_id
        Biodata::where('id', session('biodata_id'))
            ->update(['pegawai_id' => $pegawai->id]);

        return redirect()->route('pegawai')
            ->with('success', 'Data kepegawaian berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pegawai $pegawai)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $pegawai)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePegawaiRequest $request, Pegawai $pegawai)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $pegawai)
    {
        //
    }
}
