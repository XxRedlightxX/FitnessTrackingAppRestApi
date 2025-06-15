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
        Schema::create('exercise_session', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_session_id')->constrained('WorkoutSession')->onDelete('cascade');
            $table->foreignId('exercise_id')->constrained('exercice')->onDelete('cascade');
            
            $table->integer('sets')->nullable();
            $table->integer('reps')->nullable();
            $table->decimal('weight', 5, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exercise_session', function (Blueprint $table) {
            //
        });
    }
};
