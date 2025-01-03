<nav class="navbar navbar-expand navbar-light navbar-bg">
    <div class="container-fluid">
        <!-- Logo di kiri -->
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="/img/logo.png" alt="Logo" style="height: 40px; width: auto;"> <!-- Ganti logo.png dengan path logo Anda -->
        </a>

        <!-- Teks di sebelah logo -->
        <h1 class="navbar-text ms-3 mb-0">Arsip Digital Universitas Pasundan</h1>

        <!-- Tombol Kembali di kanan -->
        @can('isAdmin')
            <a class="btn btn-outline-primary ms-auto" href="{{ route('home') }}" >Kembali<a>
        @endcan

        @can('isPegawai')
            <a class="btn btn-outline-primary ms-auto" href="{{ route('arsip') }}" >Kembali<a>

        @endcan
    </div>
</nav>