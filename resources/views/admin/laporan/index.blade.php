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
                        <option value="Non-Aktif">Non-Aktif</option>
                     </select>
                  </div>

                  <div class="mb-3">
                     <label class="form-label">Hubungan Kerja</label>
                     <select name="hubungan_kerja" class="form-select">
                        <option value="">Semua Hubungan Kerja</option>
                        @foreach($hubunganKerjas as $hk)
                           <option value="{{ $hk }}">{{ $hk }}</option>
                        @endforeach
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