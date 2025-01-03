@extends('layouts.main')

@section('container')
   <div class="container-fluid p-0">
      <div class="title-dashboard">
         <h1 class="h3 mb-3 fw-bold">Pengarsipan Digital Universitas Pasundan</h1>
      </div>

      <div class="row">
         <div class="col-xl-12 col-xxl-5 d-flex">
            <div class="w-100">
               <div class="row">
                  <div class="col-sm-4">
                     <div class="card">
                        <div class="card-body">
                           <div class="row">
                              <div class="col mt-0">
                                 <h5 class="card-title">Total Pegawai</h5>
                              </div>
                              <div class="col-auto">
                                 <div class="stat text-primary">
                                    <i class="align-middle" data-feather="user"></i>
                                 </div>
                              </div>
                           </div>
                           <h1 class="mt-1 mb-3">{{ $pegawaiTotal }}</h1>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-4">
                     <div class="card">
                        <div class="card-body">
                           <div class="row">
                              <div class="col mt-0">
                                 <h5 class="card-title">Pegawai Aktif</h5>
                              </div>

                              <div class="col-auto">
                                 <div class="stat text-primary">
                                    <i class="align-middle" data-feather="user"></i>
                                 </div>
                              </div>
                           </div>
                           <h1 class="mt-1 mb-3">{{ $pegawaiAktif }}</h1>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-4">
                     <div class="card">
                        <div class="card-body">
                           <div class="row">
                              <div class="col mt-0">
                                 <h5 class="card-title">Pegawai Non Aktif</h5>
                              </div>
                              <div class="col-auto">
                                 <div class="stat text-primary">
                                    <i class="align-middle" data-feather="user"></i>
                                 </div>
                              </div>
                           </div>
                           <h1 class="mt-1 mb-3">{{ $pegawaiNonAktif }}</h1>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-12">
                     <h1 class="h3 mb-3 fw-bold">Statistik Kepegawaian</h1>
                     <div class="p-6 m-20 bg-white rounded shadow">
                        {!! $pegawaiChart->container() !!}
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <script src="{{ $pegawaiChart->cdn() }}"></script>

   {{ $pegawaiChart->script() }}
@endsection