<?php

namespace App\Http\Controllers\Admin;

use App\Models\Unit;
use App\Models\Biodata;
use App\Models\Pegawai;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreBiodataRequest;
use App\Http\Requests\UpdateBiodataRequest;
use Cviebrock\EloquentSluggable\Services\SlugService;

class BiodataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $biodata = Biodata::with(['pegawai.unit'])
            ->when($request->search, function($query) use ($request) {
                $query->where('nip', 'like', '%' . $request->search . '%')
                    ->orWhere('nama_pegawai', 'like', '%' . $request->search . '%')
                    ->orWhereHas('pegawai', function($q) use ($request) {
                        $q->where('status', 'like', '%' . $request->search . '%')
                            ->orWhereHas('unit', function($q2) use ($request) {
                                $q2->where('name', 'like', '%' . $request->search . '%');
                            });
                    });
            })
            ->latest()
            ->get();

        // Ambil data unit untuk dropdown filter
        $units = Unit::all();

        return view('admin.pegawai.index', compact('biodata', 'units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $units = Unit::all();
        return view('admin.pegawai.create', compact('units'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreBiodataRequest $request)
    {
        DB::beginTransaction();
        try {
            // Validate form data
            $validated = $request->validate([
                'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'nip' => 'required|max:255|unique:biodatas,nip',
                'nama_pegawai' => 'required|max:255',
                'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
                'agama' => 'required|in:Islam,Kristen Protestan,Katolik,Hindu,Buddha,Konghucu',
                'tempat_lahir' => 'required|max:255',
                'tanggal_lahir' => 'required|date_format:Y-m-d',
                'alamat' => 'required|max:255',
                'email' => 'required|email|unique:biodatas,email',
                'no_telp' => 'required|numeric',

                'unit_id' => 'required',
                'status' => 'required',
                'hubungan_kerja' => 'required',
                'jabatan' => 'required',

                'riwayat.*.nama_instansi' => 'nullable',
                'riwayat.*.jabatan' => 'nullable',
                'riwayat.*.tahun' => 'nullable|numeric',
                'riwayat.*.file_pendukung' => 'nullable|file|max:2048'
            ]);

            // Create Biodata
            $biodata = Biodata::create([
                'foto' => $request->file('foto') ? 
                        $request->file('foto')->store('foto-pegawai') : null,
                'nip' => $validated['nip'],
                'nama_pegawai' => $validated['nama_pegawai'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'agama' => $validated['agama'],
                'tempat_lahir' => $validated['tempat_lahir'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'alamat' => $validated['alamat'],
                'email' => $validated['email'],
                'no_telp' => $validated['no_telp'],
            ]);

            // Create pegawai
            $pegawai = Pegawai::create([
                'biodata_id' => $biodata->id,
                'unit_id' => $validated['unit_id'],
                'status' => $validated['status'],
                'hubungan_kerja' => $validated['hubungan_kerja'],
                'jabatan' => $validated['jabatan'],
            ]);

            // Update biodata with pegawai_id
            $biodata->update(['pegawai_id' => $pegawai->id]);

            // Create Riwayat entries if present
            if (isset($validated['riwayat'])) {
                foreach ($validated['riwayat'] as $riwayatData) {
                    if ($riwayatData['nama_instansi'] || $riwayatData['jabatan'] || $riwayatData['tahun']) {
                        $riwayat = Riwayat::create([
                            'biodata_id' => $biodata->id,
                            'nama_instansi' => $riwayatData['nama_instansi'],
                            'jabatan' => $riwayatData['jabatan'],
                            'tahun' => $riwayatData['tahun'],
                            'file_pendukung' => isset($riwayatData['file_pendukung']) ? 
                                            $riwayatData['file_pendukung']->store('file-pendukung') : null
                        ]);
                    }
                }
            }

            DB::commit();
            toast()->success('Berhasil', 'Data Pegawai berhasil ditambahkan');
            return redirect()->route('pegawai')->withInput();
                            
        } catch (\Exception $e) {
            DB::rollBack();
            toast()->error('Terjadi kesalahan', 'Terjadi kesalahan saat menyimpan data');
            return back()->withInput();
        }
    }

    
    public function search(Request $request)
    {
        $search = $request->get('q');
        
        // Fetch data with relationships and all necessary fields
        $results = Biodata::with(['pegawai.unit', 'riwayat'])
            ->where(function($query) use ($search) {
                $query->where('nama_pegawai', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%");
            })
            ->select('id', 'nip', 'nama_pegawai', 'jenis_kelamin', 'agama', 
                    'tempat_lahir', 'tanggal_lahir', 'alamat', 'email', 
                    'no_telp', 'foto', 'pegawai_id')
            ->limit(10)
            ->get();

        // Transform data with complete information
        $results = $results->map(function($item) {
            return [
                'id' => $item->id,
                'nip' => $item->nip,
                'nama_pegawai' => $item->nama_pegawai,
                'jenis_kelamin' => $item->jenis_kelamin,
                'agama' => $item->agama,
                'tempat_lahir' => $item->tempat_lahir,
                'tanggal_lahir' => $item->tanggal_lahir,
                'alamat' => $item->alamat,
                'email' => $item->email,
                'no_telp' => $item->no_telp,
                'foto_url' => $item->foto ? asset('storage/' . $item->foto) : null,
                
                // Pegawai data
                'pegawai' => $item->pegawai ? [
                    'id' => $item->pegawai->id,
                    'unit_id' => $item->pegawai->unit_id,
                    'status' => $item->pegawai->status,
                    'hubungan_kerja' => $item->pegawai->hubungan_kerja,
                    'jabatan' => $item->pegawai->jabatan,
                    'unit' => $item->pegawai->unit ? [
                        'id' => $item->pegawai->unit->id,
                        'name' => $item->pegawai->unit->name
                    ] : null
                ] : null,
                
                // Riwayat data
                'riwayat' => $item->riwayat->map(function($riwayat) {
                    return [
                        'id' => $riwayat->id,
                        'nama_instansi' => $riwayat->nama_instansi,
                        'jabatan' => $riwayat->jabatan,
                        'tahun' => $riwayat->tahun,
                        'file_pendukung' => $riwayat->file_pendukung ? 
                            asset('storage/' . $riwayat->file_pendukung) : null
                    ];
                })
            ];
        });
        
        return response()->json($results);
    }


    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $biodata = Biodata::with(['pegawai.unit', 'riwayat'])
            ->where('slug', $slug)
            ->firstOrFail();
        return view('admin.pegawai.show', compact('biodata'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $biodata = Biodata::with(['pegawai.unit', 'riwayat'])
            ->where('id', $id)
            ->firstOrFail();

        $units = Unit::all();
        return view('admin.pegawai.edit', compact('biodata','units'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateBiodataRequest $request, $id)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $biodata = Biodata::findOrFail($id);

    //         // Validasi data biodata
    //         $validatedBiodata = $request->validate([
    //             'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //             'nip' => 'required|max:255|unique:biodatas,nip,' . $id,
    //             'nama_pegawai' => 'required|max:255',
    //             'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
    //             'agama' => 'required|in:Islam,Kristen Protestan,Katolik,Hindu,Buddha,Konghucu',
    //             'tempat_lahir' => 'required|max:255',
    //             'tanggal_lahir' => 'required|date_format:Y-m-d',
    //             'alamat' => 'required|max:255',
    //             'email' => 'required|email|unique:biodatas,email,' . $id,
    //             'no_telp' => 'required|numeric',

    //             // Data kepegawaian
    //             'unit_id' => 'required|exists:units,id',
    //             'status' => 'required|in:Aktif,Non-Aktif',
    //             'hubungan_kerja' => 'required|string|max:255',
    //             'jabatan' => 'required|string|max:255',
    //         ], [
    //             'nip.required' => 'NIP wajib diisi',
    //             'nip.unique' => 'NIP sudah digunakan',
    //             'nama_pegawai.required' => 'Nama pegawai wajib diisi',
    //             'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
    //             'agama.required' => 'Agama wajib dipilih',
    //             'tempat_lahir.required' => 'Tempat lahir wajib diisi',
    //             'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
    //             'alamat.required' => 'Alamat wajib diisi',
    //             'email.required' => 'Email wajib diisi',
    //             'email.email' => 'Format email tidak valid',
    //             'email.unique' => 'Email sudah digunakan',
    //             'no_telp.required' => 'Nomor telepon wajib diisi',
    //             'no_telp.numeric' => 'Nomor telepon harus berupa angka',
    //             'unit_id.required' => 'Unit kerja wajib dipilih',
    //             'status.required' => 'Status wajib dipilih',
    //             'hubungan_kerja.required' => 'Hubungan kerja wajib diisi',
    //             'jabatan.required' => 'Jabatan wajib diisi'
    //         ]);

    //         // Validasi data riwayat
    //         $validatedRiwayat = $request->validate([
    //             'nama_instansi' => 'required|string|max:255',
    //             'jabatan' => 'required|string|max:255',
    //             'tahun' => 'required|numeric|digits:4',
    //             'file_pendukung' => 'nullable|file|max:2048|mimes:pdf,doc,docx'
    //         ], [
    //             'nama_instansi.required' => 'Nama instansi wajib diisi',
    //             'jabatan.required' => 'Jabatan wajib diisi',
    //             'tahun.required' => 'Tahun wajib diisi',
    //             'tahun.numeric' => 'Tahun harus berupa angka',
    //             'tahun.digits' => 'Tahun harus 4 digit',
    //             'file_pendukung.max' => 'Ukuran file maksimal 2MB',
    //             'file_pendukung.mimes' => 'Format file harus PDF, DOC, atau DOCX'
    //         ]);

    //         // Update foto biodata jika ada
    //         if ($request->hasFile('foto')) {
    //             if ($biodata->foto) {
    //                 Storage::delete($biodata->foto);
    //             }
    //             $validatedBiodata['foto'] = $request->file('foto')->store('foto-pegawai');
    //         }

    //         // Update biodata
    //         $biodata->update($validatedBiodata);

    //         // Update data pegawai
    //         if ($biodata->pegawai) {
    //             $biodata->pegawai->update([
    //                 'unit_id' => $validatedBiodata['unit_id'],
    //                 'status' => $validatedBiodata['status'],
    //                 'hubungan_kerja' => $validatedBiodata['hubungan_kerja'],
    //                 'jabatan' => $validatedBiodata['jabatan']
    //             ]);
    //         }

    //         // Simpan riwayat baru
    //         $riwayatData = [
    //             'biodata_id' => $biodata->id,
    //             'nama_instansi' => $validatedRiwayat['nama_instansi'],
    //             'jabatan' => $validatedRiwayat['jabatan'],
    //             'tahun' => $validatedRiwayat['tahun']
    //         ];

    //         if ($request->hasFile('file_pendukung')) {
    //             $riwayatData['file_pendukung'] = $request->file('file_pendukung')->store('file-pendukung');
    //         }

    //         Riwayat::create($riwayatData);

    //         DB::commit();
    //         toast()->success('Berhasil', 'Data pegawai dan riwayat berhasil diperbarui');
    //         return redirect()->route('pegawai.index');

    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error('Error updating biodata and storing riwayat: ' . $e->getMessage());
    //         toast()->error('Gagal', 'Terjadi kesalahan saat memperbarui data');
    //         return back()->withInput();
    //     }
    // }

    public function update(Request $request, $id)
    {
        // Validasi request
        $request->validate([
            // Biodata validation
            'nip' => 'required|string|max:255',
            'nama_pegawai' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'agama' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'email' => 'required|email',
            'no_telp' => 'required|string',
            'foto' => 'nullable|image|max:2048',

            // Pegawai validation
            'unit_id' => 'required|exists:units,id',
            'status' => 'required|in:Aktif,Non-Aktif',
            'hubungan_kerja' => 'required|string',
            'jabatan' => 'required|string',

            // Riwayat validation (if any)
            'riwayat.*.nama_instansi' => 'required|string',
            'riwayat.*.jabatan' => 'required|string',
            'riwayat.*.tahun' => 'required|numeric|min:1900|max:' . (date('Y') + 1),
            'riwayat.*.file_pendukung' => 'nullable|file|max:2048'
        ]);

        try {
            DB::beginTransaction();

            // Update Biodata
            $biodata = Biodata::findOrFail($id);
            $biodataData = $request->only([
                'nip', 'nama_pegawai', 'jenis_kelamin', 'agama',
                'tempat_lahir', 'tanggal_lahir', 'alamat', 'email', 'no_telp'
            ]);

            // Handle foto upload
            if ($request->hasFile('foto')) {
                if ($biodata->foto) {
                    Storage::delete($biodata->foto);
                }
                $biodataData['foto'] = $request->file('foto')->store('foto-pegawai');
            }

            $biodata->update($biodataData);

            // Update Pegawai
            $pegawaiData = $request->only([
                'unit_id', 'status', 'hubungan_kerja', 'jabatan'
            ]);
            $biodata->pegawai->update($pegawaiData);

            // Handle Riwayat
            if ($request->has('riwayat')) {
                foreach ($request->riwayat as $riwayatData) {
                    $riwayat = new Riwayat([
                        'nama_instansi' => $riwayatData['nama_instansi'],
                        'jabatan' => $riwayatData['jabatan'],
                        'tahun' => $riwayatData['tahun']
                    ]);

                    if (isset($riwayatData['file_pendukung']) && $riwayatData['file_pendukung'] instanceof \Illuminate\Http\UploadedFile) {
                        $riwayat->file_pendukung = $riwayatData['file_pendukung']->store('file-pendukung');
                    }

                    $biodata->riwayat()->save($riwayat);
                }
            }

            DB::commit();
            toast()->success('success', 'Data pegawai berhasil diperbarui');
            return redirect()->route('pegawai')->withInput();
        } catch (\Exception $e) {
            DB::rollback();
            toast()->error('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
            return  back()->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Cari Biodata berdasarkan ID
            $biodata = Biodata::where('id', $id)->firstOrFail();
    
            // Hapus data terkait (misalnya Pegawai dan Riwayat)
            if ($biodata->pegawai) {
                $biodata->pegawai->delete(); // Menghapus data pegawai terkait
            }

            if ($biodata->foto && Storage::exists($biodata->foto)) {
                Storage::delete($biodata->foto);
            }
    
            if ($biodata->riwayat) {
                $biodata->riwayat->each(function ($riwayat) {
                    if ($riwayat->file_pendukung && Storage::exists($riwayat->file_pendukung)) {
                        Storage::delete($riwayat->file_pendukung); // Menghapus file pendukung
                    }
                    
    
                    $riwayat->delete(); // Menghapus setiap riwayat yang terkait
                });
            }
    
            // Hapus record biodata
            $biodata->delete();
    
            // Menampilkan pesan sukses
            alert()->success('Success', 'Biodata beserta data terkait berhasil dihapus');
            return redirect()->route('pegawai')->withInput();
            
        } catch (\Exception $e) {
            // Menangani kesalahan jika terjadi
            alert()->error('Error', 'Gagal menghapus biodata dan data terkait');
            return redirect()->route('pegawai')->withInput();
        }
    }
    

}
