@extends('layouts.main')

@section('container')
   <h1 class="h3 mb-3"><strong>Tambah Akun</strong></h1>

   <div class="row">
      <div class="col-12 d-flex">
         <div class="w-100">
         <div class="card">
               <div class="card-body">
                  <form class="row g-3" method="post" action="{{ route('kelola.akun.store') }}">
                     @csrf
                     <div class="col-md-6">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Masukan Username.." required value="{{ old('username') }}">
                        @error('username')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                        @enderror
                     </div>
                     <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Masukan Alamat Email.." required value="{{ old('email') }}">
                        @error('email')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                        @enderror
                     </div>
                     <div class="col-md-6">
                           <label for="role" class="form-label">Role</label>
                           <select class="form-control @error('role') is-invalid @enderror" id="category" name="role" required autofocus value="{{ old('role') }}">
                              <option value="" disabled selected>Pilih Role</option>
                              <option value="admin">admin</option>
                              <option value="pegawai">pegawai</option>
                           </select>
                     </div>                
                     <div class="col-md-6">
                           <label for="password" class="form-label">Password</label>
                           <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukan Password.." required value="{{ old('password') }}">
                           @error('password')
                              <div class="invalid-feedback">
                                 {{ $message }}
                              </div>
                           @enderror
                     </div>            
                     <div class="col-12">
                           <button class="btn btn-primary" type="submit">Simpan</button>
                           <a href="{{ route('kelola.akun') }}" class="btn btn-light" type="submit">Kembali</a>
                     </div>
                  </form>
               </div>
         </div>
         </div>
      </div>
   </div>
@endsection