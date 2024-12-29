@extends('admin.layouts.main')

@section('container')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-filter w-100 justify-content-center align-items-center">
                    <label for="foto">Foto Pegawai</label>
                    <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/*" required>
                    @error('foto')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <img id="photoPreview" src="#" alt="Photo Preview" class="img-fluid mt-3" style="height: auto; width: 100px; display: none;">
                </div>
                <div class="card card-filter w-100">
                    <div class="list-group">
                        <a href="{{ route('pegawai.create') }}" class="btn btn-primary mb-2 {{ Route::is('pegawai.create*') ? 'active' : '' }}">Biodata</a>
                        <a href="{{ route('pegawai.create.kepegawaian') }}" class="btn btn-primary mb-2">Kepegawaian</a>
                        <a href="#" class="btn btn-primary mb-2">Riwayat</a>
                    </div>
                </div>
            </div>
        
            <div class="col-md-9">
                <div class="form">
                    <form class="row" id="pegawaiForm" method="post" action="{{ route('pegawai.store') }}" enctype="multipart/form-data">
                        @csrf                   
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="search-box" style="width: 300px;">
                                <select class="form-select" id="searchPegawai" name="search_pegawai">
                                    <option value=""></option>
                                </select>
                            </div>
                            
                            <div id="actionButtons">
                                <a href="{{ route('pegawai') }}" class="btn btn-primary"><strong>Kembali ke Daftar</strong></a>
                                <button class="btn btn-primary" type="submit" id="submitBtn"><strong>Simpan</strong></button>
                            </div>
                        </div>
                        
                        <input type="file" id="hidden_foto" name="foto" style="display: none;">

                        <div class="col-md-12 mb-3">
                            {{-- <label for="nip" class="form-label">NIP</label> --}}
                            <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" required value="{{ old('nip') }}" placeholder="NIP">
                            @error('nip')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            {{-- <label for="nama_pegawai" class="form-label">Nama</label> --}}
                            <input type="text" class="form-control @error('nama_pegawai') is-invalid @enderror" id="nama_pegawai" name="nama_pegawai" required value="{{ old('nama_pegawai') }}" placeholder="Nama">
                            @error('nama_pegawai')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            {{-- <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label> --}}
                            <select class="form-control @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="" disabled {{ old('jenis_kelamin') == '' ? 'selected' : '' }}>Pilih Jenis Kelamin</option>
                                <option value="Laki-Laki" {{ old('jenis_kelamin') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>                        
                        <div class="col-md-12 mb-3">
                            {{-- <label for="agama" class="form-label">Agama</label> --}}
                            <select class="form-control @error('agama') is-invalid @enderror" id="agama" name="agama" required>
                                <option value="">Pilih Agama</option>
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
                        <div class="col-md-12 mb-3">
                            {{-- <label for="tempat_lahir" class="form-label">Tempat Lahir</label> --}}
                            <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" required value="{{ old('tempat_lahir') }}" placeholder="Tempat Lahir">
                            @error('tempat_lahir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" required value="{{ old('tanggal_lahir') }}" placeholder="Tanggal Lahir">
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div> 
                        <div class="col-md-12 mb-3">
                            {{-- <label for="alamat" class="form-label">Alamat</label> --}}
                            <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" required value="{{ old('alamat') }}" placeholder="Alamat">
                            @error('alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            {{-- <label for="email" class="form-label">Email</label> --}}
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required value="{{ old('email') }}" placeholder="Email">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="no_telp" class="form-label">No Telepon</label>
                            <input type="number" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp" name="no_telp" required value="{{ old('no_telp') }}" placeholder="6281234563899">
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
        // Handle foto preview dan transfer ke hidden input
        document.getElementById("foto").addEventListener("change", function(event) {
            // Preview foto
            const reader = new FileReader();
            reader.onload = function(e) {
                const photoPreview = document.getElementById("photoPreview");
                photoPreview.src = e.target.result;
                photoPreview.style.display = "block";
            };
            reader.readAsDataURL(event.target.files[0]);
    
            // Transfer file ke hidden input dalam form
            const hiddenFoto = document.getElementById('hidden_foto');
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(event.target.files[0]);
            hiddenFoto.files = dataTransfer.files;
        });
    
        // Optional: Handle form submit untuk validasi
        document.getElementById('pegawaiForm').addEventListener('submit', function(e) {
            const hiddenFoto = document.getElementById('hidden_foto');
            if (!hiddenFoto.files.length) {
                e.preventDefault();
                alert('Silakan pilih foto terlebih dahulu');
            }
        });
    
        // Fungsi reset jika diperlukan
        function resetForm() {
            document.getElementById('pegawaiForm').reset();
            document.getElementById('photoPreview').style.display = 'none';
            document.getElementById('foto').value = '';
            document.getElementById('hidden_foto').value = '';
        }
    </script>    
@endsection
