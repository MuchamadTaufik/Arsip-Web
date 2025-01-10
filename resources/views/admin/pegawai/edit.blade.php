@extends('admin.layouts.main')

@section('container')
   <div class="container">
      <form id="pegawaiForm" method="post" action="{{ route('pegawai.update', $biodata->id) }}" enctype="multipart/form-data">
         @method('put')
         @csrf
         <div class="row">
            <div class="col-md-12">
               <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
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
                           <img id="photoPreview" src="{{ $biodata->foto ? asset('storage/' . $biodata->foto) : '#' }}" 
                              alt="Preview" class="img-fluid mb-3" 
                              style="{{ $biodata->foto ? '' : 'display: none;' }} max-width: 150px;">
                           <div>
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
                                          <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" required value="{{ old('nip', $biodata->nip) }}" placeholder="NIP">
                                             @error('nip')
                                                <div class="invalid-feedback">
                                                   {{ $message }}
                                                </div>
                                             @enderror
                                       </div>
                                       
                                       <div class="col-md-12">
                                          <input type="text" class="form-control @error('nama_pegawai') is-invalid @enderror" id="nama_pegawai" name="nama_pegawai" required value="{{ old('nama_pegawai', $biodata->nama_pegawai ) }}" placeholder="Nama">
                                             @error('nama_pegawai')
                                                <div class="invalid-feedback">
                                                      {{ $message }}
                                                </div>
                                             @enderror
                                       </div>
                                       
                                       <div class="col-md-12">
                                             <select class="form-control @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
                                                <option value="" disabled {{ old('jenis_kelamin', $biodata->jenis_kelamin) == '' ? 'selected' : '' }}>Jenis Kelamin</option>
                                                <option value="Laki-Laki" {{ old('jenis_kelamin', $biodata->jenis_kelamin) == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                                <option value="Perempuan" {{ old('jenis_kelamin', $biodata->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
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

                                       <div class="col-md-12">
                                             <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" required value="{{ old('tempat_lahir', $biodata->tempat_lahir) }}" placeholder="Tempat Lahir">
                                             @error('tempat_lahir')
                                                <div class="invalid-feedback">
                                                   {{ $message }}
                                                </div>
                                             @enderror
                                       </div>

                                       <div class="col-md-12">
                                             <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                             <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" required value="{{ old('tanggal_lahir', $biodata->tanggal_lahir) }}" placeholder="Tanggal Lahir">
                                             @error('tanggal_lahir')
                                                <div class="invalid-feedback">
                                                   {{ $message }}
                                                </div>
                                             @enderror
                                       </div> 

                                       <div class="col-md-12">
                                             <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" required value="{{ old('alamat', $biodata->alamat) }}" placeholder="Alamat">
                                             @error('alamat')
                                                <div class="invalid-feedback">
                                                   {{ $message }}
                                                </div>
                                             @enderror
                                       </div>

                                       <div class="col-md-12">
                                             <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required value="{{ old('email', $biodata->email) }}" placeholder="Email">
                                             @error('email')
                                                <div class="invalid-feedback">
                                                   {{ $message }}
                                                </div>
                                             @enderror
                                       </div>
                                       <div class="col-md-12">
                                             <label for="tanggal_lahir" class="form-label">Nomor Telepon</label>
                                             <input type="number" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp" name="no_telp" required value="{{ old('no_telp', $biodata->no_telp) }}" placeholder="6281234563899">
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
                                          <select class="form-control @error('unit_id') is-invalid @enderror" 
                                                name="unit_id" required>
                                             <option value="">Pilih Unit</option>
                                             @foreach($units as $unit)
                                                <option value="{{ $unit->id }}" 
                                                      {{ old('unit_id', optional($biodata->pegawai)->unit_id) == $unit->id ? 'selected' : '' }}>
                                                   {{ $unit->name }}
                                                </option>
                                             @endforeach
                                          </select>
                                       </div>

                                       <div class="col-md-12">
                                             <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                                <option value="" disabled {{ old('status', $biodata->pegawai->status) == '' ? 'selected' : '' }}>Status</option>
                                                <option value="Aktif" {{ old('status', $biodata->pegawai->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="Tidak Aktif" {{ old('status', $biodata->pegawai->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                                <option value="Cuti Luar Tanggungan" {{ old('status', $biodata->pegawai->status) == 'Cuti Luar Tanggungan' ? 'selected' : '' }}>Cuti Luar Tanggungan</option>
                                                <option value="Kontrak Habis" {{ old('status', $biodata->pegawai->status) == 'Kontrak Habis' ? 'selected' : '' }}>Kontrak Habis</option>
                                                <option value="Meninggal Dunia" {{ old('status', $biodata->pegawai->status) == 'Meninggal Dunia' ? 'selected' : '' }}>Meninggal Dunia</option>
                                                <option value="Mangkir 5 Kali Berturut-turut" {{ old('status', $biodata->pegawai->status) == 'Mangkir 5 Kali Berturut-turut' ? 'selected' : '' }}>Mangkir 5 Kali Berturut-turut</option>
                                                <option value="Mengundurkan Diri" {{ old('status', $biodata->pegawai->status) == 'Mengundurkan Diri' ? 'selected' : '' }}>Mengundurkan Diri</option>
                                                <option value="Pensiun Dini" {{ old('status'), $biodata->pegawai->status == 'Pensiun Dini' ? 'selected' : '' }}>Pensiun Dini</option>
                                                <option value="PHK" {{ old('status', $biodata->pegawai->status) == 'PHK' ? 'selected' : '' }}>PHK</option>
                                                <option value="Pelanggaran" {{ old('status', $biodata->pegawai->status) == 'Pelanggaran' ? 'selected' : '' }}>Pelanggaran</option>
                                                <option value="Pensiun Normal" {{ old('status', $biodata->pegawai->status) == 'Pensiun Normal' ? 'selected' : '' }}>Pensiun Normal</option>
                                                <option value="Pernikahakan Sesama Karyawan" {{ old('status', $biodata->pegawai->status) == 'Pernikahakan Sesama Karyawan' ? 'selected' : '' }}>Pernikahakan Sesama Karyawan</option>
                                                <option value="Kesalahan Berat" {{ old('status', $biodata->pegawai->status) == 'Kesalahan Berat' ? 'selected' : '' }}>Kesalahan Berat</option>
                                                <option value="Sakit Berkepanjangan" {{ old('status', $biodata->pegawai->status) == 'Sakit Berkepanjangan' ? 'selected' : '' }}>Sakit Berkepanjangan</option>
                                                <option value="Tugas Belajar" {{ old('status', $biodata->pegawai->status) == 'Tugas Belajar' ? 'selected' : '' }}>Tugas Belajar</option>
                                                <option value="Ditahan Pihak Berwajib" {{ old('status', $biodata->pegawai->status) == 'Ditahan Pihak Berwajib' ? 'selected' : '' }}>Ditahan Pihak Berwajib</option>
                                             </select>
                                             @error('status')
                                                <div class="invalid-feedback">
                                                   {{ $message }}
                                                </div>
                                             @enderror
                                       </div> 

                                       <div class="col-md-12">
                                          <select class="form-control @error('hubungan_kerja') is-invalid @enderror" id="hubungan_kerja" name="hubungan_kerja" required>
                                             <option value="" disabled {{ old('hubungan_kerja', $biodata->hubungan_kerja) == '' ? 'selected' : '' }}>hubungan_kerja</option>
                                             <option value="Tetap Yayasan" {{ old('hubungan_kerja', $biodata->hubungan_kerja) == 'Tetap Yayasan' ? 'selected' : '' }}>Tetap Yayasan</option>
                                             <option value="Partime" {{ old('hubungan_kerja', $biodata->hubungan_kerja) == 'Partime' ? 'selected' : '' }}>Partime</option>
                                             <option value="PNS/DPK" {{ old('hubungan_kerja', $biodata->hubungan_kerja) == 'PNS/DPK' ? 'selected' : '' }}>PNS/DPK</option>
                                             <option value="Fulltime" {{ old('hubungan_kerja', $biodata->hubungan_kerja) == 'Fulltime' ? 'selected' : '' }}>Fulltime</option>
                                             <option value="Kontrak" {{ old('hubungan_kerja', $biodata->hubungan_kerja) == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                                          </select>
                                          @error('hubungan_kerja')
                                                <div class="invalid-feedback">
                                                   {{ $message }}
                                                </div>
                                             @enderror
                                       </div>
                                       <div class="col-md-12">
                                             <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" required value="{{ old('jabatan', $biodata->pegawai->jabatan) }}" placeholder="Jabatan">
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
                                    <div class="flex-fill table-responsive">
                                       <table class="table table-hover my-0" id="riwayatTable">
                                          <div class="d-flex justify-content-between align-items-center mb-3" style="padding: 10px">
                                             <button type="button" class="btn btn-primary ms-auto" id="addRiwayat">
                                                <i data-feather="plus"></i> Tambah
                                             </button>
                                          </div>
                                          <thead>
                                             <tr>
                                                   <th>No</th>
                                                   <th>Nama Instansi</th>
                                                   <th>Jabatan</th>
                                                   <th>Tahun</th>
                                                   <th>File Pendukung</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             @forelse($biodata->riwayat ?? [] as $index => $riwayat)
                                                <tr>
                                                   <td>{{ $index + 1 }}</td>
                                                   <td>{{ $riwayat->nama_instansi }}</td>
                                                   <td>{{ $riwayat->jabatan }}</td>
                                                   <td>{{ $riwayat->tahun }}</td>
                                                   <td>
                                                      @if($riwayat->file_pendukung)
                                                         <a href="{{ asset('storage/' . $riwayat->file_pendukung) }}" 
                                                            class="btn btn-sm btn-info" target="_blank">
                                                            <i data-feather="file"></i> Lihat
                                                         </a>
                                                      @else
                                                         -
                                                      @endif
                                                   </td>
                                                </tr>
                                             @empty
                                                <tr>
                                                   <td colspan="6" class="text-center">Belum ada data riwayat</td>
                                                </tr>
                                             @endforelse
                                          </tbody>
                                       </table>
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
         <div class="riwayat-item mb-3">
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
      document.addEventListener('DOMContentLoaded', function() {
         // Photo Preview dengan validasi
         const photoInput = document.getElementById('foto');
         const photoPreview = document.getElementById('photoPreview');
         
         photoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                  // Validasi tipe file
                  if (!file.type.match('image.*')) {
                     alert('Mohon pilih file gambar');
                     this.value = '';
                     return;
                  }

                  // Validasi ukuran (max 2MB)
                  if (file.size > 2 * 1024 * 1024) {
                     alert('Ukuran file tidak boleh lebih dari 2MB');
                     this.value = '';
                     return;
                  }

                  const reader = new FileReader();
                  reader.onload = e => {
                     photoPreview.src = e.target.result;
                     photoPreview.style.display = 'block';
                  };
                  reader.readAsDataURL(file);
            }
         });

         // Manajemen Riwayat dengan validasi
         let riwayatCount = 0;
         const riwayatContainer = document.getElementById('riwayatContainer');
         const riwayatTable = document.getElementById('riwayatTable');
         const existingRiwayat = document.querySelectorAll('#riwayatTable tbody tr').length - 1;
         
         function updateRiwayatVisibility() {
            const showTable = riwayatCount === 0 && existingRiwayat > 0;
            riwayatTable.style.display = showTable ? 'table' : 'none';
         }

         function validateRiwayatInputs(container) {
            const inputs = container.querySelectorAll('input[required]');
            let isValid = true;
            inputs.forEach(input => {
                  if (!input.value) {
                     input.classList.add('is-invalid');
                     isValid = false;
                  }
            });
            return isValid;
         }

         document.getElementById('addRiwayat').addEventListener('click', function() {
            // Validasi riwayat sebelumnya jika ada
            if (riwayatCount > 0) {
                  const lastRiwayat = riwayatContainer.lastElementChild;
                  if (!validateRiwayatInputs(lastRiwayat)) {
                     alert('Mohon lengkapi data riwayat sebelumnya');
                     return;
                  }
            }

            riwayatCount++;
            const template = document.getElementById('riwayatTemplate');
            const clone = document.importNode(template.content, true);
            
            // Update index dan nomor
            clone.querySelectorAll('[name*="__index__"]').forEach(input => {
                  input.name = input.name.replace('__index__', riwayatCount - 1);
                  
                  // Tambah validasi untuk setiap input
                  input.addEventListener('input', function() {
                     this.classList.remove('is-invalid');
                  });
            });
            
            // Update nomor riwayat
            clone.querySelector('.riwayat-number').textContent = riwayatCount;
            
            // Tambah handler remove dengan konfirmasi
            const removeBtn = clone.querySelector('.remove-riwayat');
            removeBtn.addEventListener('click', function() {
                  if (confirm('Apakah Anda yakin ingin menghapus riwayat ini?')) {
                     this.closest('.riwayat-item').remove();
                     riwayatCount--;
                     updateRiwayatNumbers();
                     updateRiwayatVisibility();
                  }
            });

            // Validasi file pendukung
            const fileInput = clone.querySelector('input[type="file"]');
            fileInput.addEventListener('change', function() {
                  const file = this.files[0];
                  if (file && file.size > 2 * 1024 * 1024) {
                     alert('Ukuran file tidak boleh lebih dari 2MB');
                     this.value = '';
                  }
            });
            
            riwayatContainer.appendChild(clone);
            updateRiwayatVisibility();
            feather.replace();
         });

         // Update nomor riwayat setelah menghapus
         function updateRiwayatNumbers() {
            document.querySelectorAll('.riwayat-number').forEach((span, index) => {
                  span.textContent = index + 1;
            });
         }

         // Form Validation dan Submit
         const form = document.getElementById('pegawaiForm');
         form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                  e.preventDefault();
                  e.stopPropagation();
                  
                  // Fokus ke tab dengan error pertama
                  const firstInvalid = form.querySelector(':invalid');
                  if (firstInvalid) {
                     const tabPane = firstInvalid.closest('.tab-pane');
                     if (tabPane) {
                        const tabId = tabPane.id;
                        document.querySelector(`[data-bs-target="#${tabId}"]`).click();
                     }
                     firstInvalid.focus();
                  }
            } else {
                  const submitBtn = form.querySelector('button[type="submit"]');
                  submitBtn.disabled = true;
                  submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menyimpan...';
            }
            form.classList.add('was-validated');
         });

         // Inisialisasi validasi form
         const requiredInputs = form.querySelectorAll('input[required], select[required]');
         requiredInputs.forEach(input => {
            input.addEventListener('invalid', () => input.classList.add('is-invalid'));
            input.addEventListener('input', () => {
                  if (input.validity.valid) {
                     input.classList.remove('is-invalid');
                  }
            });
         });
      });
   </script>
@endsection