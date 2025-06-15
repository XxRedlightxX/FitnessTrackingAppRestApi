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
        Schema::create('Exercice_MuscleGroup', function (Blueprint $table) {
           $table->foreignId('exercice_id')->constrained('exercice')->onDelete('cascade');

            // Clé étrangère vers muscle_groups id Many to Many
            $table->foreignId('muscle_group_id')->constrained('musclegroup')->onDelete('cascade');

            // Clé primaire composite
            $table->primary(['exercice_id', 'muscle_group_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Exercice_MuscleGroup', function (Blueprint $table) {
            //
        });
    }
};
