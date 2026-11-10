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
        Schema::create('riwayat_pemeliharaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kdo_id')->constrained('kdos')->onDelete('cascade');
            $table->date('tanggal_servis');
            $table->string('jenis_pemeliharaan');
            $table->string('bengkel_pelaksana')->nullable();
            $table->decimal('biaya', 15, 2)->default(0);
            $table->enum('kondisi_sebelum', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik');
            $table->enum('kondisi_setelah', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik');
            $table->text('deskripsi')->nullable();
            $table->string('bukti_dokumen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_pemeliharaans');
    }
};
