<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class set extends Model
{
     protected $table = 'set';

     protected $fillable = ['set_number','reps', 'weight'];


     /*public function Excercice_Sessions() {
        return $this->belongsTo(Exercice::class, 'exercice_session');
     }*/

     public function workoutExercice()
    {
        return $this->belongsTo(ExerciceSession::class);
    }
}
