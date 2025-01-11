@extends('admin.layouts.main')

@section('container')
    <div class="row">
        <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data">
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
                                    value="{{ $noDokumen ?? old('no_dokumen') }}" 
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
                                <select class="form-control @error('menu_referensi') is-invalid @enderror" id="menu_referensi" name="menu_referensi" required>
                                    <option value="" disabled {{ old('menu_referensi') == '' ? 'selected' : '' }}>Pilih Menu Referensi</option>
                                    <option value="Pembinaan Mahasiswa" {{ old('menu_referensi') == 'Pembinaan Mahasiswa' ? 'selected' : '' }}>Pembinaan Mahasiswa</option>
                                    <option value="Deta Sering" {{ old('menu_referensi') == 'Deta Sering' ? 'selected' : '' }}>Deta Sering</option>
                                    <option value="Bahan Ajar" {{ old('menu_referensi') == 'Bahan Ajar' ? 'selected' : '' }}>Bahan Ajar</option>
                                    <option value="Orasi Ilmiah" {{ old('menu_referensi') == 'Orasi Ilmiah' ? 'selected' : '' }}>Orasi Ilmiah</option>
                                    <option value="Pembimbing Dosen" {{ old('menu_referensi') == 'Pembimbing Dosen' ? 'selected' : '' }}>Pembimbing Dosen</option>
                                    <option value="Tugas Tambahan" {{ old('menu_referensi') == 'Tugas Tambahan' ? 'selected' : '' }}>Tugas Tambahan</option>
                                    <option value="Penelitian" {{ old('menu_referensi') == 'Penelitian' ? 'selected' : '' }}>Penelitian</option>
                                    <option value="Publikasi" {{ old('menu_referensi') == 'Publikasi' ? 'selected' : '' }}>Publikasi</option>
                                    <option value="Paten/HKI" {{ old('menu_referensi') == 'Paten/HKI' ? 'selected' : '' }}>Paten/HKI</option>
                                    <option value="Anggota Profesi" {{ old('menu_referensi') == 'Anggota Profesi' ? 'selected' : '' }}>Anggota Profesi</option>
                                    <option value="Penghargaan" {{ old('menu_referensi') == 'Penghargaan' ? 'selected' : '' }}>Penghargaan</option>
                                    <option value="Penunjang Lain" {{ old('menu_referensi') == 'Penunjang Lain' ? 'selected' : '' }}>Penunjang Lain</option>
                                    <option value="Pengabdian" {{ old('menu_referensi') == 'Pengabdian' ? 'selected' : '' }}>Pengabdian</option>
                                </select>
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
                                <input type="text" class="form-control @error('nama_dokumen') is-invalid @enderror" id="nama_dokumen" name="nama_dokumen" placeholder="Masukan Nama Dokumen..." value="{{ old('nama_dokumen') }}" required/>
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
                                <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" onchange="previewPDF()" required aria-describedby="pdfHelp"/>
                                <small id="pdfHelp" class="form-text text-red">Maksimal ukuran file (4MB)</small>
                                @error('file')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="mt-2">
                                    <iframe id="pdf-preview" style="display: none; width: 100%; height: 500px;" frameborder="0"></iframe>
                                </div>
                            </div>
                        </div>                         
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_dokumen">Tanggal Dokumen</label>
                                <input type="date" class="form-control @error('tanggal_dokumen') is-invalid @enderror" id="tanggal_dokumen" name="tanggal_dokumen" value="{{ old('tanggal_dokumen') }}" required/>
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
                                    <option value="" disabled {{ old('status') == '' ? 'selected' : '' }}>Status Dokumen</option>
                                    <option value="Baru" {{ old('status') == 'Baru' ? 'selected' : '' }}>Baru</option>
                                    <option value="Lama" {{ old('status') == 'Lama' ? 'selected' : '' }}>Lama</option>
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
                                <select class="form-control @error('jenis_dokumen') is-invalid @enderror" id="jenis_dokumen" name="jenis_dokumen" required>
                                    <option value="" disabled {{ old('jenis_dokumen') == '' ? 'selected' : '' }}>Pilih Jenis Dokumen</option>
                                    <option value="Surat Keputusan" {{ old('jenis_dokumen') == 'Surat Keputusan' ? 'selected' : '' }}>Surat Keputusan</option>
                                    <option value="Surat Tugas" {{ old('jenis_dokumen') == 'Surat Tugas' ? 'selected' : '' }}>Surat Tugas</option>
                                    <option value="Nota Dinas" {{ old('jenis_dokumen') == 'Nota Dinas' ? 'selected' : '' }}>Nota Dinas</option>
                                    <option value="Surat Undangan" {{ old('jenis_dokumen') == 'Surat Undangan' ? 'selected' : '' }}>Surat Undangan</option>
                                    <option value="Surat Keterangan" {{ old('jenis_dokumen') == 'Surat Keterangan' ? 'selected' : '' }}>Surat Keterangan</option>
                                </select>
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
                                    <option value="" disabled {{ old('tingkat') == '' ? 'selected' : '' }}>Tingkat</option>
                                    <option value="Universitas" {{ old('tingkat') == 'Universitas' ? 'selected' : '' }}>Universitas</option>
                                    <option value="Fakultas" {{ old('tingkat') == 'Fakultas' ? 'selected' : '' }}>Fakultas</option>
                                    <option value="Program Studi" {{ old('tingkat') == 'Program Studi' ? 'selected' : '' }}>Program Studi</option>

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
                                  <input type="hidden" class="form-control @error('uraian_singkat') is-invalid @enderror" id="uraian_singkat" name="uraian_singkat" value="{{ old('uraian_singkat') }}">
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
                                <input type="text" class="form-control @error('penerima') is-invalid @enderror" id="penerima" name="penerima" placeholder="Masukan Nama Penerima..." value="{{ old('penerima') }}" required/>
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
@endsection