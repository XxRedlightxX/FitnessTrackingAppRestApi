<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ExerciceSession extends Pivot
{
    use HasFactory;

    protected $table = 'exercice_session';

    public function workoutSession()
    {
        return $this->belongsTo(Workout::class, 'workout_session_id');
    }

    public function exercice()
    {
        return $this->belongsTo(Exercice::class, 'exercice_id');
    }



    public function sets()
    {
        return $this->hasMany(Set::class, 'exercice_session_id');
    }
}
