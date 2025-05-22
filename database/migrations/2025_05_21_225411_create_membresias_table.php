<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('membresias', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_usuario')->constrained('users')->onDelete('cascade');
        $table->integer('clases_adquiridas');
        $table->integer('clases_disponibles');
        $table->integer('clases_ocupadas');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membresias');
    }
};
