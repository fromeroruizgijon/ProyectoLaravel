<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('videogames', function (Blueprint $table) {
            $table->id();
                // Relaciones (Los "dueños" del dato)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('game_id')->constrained()->onDelete('cascade'); // Conecta con la nueva tabla games
            
            // Datos personales de TU biblioteca
            $table->string('plataforma');
            $table->decimal('puntuacion_personal', 3, 1); // Cambiamos el nombre para que no se confunda con la media
            $table->enum('estado', ['Pendiente', 'Jugando', 'Completado', 'Abandonado'])->default('Pendiente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videogames_table');
    }
};
