<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('aspirasi_feedback', function (Blueprint $table) {
            $table->id();

            $table->foreignId('aspirasi_id')
                  ->constrained('aspirasi')
                  ->cascadeOnDelete();

            $table->foreignId('admin_id')
                  ->nullable()              // HARUS DI SINI
                  ->constrained('users')
                  ->nullOnDelete();         // alias set null

            $table->text('feedback_text');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aspirasi_feedback');
    }
};
