<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('clases', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->foreignId('id_profesor')->constrained('users')->onDelete('cascade');
            $table->string('tipo');
            $table->integer('lugares');
            $table->integer('lugares_ocupados')->default(0);
            $table->integer('lugares_disponibles')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('clases');
    }
};
