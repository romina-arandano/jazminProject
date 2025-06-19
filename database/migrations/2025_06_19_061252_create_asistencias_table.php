<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_clase')->constrained('clases')->onDelete('cascade');
            $table->foreignId('id_usuario')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_profesor')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_membresia')->nullable()->constrained('membresias')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('asistencias');
    }
};

