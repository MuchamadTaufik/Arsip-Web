@extends('admin.layouts.main')

@section('container')
   <div class="container">
      <div class="row">
         <div class="col-md-3">
            <div class="card card-filter w-100 justify-content-center align-items-center p-3">
               <label for="foto">Foto Pegawai</label>
               <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/*">
               @error('foto')
                  <div class="invalid-feedback">
                     {{ $message }}
                  </div>
               @enderror

               <!-- Preview of the existing photo or new photo -->
               <img id="photoPreview" src="{{ $biodata->foto ? asset('storage/' . $biodata->foto) : '#' }}" alt="Photo Preview" class="img-fluid mt-3" style="height: auto; width: 100px; display: {{ $biodata->foto ? 'block' : 'none' }};">
            </div>
            <div class="card card-filter w-100 mt-3">
                  <div class="list-group">
                     <a href="{{ route('pegawai.create') }}" class="btn btn-primary mb-2 {{ Route::is('pegawai.create*') ? 'active' : '' }}">Biodata</a>
                     <a href="{{ route('pegawai.create.kepegawaian') }}" class="btn btn-primary mb-2">Kepegawaian</a>
                     <a href="#" class="btn btn-primary mb-2">Riwayat</a>
                  </div>
            </div>
         </div>
      
         <div class="col-md-9">
            <div class="form">
                  <form class="row" id="pegawaiForm" method="post" action="{{ route('pegawai.update', $biodata->slug) }}" enctype="multipart/form-data">
                     @method('put')
                     @csrf                   
                     <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
                        <div class="search-box mb-3 mb-md-0">
                           <a href="{{ route('pegawai') }}" class="btn btn-primary mb-2 mb-md-0 me-md-2"><strong>Kembali ke Daftar</strong></a>
                        </div>
                     
                        <div id="actionButtons" class="d-flex flex-column flex-md-row align-items-center">
                              <button class="btn btn-primary" type="submit"><strong>Update</strong></button>
                        </div>
                     </div>

                     <!-- Hidden input for photo -->
                     <input type="file" id="hidden_foto" name="foto" style="display: none;">

                     <div class="col-md-12 mb-3">
                        <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" required value="{{ old('nip', $biodata->nip) }}" placeholder="NIP">
                        @error('nip')
                              <div class="invalid-feedback">
                                 {{ $message }}
                              </div>
                        @enderror
                     </div>
                     <div class="col-md-12 mb-3">
                        <input type="text" class="form-control @error('nama_pegawai') is-invalid @enderror" id="nama_pegawai" name="nama_pegawai" required value="{{ old('nama_pegawai', $biodata->nama_pegawai) }}" placeholder="Nama">
                        @error('nama_pegawai')
                              <div class="invalid-feedback">
                                 {{ $message }}
                              </div>
                        @enderror
                     </div>
                     <div class="col-md-12 mb-3">
                        <select class="form-control @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
                              <option value="">Pilih Jenis Kelamin</option>
                              <option value="Laki-Laki" {{ old('jenis_kelamin', $biodata->jenis_kelamin) == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                              <option value="Perempuan" {{ old('jenis_kelamin', $biodata->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                              <div class="invalid-feedback">
                                 {{ $message }}
                              </div>
                        @enderror
                     </div>                        
                     <div class="col-md-12 mb-3">
                        <select class="form-control @error('agama') is-invalid @enderror" id="agama" name="agama" required>
                              <option value="">Pilih Agama</option>
                              <option value="Islam" {{ old('agama', $biodata->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                              <option value="Kristen Protestan" {{ old('agama', $biodata->agama) == 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                              <option value="Katolik" {{ old('agama', $biodata->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                              <option value="Hindu" {{ old('agama', $biodata->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                              <option value="Buddha" {{ old('agama', $biodata->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                              <option value="Konghucu" {{ old('agama', $biodata->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                        </select>
                        @error('agama')
                              <div class="invalid-feedback">
                                 {{ $message }}
                              </div>
                        @enderror
                     </div>                        
                     <div class="col-md-12 mb-3">
                        <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" required value="{{ old('tempat_lahir', $biodata->tempat_lahir) }}" placeholder="Tempat Lahir">
                        @error('tempat_lahir')
                              <div class="invalid-feedback">
                                 {{ $message }}
                              </div>
                        @enderror
                     </div>
                     <div class="col-md-12 mb-3">
                        <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" required value="{{ old('tanggal_lahir', $biodata->tanggal_lahir) }}" placeholder="Tanggal Lahir">
                        @error('tanggal_lahir')
                              <div class="invalid-feedback">
                                 {{ $message }}
                              </div>
                        @enderror
                     </div> 
                     <div class="col-md-12 mb-3">
                        <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" required value="{{ old('alamat', $biodata->alamat) }}" placeholder="Alamat">
                        @error('alamat')
                              <div class="invalid-feedback">
                                 {{ $message }}
                              </div>
                        @enderror
                     </div>
                     <div class="col-md-12 mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required value="{{ old('email', $biodata->email) }}" placeholder="Email">
                        @error('email')
                              <div class="invalid-feedback">
                                 {{ $message }}
                              </div>
                        @enderror
                     </div>
                     <div class="col-md-12 mb-3">
                        <input type="number" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp" name="no_telp" required value="{{ old('no_telp', $biodata->no_telp) }}" placeholder="6281234563899">
                        @error('no_telp')
                              <div class="invalid-feedback">
                                 {{ $message }}
                              </div>
                        @enderror
                     </div>                                     
                  </form>
            </div>
         </div>
      </div>
   </div> 

   <script>
      document.addEventListener('DOMContentLoaded', function() {
         const fotoInput = document.getElementById('foto');
         const hiddenFoto = document.getElementById('hidden_foto');
         const photoPreview = document.getElementById('photoPreview');
         const mainForm = document.getElementById('pegawaiForm');

         // Handle photo selection
         fotoInput?.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                  // Update preview
                  const reader = new FileReader();
                  reader.onload = function(e) {
                     photoPreview.src = e.target.result;
                     photoPreview.style.display = 'block';
                  };
                  reader.readAsDataURL(file);

                  // Transfer file to hidden input
                  const dataTransfer = new DataTransfer();
                  dataTransfer.items.add(file);
                  hiddenFoto.files = dataTransfer.files;
            }
         });

         // Form submission validation - Only for the main form
         mainForm?.addEventListener('submit', function(e) {
            // Check if this is the main form (not the delete form)
            if (this.getAttribute('action').includes('store') || this.getAttribute('action').includes('update')) {
                  // Only validate if this is a new entry or if photo input has been touched
                  if (!photoPreview.src.includes('storage') && !hiddenFoto.files.length) {
                     e.preventDefault();
                     alert('Silakan pilih foto terlebih dahulu');
                  }
            }
         });

         // Initialize photo preview if exists
         if (photoPreview?.src && !photoPreview.src.endsWith('#')) {
            photoPreview.style.display = 'block';
         }
      });

      // Reset function if needed
      function resetForm() {
         const form = document.getElementById('pegawaiForm');
         const photoPreview = document.getElementById('photoPreview');
         const fotoInput = document.getElementById('foto');
         const hiddenFoto = document.getElementById('hidden_foto');
         
         if (form) form.reset();
         if (photoPreview) {
            photoPreview.style.display = 'none';
            photoPreview.src = '#';
         }
         if (fotoInput) fotoInput.value = '';
         if (hiddenFoto) hiddenFoto.value = '';
      }
   </script>
@endsection