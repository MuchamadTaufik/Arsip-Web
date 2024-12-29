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
		document.addEventListener("DOMContentLoaded", function() {
			var ctx = document.getElementById("chartjs-dashboard-line").getContext("2d");
			var gradient = ctx.createLinearGradient(0, 0, 0, 225);
			gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
			gradient.addColorStop(1, "rgba(215, 227, 244, 0)");
			// Line chart
			new Chart(document.getElementById("chartjs-dashboard-line"), {
				type: "line",
				data: {
					labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
					datasets: [{
						label: "Sales ($)",
						fill: true,
						backgroundColor: gradient,
						borderColor: window.theme.primary,
						data: [
							2115,
							1562,
							1584,
							1892,
							1587,
							1923,
							2566,
							2448,
							2805,
							3438,
							2917,
							3327
						]
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false
					},
					tooltips: {
						intersect: false
					},
					hover: {
						intersect: true
					},
					plugins: {
						filler: {
							propagate: false
						}
					},
					scales: {
						xAxes: [{
							reverse: true,
							gridLines: {
								color: "rgba(0,0,0,0.0)"
							}
						}],
						yAxes: [{
							ticks: {
								stepSize: 1000
							},
							display: true,
							borderDash: [3, 3],
							gridLines: {
								color: "rgba(0,0,0,0.0)"
							}
						}]
					}
				}
			});
		});
	</script>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Pie chart
			new Chart(document.getElementById("chartjs-dashboard-pie"), {
				type: "pie",
				data: {
					labels: ["Chrome", "Firefox", "IE"],
					datasets: [{
						data: [4306, 3801, 1689],
						backgroundColor: [
							window.theme.primary,
							window.theme.warning,
							window.theme.danger
						],
						borderWidth: 5
					}]
				},
				options: {
					responsive: !window.MSInputMethodContext,
					maintainAspectRatio: false,
					legend: {
						display: false
					},
					cutoutPercentage: 75
				}
			});
		});
	</script>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Bar chart
			new Chart(document.getElementById("chartjs-dashboard-bar"), {
				type: "bar",
				data: {
					labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
					datasets: [{
						label: "This year",
						backgroundColor: window.theme.primary,
						borderColor: window.theme.primary,
						hoverBackgroundColor: window.theme.primary,
						hoverBorderColor: window.theme.primary,
						data: [54, 67, 41, 55, 62, 45, 55, 73, 60, 76, 48, 79],
						barPercentage: .75,
						categoryPercentage: .5
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false
					},
					scales: {
						yAxes: [{
							gridLines: {
								display: false
							},
							stacked: false,
							ticks: {
								stepSize: 20
							}
						}],
						xAxes: [{
							stacked: false,
							gridLines: {
								color: "transparent"
							}
						}]
					}
				}
			});
		});
	</script>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			var markers = [{
					coords: [31.230391, 121.473701],
					name: "Shanghai"
				},
				{
					coords: [28.704060, 77.102493],
					name: "Delhi"
				},
				{
					coords: [6.524379, 3.379206],
					name: "Lagos"
				},
				{
					coords: [35.689487, 139.691711],
					name: "Tokyo"
				},
				{
					coords: [23.129110, 113.264381],
					name: "Guangzhou"
				},
				{
					coords: [40.7127837, -74.0059413],
					name: "New York"
				},
				{
					coords: [34.052235, -118.243683],
					name: "Los Angeles"
				},
				{
					coords: [41.878113, -87.629799],
					name: "Chicago"
				},
				{
					coords: [51.507351, -0.127758],
					name: "London"
				},
				{
					coords: [40.416775, -3.703790],
					name: "Madrid "
				}
			];
			var map = new jsVectorMap({
				map: "world",
				selector: "#world_map",
				zoomButtons: true,
				markers: markers,
				markerStyle: {
					initial: {
						r: 9,
						strokeWidth: 7,
						stokeOpacity: .4,
						fill: window.theme.primary
					},
					hover: {
						fill: window.theme.primary,
						stroke: window.theme.primary
					}
				},
				zoomOnScroll: false
			});
			window.addEventListener("resize", () => {
				map.updateSize();
			});
		});
	</script>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			var date = new Date(Date.now() - 5 * 24 * 60 * 60 * 1000);
			var defaultDate = date.getUTCFullYear() + "-" + (date.getUTCMonth() + 1) + "-" + date.getUTCDate();
			document.getElementById("datetimepicker-dashboard").flatpickr({
				inline: true,
				prevArrow: "<span title=\"Previous month\">&laquo;</span>",
				nextArrow: "<span title=\"Next month\">&raquo;</span>",
				defaultDate: defaultDate
			});
		});
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
				updateButtons(data.id);
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

			// Fungsi untuk update tombol
			function updateButtons(id) {
				const buttonContainer = document.getElementById('actionButtons');
				buttonContainer.innerHTML = `
					<a href="{{ route('pegawai') }}" class="btn btn-primary"><strong>Kembali ke Daftar</strong></a>
					<button type="button" class="btn btn-warning" onclick="handleEdit(${id})"><strong>Edit</strong></button>
					<button type="button" class="btn btn-danger" onclick="handleDelete(${id})"><strong>Hapus</strong></button>
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

			// Attach to window for global access
			window.handleEdit = function(id) {
				if (!confirm('Apakah Anda yakin ingin mengubah data ini?')) return;
				
				const form = document.getElementById('pegawaiForm');
				form.setAttribute('action', `/pegawai/${id}`);
				
				if (!form.querySelector('input[name="_method"]')) {
					const methodInput = document.createElement('input');
					methodInput.setAttribute('type', 'hidden');
					methodInput.setAttribute('name', '_method');
					methodInput.setAttribute('value', 'PUT');
					form.appendChild(methodInput);
				}
				
				form.submit();
			};

			window.handleDelete = function(id) {
				if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) return;
				
				const form = document.getElementById('pegawaiForm');
				form.setAttribute('action', `/pegawai/${id}`);
				
				if (!form.querySelector('input[name="_method"]')) {
					const methodInput = document.createElement('input');
					methodInput.setAttribute('type', 'hidden');
					methodInput.setAttribute('name', '_method');
					methodInput.setAttribute('value', 'DELETE');
					form.appendChild(methodInput);
				}
				
				form.submit();
			};
		});
	</script>


</body>

</html>