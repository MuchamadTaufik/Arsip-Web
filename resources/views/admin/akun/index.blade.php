@extends('layouts.main')

@section('container')
   <h1 class="h3 mb-3"><strong>Kelola Akun Pengguna</strong></h1>

   <div class="row">
   <div class="col-12 d-flex">
      <div class="w-100">
         <div class="row mb-3">
            <div class="col-6">
               <a href="{{ route('kelola.akun.create') }}" type="button" class="btn btn-primary">
                  <i data-feather="plus" class="text-white align-middle" style="vertical-align: middle;width:22px;height:22px;"></i> Tambah Akun
               </a>
            </div>
         </div>
         <div class="row">
            <div class="col-12 d-flex">
               <div class="card flex-fill table-responsive">
                  <table class="table table-hover my-0">
                  <thead>
                     <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                     @if ($akun->isEmpty())
                        <tr>
                        <td colspan="7" class="text-center">Data belum tersedia</td>
                        </tr>
                     @else
                        @foreach ($akun as $data)
                        <tr>
                           <td>{{ $loop->iteration }}.</td>
                           <td>{{ $data->username }}</td>
                           <td>{{ $data->email }}</td>
                           <td>{{ $data->role }}</td>
                           <td>
                                 <div class="d-flex justify-content-center align-items-center gap-1">
                                    <a href="{{ route('kelola.akun.edit', $data->id) }}">
                                       <i data-feather="edit" class="text-success"></i>
                                    </a>
                                    <form action="{{ route('kelola.akun.delete', $data->id) }}" method="post">
                                       @csrf
                                       @method('delete')
                                       <button type="submit" class="btn btn-link p-0 m-0 align-baseline" onclick="return confirm('Apakah yakin ingin menghapus data?, ini akan menghapus seluruh data yang berkaitan dengan akun ini, seperti ebooks, biodata, dan lain-lainnya')">
                                             <i data-feather="trash-2" class="text-danger" style="width:20px;height:20px;"></i>
                                       </button>
                                    </form>
                                 </div>
                           </td>
                        </tr>
                        @endforeach
                     @endif
                  </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
   </div>
@endsection