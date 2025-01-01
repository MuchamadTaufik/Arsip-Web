@extends('admin.layouts.main')

@section('container')
   <div class="container">
      <form id="pegawaiForm" method="post" action="{{ route('pegawai.store') }}" enctype="multipart/form-data">
         @csrf
         <div class="row">
            <div class="col-md-12">
               <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
                  <div class="search-box mb-3 mb-md-0" style="width: 100%; max-width: 300px;">
                     <select class="form-select" id="searchPegawai" name="search_pegawai">
                        <option value=""></option>
                     </select>
                  </div>
            
                  <div id="actionButtons" class="d-flex flex-column flex-md-row align-items-center gap-1">
                     <a href="{{ route('pegawai') }}" class="btn btn-secondary">
                        <i data-feather="arrow-left"></i> Kembali ke Daftar
                     </a>
                     <button type="submit" class="btn btn-primary">
                        <i data-feather="save"></i> Simpan
                     </button>
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
               <!-- Sidebar -->
               <div class="col-md-3">
                  <!-- Foto Preview Card -->
                  <div class="card mb-3">
                     <div class="card-body text-center">
                           <img id="photoPreview" src="#" alt="Preview" class="img-fluid mb-3" style="max-width: 150px; display: none;">
                           <div class="mb-3">
                              <label for="foto" class="form-label">Foto Pegawai</label>
                              <input type="file" class="form-control @error('foto') is-invalid @enderror" 
                                    id="foto" name="foto" accept="image/*">
                              @error('foto')
                                 <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>
                     </div>
                  </div>

                  <!-- Navigation Card -->
                  <div class="card">
                     <div class="card-body p-2">
                           <div class="nav flex-column nav-pills" role="tablist">
                              <button class="btn btn-primary mb-2 active" data-bs-toggle="pill" data-bs-target="#biodata" type="button">
                                 Biodata
                              </button>
                              <button class="btn btn-primary mb-2" data-bs-toggle="pill" data-bs-target="#kepegawaian" type="button">
                                 Kepegawaian
                              </button>
                              <button class="btn btn-primary" data-bs-toggle="pill" data-bs-target="#riwayat" type="button">
                                 Riwayat
                              </button>
                           </div>
                     </div>
                  </div>
               </div>

               <!-- Main Content -->
               <div class="col-md-9">

                  <!-- Form Content -->
                  <div class="card">
                     <div class="card-body">
                        
                           <div class="tab-content">
                              <!-- Biodata Tab -->
                              <div class="tab-pane fade show active" id="biodata">
                                 <div class="row g-3">
                                       <div class="col-md-12">
                                          <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" required value="{{ old('nip') }}" placeholder="NIP">
                                             @error('nip')
                                                <div class="invalid-feedback">
                                                   {{ $message }}
                                                </div>
                                             @enderror
                                       </div>
                                       
                                       <div class="col-md-12">
                                          <input type="text" class="form-control @error('nama_pegawai') is-invalid @enderror" id="nama_pegawai" name="nama_pegawai" required value="{{ old('nama_pegawai') }}" placeholder="Nama">
                                             @error('nama_pegawai')
                                                <div class="invalid-feedback">
                                                      {{ $message }}
                                                </div>
                                             @enderror
                                       </div>
                                       
                                       <div class="col-md-12">
                                             <select class="form-control @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
                                                <option value="" disabled {{ old('jenis_kelamin') == '' ? 'selected' : '' }}>Jenis Kelamin</option>
                                                <option value="Laki-Laki" {{ old('jenis_kelamin') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                             </select>
                                             @error('jenis_kelamin')
                                                <div class="invalid-feedback">
                                                   {{ $message }}
                                                </div>
                                             @enderror
                                       </div>

                                       <div class="col-md-12">
                                             <select class="form-control @error('agama') is-invalid @enderror" id="agama" name="agama" required>
                                                <option value="">Agama</option>
                                                <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                                <option value="Kristen Protestan" {{ old('agama') == 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                                                <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                                <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                                <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                                <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                             </select>
                                             @error('agama')
                                                <div class="invalid-feedback">
                                                   {{ $message }}
                                                </div>
                                             @enderror
                                       </div>

                                       <div class="col-md-12">
                                             <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" required value="{{ old('tempat_lahir') }}" placeholder="Tempat Lahir">
                                             @error('tempat_lahir')
                                                <div class="invalid-feedback">
                                                   {{ $message }}
                                                </div>
                                             @enderror
                                       </div>

                                       <div class="col-md-12">
                                             <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                             <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" required value="{{ old('tanggal_lahir') }}" placeholder="Tanggal Lahir">
                                             @error('tanggal_lahir')
                                                <div class="invalid-feedback">
                                                   {{ $message }}
                                                </div>
                                             @enderror
                                       </div> 

                                       <div class="col-md-12">
                                             <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" required value="{{ old('alamat') }}" placeholder="Alamat">
                                             @error('alamat')
                                                <div class="invalid-feedback">
                                                   {{ $message }}
                                                </div>
                                             @enderror
                                       </div>

                                       <div class="col-md-12">
                                             <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required value="{{ old('email') }}" placeholder="Email">
                                             @error('email')
                                                <div class="invalid-feedback">
                                                   {{ $message }}
                                                </div>
                                             @enderror
                                       </div>
                                       <div class="col-md-12">
                                             <label for="tanggal_lahir" class="form-label">Nomor Telepon</label>
                                             <input type="number" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp" name="no_telp" required value="{{ old('no_telp') }}" placeholder="6281234563899">
                                             @error('no_telp')
                                                <div class="invalid-feedback">
                                                   {{ $message }}
                                                </div>
                                             @enderror
                                       </div>
                                 </div>
                              </div>

                              <!-- Kepegawaian Tab -->
                              <div class="tab-pane fade" id="kepegawaian">
                                 <div class="row g-3">
                                       <div class="col-md-12">
                                          <select class="form-select @error('unit_id') is-invalid @enderror" 
                                                   name="unit_id" required>
                                             <option value="">Pilih Unit</option>
                                             @foreach($units as $unit)
                                                   <option value="{{ $unit->id }}" {{ (old('unit_id') ?? '') == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                                             @endforeach
                                          </select>
                                       </div>

                                       <div class="col-md-12">
                                             <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                                <option value="" disabled {{ old('status') == '' ? 'selected' : '' }}>Status</option>
                                                <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="Non-Aktif" {{ old('status') == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                                             </select>
                                             @error('status')
                                                <div class="invalid-feedback">
                                                   {{ $message }}
                                                </div>
                                             @enderror
                                       </div> 

                                       <div class="col-md-12">
                                          <input type="text" class="form-control @error('hubungan_kerja') is-invalid @enderror" id="hubungan_kerja" name="hubungan_kerja" required value="{{ old('hubungan_kerja') }}" placeholder="Hubungan Kerja">
                                             @error('hubungan_kerja')
                                                <div class="invalid-feedback">
                                                   {{ $message }}
                                                </div>
                                             @enderror
                                       </div>
                                       <div class="col-md-12">
                                             <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" required value="{{ old('jabatan') }}" placeholder="Jabatan">
                                             @error('jabatan')
                                                <div class="invalid-feedback">
                                                   {{ $message }}
                                                </div>
                                             @enderror
                                       </div>
                                 </div>
                              </div>

                              <!-- Riwayat Tab -->
                              <div class="tab-pane fade" id="riwayat">
                                 <div class="d-flex justify-content-between align-items-center mb-3">
                                       <button type="button" class="btn btn-primary btn-sm" id="addRiwayat">
                                          <i data-feather="plus"></i> Tambah Riwayat
                                       </button>
                                 </div>
                                 
                                 <div id="riwayatContainer">
                                       <!-- Riwayat items will be added here -->
                                 </div>
                              </div>
                           </div>
                     </div>
                  </div>
               </div>
         </div>
      </form>
   </div>

   <!-- Riwayat Template -->
   <template id="riwayatTemplate">
         <div class="riwayat-item card mb-3">
            <div class="card-body">
               <div class="d-flex justify-content-between align-items-center mb-3">
                     <h6 class="card-subtitle">Riwayat #<span class="riwayat-number"></span></h6>
                     <button type="button" class="btn btn-danger btn-sm remove-riwayat">
                        <i data-feather="trash-2"></i>
                     </button>
               </div>
               <div class="row g-3">
                     <div class="col-md-12">
                        <input type="text" class="form-control @error('riwayat.*.nama_instansi') is-invalid @enderror" 
                              name="riwayat[__index__][nama_instansi]" 
                              placeholder="Nama Instansi">
                        @error('riwayat.*.nama_instansi')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>
                     <div class="col-md-12">
                        <input type="text" class="form-control @error('riwayat.*.jabatan') is-invalid @enderror" 
                              name="riwayat[__index__][jabatan]" 
                              placeholder="Jabatan">
                        @error('riwayat.*.jabatan')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>
                     <div class="col-md-12">
                        <input type="number" class="form-control @error('riwayat.*.tahun') is-invalid @enderror" 
                              name="riwayat[__index__][tahun]" 
                              placeholder="Tahun" 
                              pattern="\d{4}">
                        @error('riwayat.*.tahun')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>
                     <div class="col-md-12">
                        <label class="form-label">File Pendukung</label>
                        <input type="file" class="form-control @error('riwayat.*.file_pendukung') is-invalid @enderror" 
                              name="riwayat[__index__][file_pendukung]">
                        @error('riwayat.*.file_pendukung')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                        @enderror
                     </div>
               </div>
            </div>
         </div>
   </template>

   <script>
      // Photo Preview
      document.getElementById('foto').addEventListener('change', function(e) {
         const reader = new FileReader();
         reader.onload = function(e) {
            const preview = document.getElementById('photoPreview');
            preview.src = e.target.result;
            preview.style.display = 'block';
         };
         reader.readAsDataURL(this.files[0]);
      });

      // Dynamic Riwayat
      let riwayatCount = 0;
      const riwayatContainer = document.getElementById('riwayatContainer');
      const riwayatTemplate = document.getElementById('riwayatTemplate');

      document.getElementById('addRiwayat').addEventListener('click', function() {
         const newRiwayat = document.importNode(riwayatTemplate.content, true);
         riwayatCount++;
         
         // Update nomor dan index
         newRiwayat.querySelector('.riwayat-number').textContent = riwayatCount;
         newRiwayat.querySelectorAll('input').forEach(input => {
            input.name = input.name.replace('__index__', riwayatCount - 1);
         });
         
         // Event handler untuk remove button
         newRiwayat.querySelector('.remove-riwayat').addEventListener('click', function() {
            this.closest('.riwayat-item').remove();
         });
         
         riwayatContainer.appendChild(newRiwayat);
         feather.replace();
      });

      // Form Validation
      document.getElementById('pegawaiForm').addEventListener('submit', function(e) {
         e.preventDefault();
         
         // Custom validation jika diperlukan
         
         this.submit();
      });
   </script>
@endsection