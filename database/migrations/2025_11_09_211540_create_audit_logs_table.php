<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('action'); // e.g. 'decrypt_journal'
            $table->string('target_type')->nullable(); // 'journal'
            $table->string('target_id')->nullable();
            $table->text('meta')->nullable(); // JSON string if needed
            $table->ipAddress('ip')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('audit_logs');
    }
};
