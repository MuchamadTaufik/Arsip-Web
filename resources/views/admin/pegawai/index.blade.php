@extends('admin.layouts.main')

@section('container')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-filter w-100 p-3">
                    <h4 class="text-center">Filter Data</h4>
                    <div class="form-group mb-3">
                        <label for="unit_kerja">Unit Kerja</label>
                        <select class="form-control" id="unit_kerja">
                            <option value="">Semua Unit Kerja</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->name }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="status">Status</label>
                        <select class="form-control" id="status">
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
                </div>
            </div>
        
            <div class="col-md-9">
                <div class="card flex-fill table-responsive">
                    <table class="table table-hover my-0">
                        <div class="mb-3 d-flex justify-content-between align-items-center" style="padding: 10px">
                            <div class="search-box">
                                <input type="text" id="searchInput" class="form-control" placeholder="Cari Pegawai...">
                            </div>
                            @can('isAdmin')
                                <a href="{{ route('pegawai.create') }}" class="btn btn-primary"><strong>Tambah</strong></a>

                            @endcan
                        </div>
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
                                <td>{{ $data->nip }}</td>
                                <td>{{ $data->nama_pegawai }}</td>
                                
                                <td>{{ $data->pegawai->unit->name ?? 'Belum diisi'}}</td>
                                <td>{{ $data->pegawai->status ?? 'Belum diisi'}}</td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center gap-3">
                                        <a href="{{ route('pegawai.show', $data->slug) }}">
                                            <i data-feather="eye" class="text-primary"></i>
                                        </a>
                                        @can('isAdmin')
                                            <form action="{{ route('pegawai.destroy', $data->id) }}" method="post" class="m-0 p-0">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" onclick="return confirm('Apakah yakin ingin menghapus data?')" style="all: unset; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                                                    <i data-feather="trash-2" class="text-danger" style="width:20px;height:20px;"></i>
                                                </button>
                                        </form>
                                        @endcan
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const unitSelect = document.getElementById('unit_kerja');
            const statusSelect = document.getElementById('status');
            const searchInput = document.getElementById('searchInput');

            function filterTable() {
                const unitValue = unitSelect.value.toLowerCase();
                const statusValue = statusSelect.value.toLowerCase();
                const searchValue = searchInput.value.toLowerCase();

                const table = document.querySelector('.table');
                const rows = table.getElementsByTagName('tr');

                for (let i = 1; i < rows.length; i++) {
                    const row = rows[i];
                    const cells = row.getElementsByTagName('td');

                    if (cells.length) {
                        const unitText = cells[3]?.textContent.toLowerCase() || ''; // Unit Kerja di kolom ke-4
                        const statusText = cells[4]?.textContent.toLowerCase() || ''; // Status di kolom ke-5
                        const searchableText = Array.from(cells).map(cell => cell.textContent.toLowerCase()).join(' ');

                        const matchesUnit = unitValue === '' || unitText.includes(unitValue);
                        const matchesStatus = statusValue === '' || statusText.includes(statusValue);
                        const matchesSearch = searchValue === '' || searchableText.includes(searchValue);

                        row.style.display = matchesUnit && matchesStatus && matchesSearch ? '' : 'none';
                    }
                }
            }

            unitSelect.addEventListener('change', filterTable);
            statusSelect.addEventListener('change', filterTable);
            searchInput.addEventListener('keyup', filterTable);
        });

    </script>
@endsection
