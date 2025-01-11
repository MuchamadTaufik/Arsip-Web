@extends('admin.layouts.main')

@section('container')
   <div class="container">
      <div class="row">
         <div class="col-md-8">
            <h4>Cetak Laporan</h4>
            <hr>
            <div class="form">
               <form action="{{ route('reports.export') }}" method="GET">
                  <div class="mb-3">
                     <label class="form-label">Unit</label>
                     <select name="unit_id" class="form-select">
                        <option value="">Semua Unit</option>
                        @foreach($units as $unit)
                           <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endforeach
                     </select>
                  </div>

                  <div class="mb-3">
                     <label class="form-label">Status</label>
                     <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                            <option value="Cuti Luar Tanggungan">Cuti Luar Tanggungan</option>
                            <option value="Kontrak Habis">Kontrak Habis</option>
                            <option value="Meninggal Dunia">Meninggal Dunia</option>
                            <option value="Mangkir 5 Kali Berturut-turut">Mangkir 5 Kali Berturut-turut</option>
                            <option value="Mengundurkan Diri">Mengundurkan Diri</option>
                            <option value="Pensiun Dini">Pensiun Dini</option>
                            <option value="PHK">PHK</option>
                            <option value="Pelanggaran">Pelanggaran</option>
                            <option value="Pensiun Normal">Pensiun Normal</option>
                            <option value="Pernikahakan Sesama Karyawan">Pernikahakan Sesama Karyawan</option>
                            <option value="Kesalahan Berat">Kesalahan Berat</option>
                            <option value="Sakit Berkepanjangan">Sakit Berkepanjangan</option>
                            <option value="Tugas Belajar">Tugas Belajar</option>
                            <option value="Ditahan Pihak Berwajib">Ditahan Pihak Berwajib</option>
                     </select>
                  </div>

                  <div class="mb-3">
                     <label class="form-label">Hubungan Kerja</label>
                     <select name="hubungan_kerja" class="form-select">
                        <option value="">Semua Hubungan Kerja</option>
                        <option value="Tetap Yayasan">Tetap Yayasan</option>
                        <option value="Partime">Partime</option>
                        <option value="PNS/DPK">PNS/DPK</option>
                        <option value="Fulltime">Fulltime</option>
                        <option value="Kontrak">Kontrak</option>
                     </select>
                  </div>

                  <div class="mb-3">
                     <label class="form-label">Format</label>
                     <select name="format" class="form-select" required>
                        <option value="pdf">PDF</option>
                        <option value="excel">Excel</option>
                     </select>
                  </div>

                  <button type="submit" class="btn btn-primary">Cetak</button>
               </form>
            </div>
         </div>
      </div>
   </div>
@endsection