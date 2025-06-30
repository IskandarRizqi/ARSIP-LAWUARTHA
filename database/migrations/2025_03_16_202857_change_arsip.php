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
        // Membuat tabel arsip
        Schema::create('arsip', function (Blueprint $table) {
            $table->id();
            $table->text('file')->nullable();
            $table->text('kode')->nullable();
            $table->text('nama')->nullable();
            $table->bigInteger('subkategori')->nullable();
            $table->text('deskripsi')->nullable();
            $table->bigInteger('lemari')->nullable();
            $table->text('rak')->nullable();
            $table->text('no')->nullable();
            $table->text('jenis_file')->nullable();
            $table->timestamps();
            $table->string('status')->nullable(); // Menambahkan kolom status setelah kolom nama
            $table->bigInteger('size')->nullable(); // Menambahkan kolom size
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsip');
    }
};
