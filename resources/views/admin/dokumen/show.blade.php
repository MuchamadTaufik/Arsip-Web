@extends('admin.layouts.main')

@section('container')
   <div class="row">
      <div class="col-md-12">
         <div class="card">
            <div class="card-body">
                     <div class="d-flex flex-column flex-md-row justify-content-start align-items-center mb-3">
                        <div class="action-buttons-custom d-flex flex-column flex-md-row align-items-center gap-1">
                           <a href="{{ route('dokumen') }}" class="btn btn-secondary" id="kembaliDaftarBtn">
                              <i data-feather="arrow-left"></i> Kembali ke Daftar
                           </a>
                           <a href="{{ route('dokumen.edit', $dokumen->id) }}" class="btn btn-warning" id="editBtn">
                              <i data-feather="edit"></i> Edit
                           </a>
                           <form action="{{ route('dokumen.delete', $dokumen->id) }}" method="POST" id="hapusForm" style="display:inline;">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger" id="hapusBtn" onclick="return confirm('Apakah yakin ingin menghapus data?')">
                                 <i data-feather="trash-2"></i> Hapus
                              </button>
                           </form>
                        </div>
                     </div>
                     <h4>Data Dokumen</h4>
                     <input type="hidden" name="diunggah_oleh" value="{{ auth()->user()->username}}">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                                 <label for="no_dokumen">No Dokumen</label>
                                 <input 
                                    class="form-control" 
                                    value="{{ old('no_dokumen', $dokumen->no_dokumen) }}" 
                                    readonly 
                                 />
                           </div>
                        </div>                        
                        <div class="col-md-6">
                           <div class="form-group">
                                 <label for="menu_referensi">Menu Referensi</label>
                                 <input class="form-control" value="{{ old('menu_referensi', $dokumen->menu_referensi) }}" readonly/>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                                 <label for="nama_dokumen">Nama Dokumen</label>
                                 <input class="form-control" value="{{ old('nama_dokumen', $dokumen->nama_dokumen) }}" readonly/>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                                 <label for="file">File</label>
                                 <a href="{{ asset('storage/' . $dokumen->file) }}" 
                                    class="btn btn-sm btn-info" target="_blank">
                                    <i data-feather="file"></i> Lihat
                                    </a>
                           </div>
                        </div>                         
                        <div class="col-md-6">
                           <div class="form-group">
                                 <label for="tanggal_dokumen">Tanggal Dokumen</label>
                                 <input class="form-control" value="{{ old('tanggal_dokumen', $dokumen->tanggal_dokumen) }}" readonly/>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                                 <label for="title">Status Dokumen</label>
                                 <input class="form-control" value="{{ old('status', $dokumen->status) }}" readonly/>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                                 <label for="jenis_dokumen">Jenis Dokumen</label>
                                 <input class="form-control" value="{{ old('jenis_dokumen', $dokumen->jenis_dokumen) }}" readonly />
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                                 <label for="title">Tingkat</label>
                                 <input class="form-control" value="{{ old('tingkat', $dokumen->tingkat) }}" readonly />
                           </div>
                        </div>
                        
                        <div class="col-md-12">
                           <div class="form-group">
                              <label for="uraian_singkat">Uraian Singkat</label>
                              <input type="hidden" class="form-control @error('uraian_singkat') is-invalid @enderror" 
                                 id="uraian_singkat" 
                                 name="uraian_singkat" 
                                 value="{{ old('uraian_singkat', $dokumen->uraian_singkat) }}" 
                                 readonly>
                              <trix-editor input="uraian_singkat" contenteditable="false"></trix-editor>
                           </div>
                        </div>
                        
                        <hr>

                        <div class="col-md-6">
                           <div class="form-group">
                                 <label for="penerima">Penerima</label>
                                 <input class="form-control" value="{{ old('penerima', $dokumen->penerima) }}" readonly />
                           </div>
                        </div>
                     </div>
            </div>
         </div>
      </div>
   </div>
@endsection