<nav id="sidebar" class="sidebar js-sidebar">
   <div class="sidebar-content js-simplebar">
      <a class="sidebar-brand" href="{{ route('home') }}">
         <img src="img/logo.png" alt="">
      </a>

      <ul class="sidebar-nav">

         <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('pegawai') }}">
               <span class="align-middle">Pegawai</span>
            </a>
         </li>
         <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('dokumen') }}">
               <span class="align-middle">Dokumen</span>
            </a>
         </li>
         <li class="sidebar-item">
            <a class="sidebar-link" href="index.html">
               <span class="align-middle">Laporan</span>
            </a>
         </li>
         <li class="sidebar-item">
            <a class="sidebar-link" href="index.html">
               <span class="align-middle">Logout</span>
            </a>
         </li>
      </ul>
   </div>
</nav>