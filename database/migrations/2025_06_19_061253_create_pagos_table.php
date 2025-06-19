<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_membresia')->nullable()->constrained('membresias')->onDelete('set null');
            $table->foreignId('id_clase')->nullable()->constrained('clases')->onDelete('set null');
            $table->decimal('monto', 8, 2);
            $table->date('fecha');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pagos');
    }
};
