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
               <div class="card card-filter w-100">
                  <div class="list-group">
                      @if(session()->has('biodata_id'))
                          <a href="{{ route('pegawai.create') }}" 
                              class="btn btn-primary mb-2 {{ Route::is('pegawai.create') ? 'active' : '' }}">
                              Biodata <i class="fas fa-check text-success"></i>
                          </a>
                          <a href="{{ route('pegawai.create.kepegawaian') }}" 
                              class="btn btn-primary mb-2 {{ Route::is('pegawai.create.kepegawaian') ? 'active' : '' }}">
                              Kepegawaian
                          </a>
                          <a href="#" 
                              class="btn btn-primary mb-2 disabled">
                              Riwayat
                          </a>
                      @else
                          <a href="{{ route('pegawai.create') }}" 
                              class="btn btn-primary mb-2 {{ Route::is('pegawai.create') ? 'active' : '' }}">
                              Biodata
                          </a>
                          <a href="#" 
                              class="btn btn-primary mb-2 disabled">
                              Kepegawaian
                          </a>
                          <a href="#" 
                              class="btn btn-primary mb-2 disabled">
                              Riwayat
                          </a>
                      @endif
                  </div>
              </div>
            </div>
            <div class="col-md-9">
               <div class="card flex-fill table-responsive">
                   <table class="table table-hover my-0">
                     <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
                        <div class="search-box mb-3 mb-md-0" style="width: 100%; max-width: 300px;">
                            <select class="form-select" id="searchPegawai" name="search_pegawai">
                                <option value=""></option>
                            </select>
                        </div>
                    
                        <div id="actionButtons" class="d-flex flex-column flex-md-row align-items-center gap-1">
                            <a href="{{ route('pegawai') }}" class="btn btn-primary mb-2 mb-md-0 me-md-2"><strong>Kembali ke Daftar</strong></a>
                            <a href="{{ route('pegawai.create.riwayat.store') }}" class="btn btn-primary"><strong>Tambah</strong></a>
                        </div>
                     </div>
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
                           @foreach ($riwayat as $data)
                           <tr>
                               <td>{{ $loop->iteration }}.</td>
                               <td>{{ $data->nama_instansi }}</td>
                               <td>{{ $data->jabatan }}</td>
                               <td>{{ $data->tahun}}</td>
                               <td>{{ $data->file_pendukung}}</td>
                               <td>
                                   <div class="d-flex justify-content-center align-items-center gap-3">
                                       <a href="{{ route('pegawai.edit', $data->id) }}">
                                           <i data-feather="eye" class="text-primary"></i>
                                       </a>
                                       <form action="{{ route('pegawai.destroy', $data->slug) }}" method="post" class="m-0 p-0">
                                           @csrf
                                           @method('delete')
                                           <button type="submit" onclick="return confirm('Apakah yakin ingin menghapus data?')" style="all: unset; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                                               <i data-feather="trash-2" class="text-danger" style="width:20px;height:20px;"></i>
                                           </button>
                                       </form>
                                   </div>
                                   
                               </td>
                           </tr>
                           @endforeach
                       </tbody>
                   </table>
               </div>
           </div>
        </div>
    </div>
    
    <script>
        document.getElementById('foto').addEventListener('change', function(event) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const photoPreview = document.getElementById('photoPreview');
                photoPreview.src = e.target.result;
                photoPreview.style.display = 'block';
            };
            reader.readAsDataURL(this.files[0]);
        });

        // Fungsi reset jika diperlukan
        function resetForm() {
            document.getElementById("pegawaiForm").reset();
            document.getElementById("photoPreview").style.display = "none";
            document.getElementById("foto").value = "";        }

    </script>
@endsection