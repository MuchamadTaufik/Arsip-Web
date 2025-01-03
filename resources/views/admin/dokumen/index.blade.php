@extends('admin.layouts.main')

@section('container')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card flex-fill table-responsive">
                    <table class="table table-hover my-0">
                        <div class="mb-3 d-flex justify-content-between align-items-center" style="padding: 10px">
                            <div class="search-box">
                                <input type="text" id="searchInput" class="form-control" placeholder="Cari Dokumen...">
                            </div>
                            <a href="{{ route('dokumen.create') }}" class="btn btn-primary"><strong>Tambah</strong></a>
                        </div>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Diunggah Oleh</th>
                                <th>No Dokumen</th>
                                <th>Nama Dokumen</th>
                                <th>Status</th>
                                <th>FIle</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dokumen as $data)
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $data->diunggah_oleh }}</td>
                                <td>{{ $data->no_dokumen }}</td>
                                <td>{{ $data->nama_dokumen}}</td>
                                <td>{{ $data->status }} </td>
                                <td>
                                    @if($data->file)
                                        <a href="{{ asset('storage/' . $data->file) }}" 
                                        class="btn btn-sm btn-info" target="_blank">
                                        <i data-feather="file"></i> Lihat
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <a href="{{ route('dokumen.show', $data->id) }}">
                                            <i data-feather="eye" class="text-primary"></i>
                                        </a>
                                        <form action="{{ route('dokumen.delete', $data->id) }}" method="post" class="m-0 p-0">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" onclick="return confirm('Apakah yakin ingin menghapus data?')" style="all: unset; display: flex; align-items: center; justify-content: center; cursor: pointer;">
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