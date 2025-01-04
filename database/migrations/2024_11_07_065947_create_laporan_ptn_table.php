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
        Schema::create('laporan_ptn', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('ptn_id')->constrained('ptn')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('jenis_kegiatan', ['Rapat/Audiensi', 'Visitasi', 'Monitoring & Evaluasi', 'Aduan/Laporan', 'Teguran/Sanksi']);
            $table->date('tanggal_kegiatan');
            $table->string('tempat_kegiatan');
            $table->string('dokumen_notula')->nullable();
            $table->string('dokumen_undangan');
            $table->longText('resume');
            $table->string('status');
            $table->json('pokja')->nullable();
            $table->string('createdbyuser');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_ptn');
    }
};
