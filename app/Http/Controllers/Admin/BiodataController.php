<?php

namespace App\Http\Controllers\Admin;

use App\Models\Biodata;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBiodataRequest;
use App\Http\Requests\UpdateBiodataRequest;
use App\Models\Unit;
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
    public function edit(Biodata $biodata)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBiodataRequest $request, Biodata $biodata)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Biodata $biodata)
    {
        //
    }
}
