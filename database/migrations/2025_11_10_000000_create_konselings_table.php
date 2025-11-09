<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('konselings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('guru_bk_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('jenis_konseling', ['akademik', 'karir', 'pribadi', 'sosial']);
            $table->string('topik');
            $table->text('deskripsi');
            $table->date('tanggal');
            $table->time('waktu');
            $table->enum('status', ['pending', 'approved', 'completed', 'cancelled'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('konselings');
    }
};