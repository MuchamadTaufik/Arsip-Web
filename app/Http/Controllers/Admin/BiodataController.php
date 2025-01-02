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
    public function show(Biodata $biodata)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $biodata = Biodata::where('id', $id)->firstOrFail();

        return view('admin.pegawai.biodata.edit', compact('biodata'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBiodataRequest $request, $slug)
    {
        $biodata = Biodata::where('slug', $slug)->firstOrFail();

        try {
            $rules = [
                'pegawai_id' => 'nullable|exists:pegawais,id',
                'riwayat_id' => 'nullable|exists:riwayats,id',
                'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'nip' => 'required|max:255|unique:biodatas,nip,' . $biodata->id,
                'nama_pegawai' => 'required|max:255',
                'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
                'agama' => 'required|in:Islam,Kristen Protestan,Katolik,Hindu,Buddha,Konghucu',
                'tempat_lahir' => 'required|max:255',
                'tanggal_lahir' => 'required|date_format:Y-m-d',
                'alamat' => 'required|max:255',
                'email' => 'required|email|unique:biodatas,email,' . $biodata->id,
                'no_telp' => 'required|numeric'
            ];

            $validateData = $request->validate($rules);

            $validateData['slug'] = SlugService::createSlug(Biodata::class, 'slug', $validateData['nip']);

            if ($request->hasFile('foto')) {
                if ($biodata->foto) {
                    // Delete old image
                    Storage::delete($biodata->foto);
                }
                // Store new image in storage
                $validateData['foto'] = $request->file('foto')->store('foto-pegawai');
            } else {
                // Keep old image if no new image is uploaded
                $validateData['foto'] = $biodata->foto;
            }

            $biodata->update($validateData);

            alert()->success('Berhasil', 'Biodata berhasil diubah');
            return redirect('/pegawai')->withInput();
        } catch (\Exception $e) {
            dd($e->getMessage());

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
