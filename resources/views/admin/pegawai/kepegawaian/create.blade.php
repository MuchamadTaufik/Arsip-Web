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
                <div class="form">
                    <form class="row" id="pegawaiForm" method="post" action="{{ route('pegawai.create.kepegawaian.store') }}" enctype="multipart/form-data">
                        @csrf                   
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
                            <div class="search-box mb-3 mb-md-0" style="width: 100%; max-width: 300px;">
                                <select class="form-select" id="searchPegawai" name="search_pegawai">
                                    <option value=""></option>
                                </select>
                            </div>
                        
                            <div id="actionButtons" class="d-flex flex-column flex-md-row align-items-center gap-1">
                                <a href="{{ route('pegawai') }}" class="btn btn-primary mb-2 mb-md-0 me-md-2"><strong>Kembali ke Daftar</strong></a>
                                <button class="btn btn-primary" type="submit" id="submitBtn"><strong>Simpan</strong></button>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            {{-- <label for="nip" class="form-label">NIP</label> --}}
                            <select class="form-control @error('unit_id') is-invalid @enderror" id="unit_select" name="unit_id" required value="{{ old('unit_id') }}">
                              <option value="" disabled selected>Unit Kerja</option>
                              @foreach($unit as $data)
                                 <option value="{{ $data->id }}" {{ (old('unit_id') ?? '') == $data->id ? 'selected' : '' }}>
                                    {{ $data->name }}
                                 </option>
                              @endforeach
                           </select>
                            @error('unit_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
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
                        <div class="col-md-12 mb-3">
                            <input type="text" class="form-control @error('hubungan_kerja') is-invalid @enderror" id="hubungan_kerja" name="hubungan_kerja" required value="{{ old('hubungan_kerja') }}" placeholder="Hubungan Kerja">
                            @error('hubungan_kerja')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" required value="{{ old('jabatan') }}" placeholder="Jabatan">
                            @error('jabatan')
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