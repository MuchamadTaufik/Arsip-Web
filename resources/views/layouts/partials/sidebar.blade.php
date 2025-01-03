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
            <a class="sidebar-link" href="{{ route('laporan') }}">
               <span class="align-middle">Laporan</span>
            </a>
         </li>
         <li class="sidebar-item">
            
            <form action="{{ route('logout') }}" method="POST">
               @csrf
               <button type="submit" class="sidebar-link" style="background: none; border: none;">
                   <span class="align-middle">Logout</span>
               </button>
           </form>
           
         </li>
      </ul>
   </div>
</nav>