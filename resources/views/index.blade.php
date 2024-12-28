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
                                 <h5 class="card-title">Sales</h5>
                              </div>
                              <div class="col-auto">
                                 <div class="stat text-primary">
                                    <i class="align-middle" data-feather="truck"></i>
                                 </div>
                              </div>
                           </div>
                           <h1 class="mt-1 mb-3">2.382</h1>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-4">
                     <div class="card">
                        <div class="card-body">
                           <div class="row">
                              <div class="col mt-0">
                                 <h5 class="card-title">Earnings</h5>
                              </div>

                              <div class="col-auto">
                                 <div class="stat text-primary">
                                    <i class="align-middle" data-feather="dollar-sign"></i>
                                 </div>
                              </div>
                           </div>
                           <h1 class="mt-1 mb-3">$21.300</h1>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-4">
                     <div class="card">
                        <div class="card-body">
                           <div class="row">
                              <div class="col mt-0">
                                 <h5 class="card-title">Orders</h5>
                              </div>
                              <div class="col-auto">
                                 <div class="stat text-primary">
                                    <i class="align-middle" data-feather="shopping-cart"></i>
                                 </div>
                              </div>
                           </div>
                           <h1 class="mt-1 mb-3">64</h1>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection