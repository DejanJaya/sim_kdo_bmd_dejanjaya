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
        Schema::create('kdos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perangkat_daerah_id')->constrained('perangkat_daerahs')->onDelete('restrict');
            $table->foreignId('pns_id')->nullable()->constrained('pns')->onDelete('set null');
            $table->string('nomor_polisi', 20)->unique();
            $table->string('kode_barang', 50)->nullable();
            $table->string('merk', 50);
            $table->string('tipe', 100);
            $table->enum('kategori', ['Roda 4', 'Roda 2', 'Roda 6', 'Lainnya'])->default('Roda 4');
            $table->year('tahun_produksi');
            $table->string('warna', 50);
            $table->string('nomor_rangka', 100)->nullable();
            $table->string('nomor_mesin', 100)->nullable();
            $table->string('nomor_bpkb', 100)->nullable();
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik');
            $table->enum('status_penggunaan', ['Digunakan', 'Tersedia/Pool', 'Dalam Perbaikan'])->default('Digunakan');
            $table->date('tanggal_pajak')->nullable();
            $table->string('foto')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kdos');
    }
};
