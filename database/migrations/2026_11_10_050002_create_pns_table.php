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
        Schema::create('pns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perangkat_daerah_id')->constrained('perangkat_daerahs')->onDelete('restrict');
            $table->string('nip', 30)->unique();
            $table->string('nama');
            $table->string('jabatan');
            $table->string('golongan', 50);
            $table->string('no_telepon', 30)->nullable();
            $table->string('email')->nullable();
            $table->enum('status_pegawai', ['Aktif', 'Pensiun', 'Mutasi'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pns');
    }
};
