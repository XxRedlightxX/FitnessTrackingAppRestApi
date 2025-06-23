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
        Schema::create('Set', function (Blueprint $table) {
             $table->id();
            $table->integer('set_number');
            $table->integer('reps');
            $table->float('weight')->nullable();
            $table->timestamps();
            $table->foreignId('exercice_session_id')->constrained('exercice_session')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Sets', function (Blueprint $table) {
            //
        });
    }
};
