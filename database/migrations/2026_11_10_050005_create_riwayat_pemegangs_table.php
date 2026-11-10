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
        Schema::create('riwayat_pemegangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kdo_id')->constrained('kdos')->onDelete('cascade');
            $table->foreignId('pns_id')->constrained('pns')->onDelete('restrict');
            $table->string('nomor_bast', 100)->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->enum('status_bast', ['Aktif', 'Selesai'])->default('Aktif');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_pemegangs');
    }
};
