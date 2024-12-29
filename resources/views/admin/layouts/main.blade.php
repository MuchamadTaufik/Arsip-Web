<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="/img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>Pengarsipan Universitas</title>

	<link href="/css/app.css" rel="stylesheet">
	<link href="/css/style.css" rel="stylesheet">
	<link href="/css/pegawai.css" rel="stylesheet">	
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
         @include('layouts.partials.footer')
         {{-- footer end --}}
		</div>
	</div>

	
	<!-- Before closing body tag -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script src="/js/app.js"></script>

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
								slug: item.slug,
								data: item
							}))
						};
					},
					cache: true
				}
			});

			// Format hasil pencarian dengan foto
			function formatResult(state) {
				if (!state.id) {
					return state.text;
				}

				const foto_url = state.foto_url || '/img/logo.png'; // Ganti dengan path default foto
				
				const $result = $(
					`<div class="select2-result-pegawai d-flex align-items-center">
						<img src="${foto_url}" class="select2-result-pegawai__avatar me-2" 
							style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;"/>
						<div class="select2-result-pegawai__info">
							<div class="select2-result-pegawai__name">${state.text}</div>
						</div>
					</div>`
				);
				
				return $result;
			}

			// Format item terpilih dengan foto
			function formatSelection(state) {
				if (!state.id) {
					return state.text;
				}

				const foto_url = state.foto_url || '/img/logo.png'; // Ganti dengan path default foto
				
				return $(
					`<div class="d-flex align-items-center">
						<img src="${foto_url}" class="me-2" 
							style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;"/>
						<span>${state.text}</span>
					</div>`
				);
			}

			// Event handler untuk select
			searchSelect.on('select2:select', function(e) {
				handleSelectChange(e.params.data.data);
				
				// Update foto preview
				const photoPreview = document.getElementById("photoPreview");
				const foto_url = e.params.data.foto_url || '/img/logo.png'; // Ganti dengan path default foto
				photoPreview.src = foto_url;
				photoPreview.style.display = "block";
			});

			// Event handler untuk clear/unselect
			searchSelect.on('select2:clear', function() {
				resetForm();
				const photoPreview = document.getElementById("photoPreview");
				photoPreview.style.display = "none";
			});

			// Handler untuk perubahan select
			function handleSelectChange(data) {
				populateForm(data);
				updateButtons(data.id, data.slug);
			}

			// Fungsi untuk mengisi form
			function populateForm(data) {
				const formFields = [
					'nip', 'nama_pegawai', 'jenis_kelamin', 'agama',
					'tempat_lahir', 'tanggal_lahir', 'alamat', 'email', 'no_telp'
				];

				formFields.forEach(field => {
					if (data[field]) {
						$(`#${field}`).val(data[field]);
					}
				});
			}

			function updateButtons(id, slug) {
				const buttonContainer = document.getElementById('actionButtons');
				buttonContainer.innerHTML = `
					<div class="gap-3">
							<a href="{{ route('pegawai') }}" class="btn btn-primary"><strong>Kembali ke Daftar</strong></a>
							<a href="/pegawai/${id}/edit" class="btn btn-warning"><strong>Edit</strong></a>
					</div>
				`;
			}

			// Fungsi untuk reset form
			function resetForm() {
				// Reset form
				const form = document.getElementById('pegawaiForm');
				form.reset();
				
				// Reset action dan method
				form.setAttribute('action', '{{ route("pegawai.store") }}');
				const methodField = form.querySelector('input[name="_method"]');
				if (methodField) {
					methodField.remove();
				}

				// Reset buttons
				document.getElementById('actionButtons').innerHTML = `
					<a href="{{ route('pegawai') }}" class="btn btn-primary"><strong>Kembali ke Daftar</strong></a>
					<button class="btn btn-primary" type="submit"><strong>Simpan</strong></button>
				`;

				// Reset select2
				$('#searchPegawai').val(null).trigger('change');
			}
		});
	</script> 

</body>

</html>