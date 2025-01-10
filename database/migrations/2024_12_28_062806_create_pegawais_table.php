<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->enum('status', ['Aktif','Tidak Aktif','Cuti Luar Tanggungan','Kontrak Habis', 'Meninggal Dunia','Mangkir 5 Kali Berturut-turut','Mengundurkan Diri','Pensiun Dini','PHK','Pelanggaran','Pensiun Normal','Pernikahakan Sesama Karyawan','Kesalahan Berat','Sakit Berkepanjangan','Tugas Belajar','Ditahan Pihak Berwajib']);
            $table->enum('hubungan_kerja',['Tetap Yayasan','Partime','PNS/DPK','Fulltime', 'Kontrak']);
            $table->string('jabatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
