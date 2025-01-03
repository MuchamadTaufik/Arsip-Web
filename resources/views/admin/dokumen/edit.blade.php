@extends('admin.layouts.main')

@section('container')
   <div class="row">
      <div class="col-md-12">
         <div class="card">
            <div class="card-body">
               <form action="{{ route('dokumen.update', $dokumen->id) }}" method="POST" enctype="multipart/form-data">
                     <div class="d-flex flex-column flex-md-row justify-content-start align-items-center mb-3">
                        <div class="action-buttons-custom d-flex flex-column flex-md-row align-items-center gap-1">
                           <a href="{{ route('dokumen') }}" class="btn btn-secondary">
                                 <i data-feather="arrow-left"></i> Kembali ke Daftar
                           </a>
                           <button type="submit" class="btn btn-primary">
                                 <i data-feather="save"></i> Simpan
                           </button>
                        </div>
                     </div>
                     <h4>Data Dokumen</h4>
                     @method('put')
                     @csrf
                     <input type="hidden" name="diunggah_oleh" value="{{ auth()->user()->username}}">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                                 <label for="no_dokumen">No Dokumen</label>
                                 <input 
                                    type="text" 
                                    class="form-control @error('no_dokumen') is-invalid @enderror" 
                                    id="no_dokumen" 
                                    name="no_dokumen" 
                                    value="{{ old('no_dokumen', $dokumen->no_dokumen) }}" 
                                    readonly 
                                    required 
                                 />
                                 @error('no_dokumen')
                                    <div class="invalid-feedback">
                                       {{ $message }}
                                    </div>
                                 @enderror
                           </div>
                        </div>                        
                        <div class="col-md-6">
                           <div class="form-group">
                                 <label for="menu_referensi">Menu Referensi</label>
                                 <input type="text" class="form-control @error('menu_referensi') is-invalid @enderror" id="menu_referensi" name="menu_referensi" placeholder="Masukan Menu Referensi..." value="{{ old('menu_referensi', $dokumen->menu_referensi) }}" required/>
                                 @error('menu_referensi')
                                    <div class="invalid-feedback">
                                       {{ $message }}
                                    </div>
                                 @enderror
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                                 <label for="nama_dokumen">Nama Dokumen</label>
                                 <input type="text" class="form-control @error('nama_dokumen') is-invalid @enderror" id="nama_dokumen" name="nama_dokumen" placeholder="Masukan Nama Dokumen..." value="{{ old('nama_dokumen', $dokumen->nama_dokumen) }}" required/>
                                 @error('nama_dokumen')
                                    <div class="invalid-feedback">
                                       {{ $message }}
                                    </div>
                                 @enderror
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="file">File</label>
                              <input type="file" 
                                     class="form-control @error('file') is-invalid @enderror" 
                                     id="file" 
                                     name="file" 
                                     onchange="previewPDF()" 
                                     aria-describedby="pdfHelp"/>
                              <small id="pdfHelp" class="form-text text-red">Maksimal ukuran file (4MB)</small>
                              @error('file')
                                 <div class="invalid-feedback">
                                    {{ $message }}
                                 </div>
                              @enderror
                              <div class="mt-2">
                                 <!-- Pastikan 'src' diarahkan ke PDF awal -->
                                 <iframe id="pdf-preview" 
                                         src="{{ asset('storage/' . $dokumen->file) }}" 
                                         style="width: 100%; height: 500px;" 
                                         frameborder="0"></iframe>
                              </div>
                           </div>
                        </div>                                                 
                        <div class="col-md-6">
                           <div class="form-group">
                                 <label for="tanggal_dokumen">Tanggal Dokumen</label>
                                 <input type="date" class="form-control @error('tanggal_dokumen') is-invalid @enderror" id="tanggal_dokumen" name="tanggal_dokumen" value="{{ old('tanggal_dokumen', $dokumen->tanggal_dokumen) }}" required/>
                                 @error('tanggal_dokumen')
                                    <div class="invalid-feedback">
                                       {{ $message }}
                                    </div>
                                 @enderror
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                                 <label for="title">Status Dokumen</label>
                                 <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="" disabled {{ old('status', $dokumen->status) == '' ? 'selected' : '' }}>Status Dokumen</option>
                                    <option value="Status_1" {{ old('status', $dokumen->status) == 'Status_1' ? 'selected' : '' }}>Status_1</option>
                                    <option value="Status_2" {{ old('status', $dokumen->status) == 'Status_2' ? 'selected' : '' }}>Status_2</option>
                                    <option value="Status_3" {{ old('status', $dokumen->status) == 'Status_3' ? 'selected' : '' }}>Status_3</option>
                                 </select>
                                 @error('status')
                                    <div class="invalid-feedback">
                                       {{ $message }}
                                    </div>
                                 @enderror
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                                 <label for="jenis_dokumen">Jenis Dokumen</label>
                                 <input type="text" class="form-control @error('jenis_dokumen') is-invalid @enderror" id="jenis_dokumen" name="jenis_dokumen" placeholder="Masukan Jenis Dokumen..." value="{{ old('jenis_dokumen', $dokumen->jenis_dokumen) }}" required/>
                                 @error('jenis_dokumen')
                                    <div class="invalid-feedback">
                                       {{ $message }}
                                    </div>
                                 @enderror
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                                 <label for="title">Tingkat</label>
                                 <select class="form-control @error('tingkat') is-invalid @enderror" id="tingkat" name="tingkat" required>
                                    <option value="" disabled {{ old('tingkat', $dokumen->tingkat) == '' ? 'selected' : '' }}>Tingkat</option>
                                    <option value="Penting" {{ old('tingkat', $dokumen->tingkat) == 'Penting' ? 'selected' : '' }}>Penting</option>
                                    <option value="Tidak Penting" {{ old('tingkat', $dokumen->tingkat) == 'Tidak Penting' ? 'selected' : '' }}>Tidak Penting</option>
                                 </select>
                                 @error('tingkat')
                                    <div class="invalid-feedback">
                                       {{ $message }}
                                    </div>
                                 @enderror
                           </div>
                        </div>
                        
                        <div class="col-md-12">
                           <div class="form-group">
                                 <label for="uraian_singkat">Uraian Singkat</label>
                                 <input type="hidden" class="form-control @error('uraian_singkat') is-invalid @enderror" id="uraian_singkat" name="uraian_singkat" value="{{ old('uraian_singkat', $dokumen->uraian_singkat) }}">
                                 <trix-editor input="uraian_singkat"></trix-editor>
                                 @error('uraian_singkat')
                                    <div class="invalid-feedback">
                                       {{ $message }}
                                    </div>
                                 @enderror
                           </div>
                        </div>
                        <hr>

                        <div class="col-md-6">
                           <div class="form-group">
                                 <label for="penerima">Penerima</label>
                                 <input type="text" class="form-control @error('penerima') is-invalid @enderror" id="penerima" name="penerima" placeholder="Masukan Nama Penerima..." value="{{ old('penerima', $dokumen->penerima) }}" required/>
                                 @error('penerima')
                                    <div class="invalid-feedback">
                                       {{ $message }}
                                    </div>
                                 @enderror
                           </div>
                        </div>
                     </div>
               </form>
            </div>
         </div>
      </div>
   </div>

   <script>
      function previewPDF() {
         const fileInput = document.getElementById('file');
         const pdfPreview = document.getElementById('pdf-preview');
         
         if (fileInput.files && fileInput.files[0]) {
            const file = fileInput.files[0];
            const fileURL = URL.createObjectURL(file);
            
            if (file.type === 'application/pdf') {
               pdfPreview.style.display = 'block'; // Tampilkan iframe
               pdfPreview.src = fileURL; // Setel sumber file PDF
            } else {
               pdfPreview.style.display = 'none'; // Sembunyikan iframe jika bukan PDF
               alert('Harap unggah file dengan format PDF.');
            }
         } else {
            pdfPreview.style.display = 'none'; // Sembunyikan iframe jika tidak ada file
         }
      }
   </script>
@endsection