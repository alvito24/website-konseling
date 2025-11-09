<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('students_ref', function (Blueprint $table) {
            $table->id();
            $table->string('nis')->unique();
            $table->string('name');
            $table->string('class');
            $table->foreignId('wali_kelas_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('orangtua_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('staff_ref', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->unique();
            $table->string('name');
            $table->enum('position', ['guru_bk', 'wali_kelas', 'admin']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students_ref');
        Schema::dropIfExists('staff_ref');
    }
};