<?php

namespace App\Http\Controllers\Dashboard;

use App\Charts\PegawaiChart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pegawai;

class DashboardAdminController extends Controller
{
   public function index(PegawaiChart $pegawaiChart)
   {
      $pegawaiTotal = Pegawai::count();
      $pegawaiAktif = Pegawai::where('status','Aktif')->count();
      $pegawaiNonAktif = Pegawai::where('status','Non-Aktif')->count();
      
      return view('index',[
         'pegawaiTotal' => $pegawaiTotal,
         'pegawaiAktif' => $pegawaiAktif,
         'pegawaiNonAktif' => $pegawaiNonAktif,
         'pegawaiChart' => $pegawaiChart->build()
      ]);
   }

   public function indexPegawai()
   {
      return view('pegawai.index');
   }
}
