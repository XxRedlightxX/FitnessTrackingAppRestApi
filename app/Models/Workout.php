<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Workout extends Model
{
    use HasFactory;


    protected $table = 'workoutsession';
    protected $fillable = ['notes', 'date', 'user_id'];

    // Each workout belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Each workout can have many exercises, via pivot table
    /*public function exercices()
    {
        return $this->belongsToMany(Exercice::class, 'exercice_session', 'workout_session_id', 'exercice_id') // Pivot table
                  
                    ->withTimestamps();
    }*/

     /*public function exerciceSessionse()
    {
        //return $this->hasMany(ExerciceSession::class);
          return $this->belongsToMany(Exercice::class, 'exercice_session'
    ,'workout_session_id', 'exercice_id');
    }*/

    public function exerciceSessions()
{
   return $this->belongsToMany(Exercice::class, 'exercice_session', 'workout_session_id', 'exercice_id')
            ->using(ExerciceSession::class)
            ->withPivot(['id']) // Add any additional pivot columns
            ->withTimestamps();
}

public function exerciceSessionPivots()
{
    return $this->hasMany(ExerciceSession::class, 'workout_session_id');
}

    /*public function exercices()
        {
            return $this->belongsToMany(Exercice::class, 'exercice_session', 'workout_session_id', 'exercice_id');
        }*/

     /*public function exercices()
    {
        return $this->belongsToMany(Exercice::class, 'exercice_session'
    ,'workout_session_id', 'exercice_id');
    }*/

    


}
