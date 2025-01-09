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
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            $table->string('no_dokumen')->unique();
            $table->string('nama_dokumen');
            $table->text('uraian_singkat');
            $table->date('tanggal_dokumen');
            $table->enum('jenis_dokumen', ['Surat Keputusan','Surat Tugas','Nota Dinas','Surat Undangan','Surat Keterangan']);
            $table->string('diunggah_oleh');
            $table->string('penerima');
            $table->enum('menu_referensi', ['Pembinaan Mahasiswa','Detasering', 'Bahan Ajar', 'Orasi Ilmiah', 'Pembimbing Dosen', 'Tugas Tambahan', 'Penelitian', 'Publikasi', 'Paten/HKI', 'Anggota Profesi', 'Penghargaan', 'Penunjang Lain', 'Pengabdian']);
            $table->string('file');
            $table->enum('status', ['Baru','Lama']);
            $table->enum('tingkat', ['Universitas','Fakultas','Program Studi']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumens');
    }
};
