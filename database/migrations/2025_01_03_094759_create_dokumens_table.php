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
            $table->string('jenis_dokumen');
            $table->string('diunggah_oleh');
            $table->string('penerima');
            $table->string('menu_referensi');
            $table->string('file');
            $table->enum('status', ['Status_1','Status_2','Status_3']);
            $table->enum('tingkat', ['Penting','Tidak Penting']);
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
