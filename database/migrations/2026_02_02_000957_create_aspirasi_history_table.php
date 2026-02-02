<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('aspirasi_history', function (Blueprint $table) {
            $table->id();

            $table->foreignId('aspirasi_id')
                  ->constrained('aspirasi')
                  ->cascadeOnDelete();

            $table->enum('from_status', ['pending','in_progress','done','rejected'])
                  ->nullable();

            $table->enum('to_status', ['pending','in_progress','done','rejected']);

            $table->foreignId('changed_by')
                  ->nullable()                 // HARUS DI SINI
                  ->constrained('users')
                  ->nullOnDelete();            // set null

            $table->string('note', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aspirasi_history');
    }
};
