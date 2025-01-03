<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="keywords" content="">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="/img/icons/icon-48x48.png" />

	<title>Pengarsipan Universitas Pasundan</title>

	<link href="/css/app.css" rel="stylesheet">
	<link href="/css/style.css" rel="stylesheet">
   <link href="/css/pegawai.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<style>
		body, html {
			height: 100%;
			margin: 0;
			display: flex;
			justify-content: center;
			align-items: center;
		}
		.container {
			text-align: center;
		}
		.container img {
			max-width: 150px;
			margin-bottom: 20px;
		}
		.container h1 {
			font-size: 1.5rem;
			font-weight: bold;
			margin-bottom: 30px;
		}
		.buttonPegawai {
			display: flex;
			flex-direction: column;
			gap: 15px;
		}
		.buttonPegawai a,
		.buttonPegawai button {
			width: 200px;
			margin: 0 auto;
		}
	</style>
</head>

<body>
   <div class="container">
      <img src="/img/logo.png" alt="Logo">
      <h1>Selamat Datang {{ auth()->user()->username }} <br> Silahkan Pilih Menu</h1>
      <div class="buttonPegawai">
         <a href="{{ route('pegawai') }}" class="btn btn-primary">Pegawai</a>
         <a href="{{ route('dokumen') }}" class="btn btn-primary">Dokumen</a>
         <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Logout</button>
         </form>
      </div>
   </div>

	<script src="/js/app.js"></script>
</body>
</html>
