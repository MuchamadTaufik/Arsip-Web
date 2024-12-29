<?php

namespace App\Http\Controllers\Admin;

use App\Models\Unit;
use App\Models\Biodata;
use Illuminate\Http\Request;
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
        return view('admin.pegawai.biodata.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBiodataRequest $request)
    {
        $validateData = $request->validate([
            'pegawai_id' => 'nullable|exists:pegawais,id',
            'riwayat_id' => 'nullable|exists:riwayats,id',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nip' => 'required|max:255|unique:biodatas,nip',
            'nama_pegawai' => 'required|max:255',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'agama' => 'required|in:Islam,Kristen Protestan,Katolik,Hindu,Buddha,Konghucu',
            'tempat_lahir' => 'required|max:255',
            'tanggal_lahir' => 'required|date_format:Y-m-d',
            'alamat' => 'required|max:255',
            'email' => 'required|email|unique:biodatas,email',
            'no_telp' => 'required|numeric'
        ]);

        $validateData['slug'] = SlugService::createSlug(Biodata::class, 'slug', $validateData['nip']);

        if ($request->file('foto')) {
            $imageFileName = $request->file('foto')->store('foto-pegawai');
            $validateData['foto'] = $imageFileName;
        }
        
        Biodata::create($validateData);

        toast()->success('Berhasil', 'Biodata Berhasil ditambahkan');
        return redirect('/pegawai')->withInput();
    }
    
    public function search(Request $request)
    {
        $search = $request->get('q');
        
        $results = Biodata::where('nama_pegawai', 'like', "%{$search}%")
            ->orWhere('nip', 'like', "%{$search}%")
            ->select('id', 'nip', 'nama_pegawai', 'jenis_kelamin', 'agama', 
                    'tempat_lahir', 'tanggal_lahir', 'alamat', 'email', 'no_telp', 'foto')
            ->limit(10)
            ->get();

         // Transform data untuk menambahkan URL foto
        $results = $results->map(function($item) {
            $item->foto_url = $item->foto ? asset('storage/' . $item->foto) : null;
            return $item;
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
    public function destroy($slug)
    {
        try {
            $biodata = Biodata::where('slug', $slug)->firstOrFail();
            
            // Delete the associated photo file if it exists
            if ($biodata->foto && Storage::exists($biodata->foto)) {
                Storage::delete($biodata->foto);
            }
            
            // Delete the record
            $biodata->delete();
            
            alert()->success('Success', 'Biodata berhasil dihapus');
            return redirect()->route('pegawai')->with('success', 'Data berhasil dihapus');
            
        } catch (\Exception $e) {
            alert()->error('Error', 'Gagal menghapus biodata');
            return redirect()->route('pegawai')->with('error', 'Gagal menghapus data');
        }
    }
}
