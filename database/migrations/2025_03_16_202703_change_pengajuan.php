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
        // Membuat tabel pengajuan
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Relasi ke tabel users
            $table->text('nama'); // Nama arsip
            $table->text('type'); // Jenis arsip
            $table->unsignedBigInteger('subkategori_id')->nullable(); // Kategori arsip
            $table->text('tujuan'); // Tujuan peminjaman
            $table->text('lemari')->nullable();
            $table->text('rak')->nullable();
            $table->text('no')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'returned'])->default('pending'); // Status pengajuan
            $table->timestamp('approved_at')->nullable(); // Waktu persetujuan
            $table->unsignedBigInteger('approved_by')->nullable(); // User yang menyetujui
            $table->timestamp('rejected_at')->nullable(); // Waktu penolakan
            $table->unsignedBigInteger('rejected_by')->nullable(); // User yang menolak
            $table->timestamp('returned_at')->nullable(); // Waktu pengembalian
            $table->timestamp('due_date')->nullable(); // Batas pengembalian
            $table->string('jenis_arsip')->nullable(); // Jenis arsip tambahan
            $table->unsignedBigInteger('downloaded_by')->nullable();
            $table->timestamp('downloaded_at')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('subkategori_id')->references('id')->on('subkategori')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('rejected_by')->references('id')->on('users')->onDelete('set null');
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
};
