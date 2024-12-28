@extends('admin.layouts.main')

@section('container')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Daftar Pegawai</h3>
                    <a href="{{ route('pegawai.create') }}" class="btn btn-primary"><strong>Tambah</strong></a>
                </div>
                <form action="" class="card card-filter w-100">
                    <h3 class="text-center">Filter Data</h3>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label for="department">Department</label>
                        <input type="text" class="form-control" id="department" name="department" placeholder="Enter department">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Cari Pegawai</button>
                    </div>
                </form>
            </div>
        
            <div class="col-md-8">
                <div class="card flex-fill table-responsive">
                    <table class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama Pegawai</th>
                                <th>Unit Kerja</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($biodata as $data)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $data->fullname }}</td>
                                <td>{{ $data->username }}</td>
                                <td>{{ $data->email}}</td>
                                <td>{{ $data->role}}</td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-1">
                                        <a href="">
                                            <i data-feather="eye" class="text-primary"></i>
                                        </a>
                                        <form action="" method="post">
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
