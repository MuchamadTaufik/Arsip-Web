@extends('admin.layouts.main')

@section('container')
   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
               <div id="actionButtons" class="d-flex flex-column flex-md-row align-items-center gap-1">
                  <a href="{{ route('pegawai') }}" class="btn btn-secondary" id="kembaliDaftarBtn">
                     <i data-feather="arrow-left"></i> Kembali ke Daftar
                  </a>
                  <a href="{{ route('pegawai.edit', $biodata->id) }}" class="btn btn-warning" id="editBtn">
                     <i data-feather="edit"></i> Edit
                  </a>
                  <form action="{{ route('pegawai.destroy', $biodata->id) }}" method="POST" id="hapusForm" style="display:inline;">
                     @csrf
                     @method('DELETE')
                     <button type="submit" class="btn btn-danger" id="hapusBtn" onclick="return confirm('Apakah yakin ingin menghapus data?')">
                        <i data-feather="trash-2"></i> Hapus
                     </button>
                  </form>
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
                  @if($biodata->foto)
                     <img src="{{ asset('storage/' . $biodata->foto) }}" alt="{{ $biodata->nama_pegawai }}" 
                        class="img-fluid mb-3" style="max-width: 150px;">
                  @else
                     <img src="{{ asset('images/default-profile.png') }}" alt="Default Profile" 
                        class="img-fluid mb-3" style="max-width: 150px;">
                  @endif
                  <h5 class="card-title">{{ $biodata->nama_pegawai }}</h5>
                  <p class="card-text text-muted">{{ $biodata->nip }}</p>
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
            <div class="card">
               <div class="card-body">
                  <div class="tab-content">
                     <!-- Biodata Tab -->
                     <div class="tab-pane fade show active" id="biodata">
                        <h5 class="card-title mb-4">Data Personal</h5>
                        <div class="row g-3">
                           <div class="col-md-6">
                              <label class="form-label">NIP</label>
                              <p class="form-control">{{ $biodata->nip }}</p>
                           </div>
                           
                           <div class="col-md-6">
                              <label class="form-label">Nama Lengkap</label>
                              <p class="form-control">{{ $biodata->nama_pegawai }}</p>
                           </div>
                           
                           <div class="col-md-6">
                              <label class="form-label">Jenis Kelamin</label>
                              <p class="form-control">{{ $biodata->jenis_kelamin }}</p>
                           </div>

                           <div class="col-md-6">
                              <label class="form-label">Agama</label>
                              <p class="form-control">{{ $biodata->agama }}</p>
                           </div>

                           <div class="col-md-6">
                              <label class="form-label">Tempat Lahir</label>
                              <p class="form-control">{{ $biodata->tempat_lahir }}</p>
                           </div>

                           <div class="col-md-6">
                              <label class="form-label">Tanggal Lahir</label>
                              <p class="form-control">{{ \Carbon\Carbon::parse($biodata->tanggal_lahir)->format('d F Y') }}</p>
                           </div>

                           <div class="col-md-12">
                              <label class="form-label">Alamat</label>
                              <p class="form-control">{{ $biodata->alamat }}</p>
                           </div>

                           <div class="col-md-6">
                              <label class="form-label">Email</label>
                              <p class="form-control">{{ $biodata->email }}</p>
                           </div>

                           <div class="col-md-6">
                              <label class="form-label">No. Telepon</label>
                              <p class="form-control">{{ $biodata->no_telp }}</p>
                           </div>
                        </div>
                     </div>

                     <!-- Kepegawaian Tab -->
                     <div class="tab-pane fade" id="kepegawaian">
                        <h5 class="card-title mb-4">Data Kepegawaian</h5>
                        <div class="row g-3">
                           <div class="col-md-6">
                              <label class="form-label">Unit</label>
                              <p class="form-control">{{ $biodata->pegawai->unit->name ?? '-' }}</p>
                           </div>

                           <div class="col-md-6">
                              <label class="form-label">Status</label>
                              <p class="form-control">{{ $biodata->pegawai->status ?? '-' }}</p>
                           </div>

                           <div class="col-md-6">
                              <label class="form-label">Hubungan Kerja</label>
                              <p class="form-control">{{ $biodata->pegawai->hubungan_kerja ?? '-' }}</p>
                           </div>

                           <div class="col-md-6">
                              <label class="form-label">Jabatan</label>
                              <p class="form-control">{{ $biodata->pegawai->jabatan ?? '-' }}</p>
                           </div>
                        </div>
                     </div>

                     <!-- Riwayat Tab -->
                     <div class="tab-pane fade" id="riwayat">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                           <h5 class="card-title">Riwayat Pekerjaan</h5>
                        </div>
                        <div class="table-responsive">
                           <table class="table table-hover" id="riwayatTable">
                              <thead>
                                 <tr>
                                    <th>No</th>
                                    <th>Nama Instansi</th>
                                    <th>Jabatan</th>
                                    <th>Tahun</th>
                                    <th>File Pendukung</th>
                                    <th>Aksi</th>
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
                                       <td>
                                          <form action="{{ route('pegawai.riwayat.destroy', $riwayat->id) }}" method="POST" style="display:inline;">
                                             @csrf
                                             @method('DELETE')
                                             <button type="submit" class="btn btn-danger remove-riwayat" onclick="return confirm('Apakah yakin ingin menghapus data?')">
                                                <i data-feather="trash-2" style="width:20px;height:20px;"></i>
                                             </button>
                                          </form>
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
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection

@push('scripts')
<script>
   // Initialize Feather Icons
   document.addEventListener("DOMContentLoaded", function() {
      feather.replace();
   });
</script>
@endpush