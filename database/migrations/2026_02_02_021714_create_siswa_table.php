<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
        
            $table->string('nis', 30)->unique();
            $table->string('nama_lengkap', 150);
        
            $table->foreignId('kelas_id')
                  ->constrained('kelas')
                  ->cascadeOnDelete();
        
            $table->string('no_hp', 20)->nullable();
            $table->text('alamat')->nullable();
        
            $table->timestamps();
        });
    }        

    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
