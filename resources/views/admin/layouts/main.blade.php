<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="Adinata">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="keywords" content="">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="/img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>Pengarsipan Universitas</title>

	<link href="/css/app.css" rel="stylesheet">
	<link href="/css/style.css" rel="stylesheet">
	<link href="/css/pegawai.css" rel="stylesheet">	
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

	{{-- css trix --}}
    <link rel="stylesheet" href="/css/trix.css" />

    <style>
      trix-toolbar [data-trix-button-group="file-tools"]{
          display: none;
        }
      trix-editor[readonly] {
            pointer-events: none;
            background-color: #f7f7f7;
        }

		  html, body {
				height: 100%;
				margin: 0;
				display: flex;
				flex-direction: column;
			}
			.footer {
				margin-top: auto;
				background-color: #f8f9fa;
				padding: 10px 0;
				box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
				text-align: center;
				width: 100%;
			}
    </style>
</head>

<body>
   @include('sweetalert::alert')
	<div class="wrapper">
      {{-- sidebar end --}}

		<div class="main">
			{{-- navbar start --}}
         @include('admin.layouts.partials.navbar')
         {{-- navbar end --}}
			<main class="content">
				@yield('container')
			</main>

			{{-- footer start --}}
         @include('admin.layouts.partials.footer')
         {{-- footer end --}}
		</div>
	</div>

	
	<!-- Before closing body tag -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script src="/js/app.js"></script>
	<script src="/js/trix.js"></script>
	<script>
		document.addEventListener('trix-file-accept', function(e){
			e.preventDefault();
		  })
	</script>
  

	<script>
			document.addEventListener('DOMContentLoaded', function() {
				// Inisialisasi Select2
				const searchSelect = $('#searchPegawai').select2({
					placeholder: 'Cari Pegawai...',
					allowClear: true,
					minimumInputLength: 2,
					width: '100%',
					templateResult: formatResult,
					templateSelection: formatSelection,
					ajax: {
							url: '{{ route("pegawai.search") }}',
							dataType: 'json',
							delay: 250,
							data: function(params) {
								return {
									q: params.term,
									_token: '{{ csrf_token() }}'
								};
							},
							processResults: function(data) {
								return {
									results: data.map(item => ({
											id: item.id,
											text: `${item.nama_pegawai} (${item.nip})`,
											foto_url: item.foto_url,
											data: item // Simpan semua data untuk digunakan nanti
									}))
								};
							},
							cache: true
					}
				});
			
				// Format tampilan hasil pencarian
				function formatResult(state) {
					if (!state.id) return state.text;
					
					const foto_url = state.foto_url || '/img/logo.png';
					return $(
							`<div class="select2-result-pegawai d-flex align-items-center">
								<img src="${foto_url}" class="select2-result-pegawai__avatar me-2" 
									style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;"/>
								<div class="select2-result-pegawai__info">
									<div class="select2-result-pegawai__name">${state.text}</div>
								</div>
							</div>`
					);
				}
			
				// Format tampilan item terpilih
				function formatSelection(state) {
					if (!state.id) return state.text;
					return state.text;
				}
			
				// Event handler saat item dipilih
				searchSelect.on('select2:select', function(e) {
					const selectedData = e.params.data.data;
					console.log('Selected Data:', selectedData); // Debug
			
					// Isi form biodata
					fillBiodataForm(selectedData);
					
					// Isi form kepegawaian
					if (selectedData.pegawai) {
							fillKepegawaianForm(selectedData.pegawai);
					}
			
					// Tampilkan riwayat
					if (selectedData.riwayat && selectedData.riwayat.length > 0) {
							displayRiwayat(selectedData.riwayat);
					}
			
					// Update foto
					if (selectedData.foto_url) {
							$('#photoPreview').attr('src', selectedData.foto_url).show();
					}
			
					// Update tombol
					updateButtons(selectedData.id);
			
					// Set form to read-only
					setFormReadonly(true);
				});
			
				// Handler untuk mengisi form biodata
				function fillBiodataForm(data) {
					$('#nip').val(data.nip);
					$('#nama_pegawai').val(data.nama_pegawai);
					$('#jenis_kelamin').val(data.jenis_kelamin);
					$('#agama').val(data.agama);
					$('#tempat_lahir').val(data.tempat_lahir);
					$('#tanggal_lahir').val(data.tanggal_lahir);
					$('#alamat').val(data.alamat);
					$('#email').val(data.email);
					$('#no_telp').val(data.no_telp);
				}
			
				// Handler untuk mengisi form kepegawaian
				function fillKepegawaianForm(pegawaiData) {
					$('select[name="unit_id"]').val(pegawaiData.unit_id);
					$('#status').val(pegawaiData.status);
					$('#hubungan_kerja').val(pegawaiData.hubungan_kerja);
					$('#jabatan').val(pegawaiData.jabatan);
				}
			
				// Handler untuk menampilkan riwayat
				function displayRiwayat(riwayatData) {
					const tbody = $('#riwayatTable tbody');
					tbody.empty(); // Clear the table body first

					riwayatData.forEach((item, index) => {
						const filePendukungHtml = item.file_pendukung ? 
								`<a href="${item.file_pendukung}" target="_blank" class="btn btn-sm btn-info">
									<i data-feather="file"></i> Lihat File
								</a>` 
								: 'N/A';
						
						const riwayatHtml = `
								<tr class="riwayat-item">
									<td>${index + 1}</td>
									<td>${item.nama_instansi}</td>
									<td>${item.jabatan}</td>
									<td>${item.tahun}</td>
									<td>${filePendukungHtml}</td>
									<td>
										<div class="justify-content-center align-items-center gap-3">
											<form action="/pegawai/riwayat/delete/${item.id}" method="POST" style="display:inline;">
												@csrf
												@method('DELETE')
												<button type="submit" class="btn btn-danger remove-riwayat" onclick="return confirm('Apakah yakin ingin menghapus data?')">
													<i data-feather="trash-2" style="width:20px;height:20px;"></i>
												</button>
											</form>
										</div>
									</td>
								</tr>
						`;
						tbody.append(riwayatHtml);
					});

					// Re-initialize Feather icons
					feather.replace();
				}
			
				// Update tombol setelah pencarian
				function updateButtons(id) {
					const buttonContainer = $('#actionButtons');
					buttonContainer.empty();
			
					const buttons = `
							<a href="{{ route('pegawai') }}" class="btn btn-secondary" id="kembaliDaftarBtn">
								<i data-feather="arrow-left"></i> Kembali ke Daftar
							</a>
							<a href="/pegawai/${id}/edit" class="btn btn-warning" id="editBtn">
								<i data-feather="edit"></i> Edit
							</a>
							<form action="/pegawai/delete/${id}" method="POST" id="hapusForm" style="display:inline;">
									@csrf
									@method('DELETE')
									<button type="submit" class="btn btn-danger" id="hapusBtn" onclick="return confirm('Apakah yakin ingin menghapus data?')">
										<i data-feather="trash-2"></i> Hapus
									</button>
							</form>
					`;
					buttonContainer.append(buttons);
					feather.replace();
				}
			
				// Set form fields to readonly
				function setFormReadonly(isReadonly) {
					// Atur semua elemen input dan select di dalam #pegawaiForm menjadi readonly atau disabled
					$('#pegawaiForm input').prop('readonly', isReadonly);
					$('#pegawaiForm select').not('#searchPegawai').prop('readonly', isReadonly); // Mengatur select kecuali #searchPegawai
					$('#pegawaiForm select').not('#searchPegawai').prop('disabled', isReadonly); // Menonaktifkan select kecuali #searchPegawai
					
					// Nonaktifkan input file jika isReadonly true
					$('#pegawaiForm input[type="file"]').prop('disabled', isReadonly); // Menonaktifkan input file

					// Sembunyikan tombol "Tambah Riwayat" jika isReadonly true
					$('#addRiwayat').toggle(!isReadonly); // Menyembunyikan tombol saat readonly aktif
				}


			
				// Event handler untuk clear/reset
				searchSelect.on('select2:clear', function() {
					$('#pegawaiForm')[0].reset();
					$('#photoPreview').hide();
					$('#riwayatContainer').empty();

					const tbody = $('#riwayatTable tbody');
					tbody.empty(); // Clear any previous rows in the table
					resetButtons(); // Reset buttons to initial state
				});
			
				// Reset tombol ke state awal
				function resetButtons() {
					const buttonContainer = $('#actionButtons');
					buttonContainer.empty();
			
					const button = `
							<a href="{{ route('pegawai') }}" class="btn btn-secondary">
                        <i data-feather="arrow-left"></i> Kembali ke Daftar
                     </a>
							<button type="submit" class="btn btn-primary">
                        <i data-feather="save"></i> Simpan
                     </button>
					`;

					buttonContainer.append(button);

					feather.replace();
			
					// Tambahkan event listener untuk tombol search
					$('#searchBtn').on('click', function() {
							// Logic for Search button
					});
				}
			});
	</script>
		

</body>

</html>