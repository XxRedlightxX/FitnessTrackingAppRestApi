<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Workout extends Model
{
    use HasFactory;


    protected $table = 'workoutsession';
    protected $fillable = ['name', 'date'];

    // Each workout belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Each workout can have many exercises, via pivot table
    public function exercices()
    {
        return $this->belongsToMany(Exercice::class, 'exercice_session', 'workout_session_id', 'exercice_id') // Pivot table
                    ->withPivot('sets', 'reps', 'weight')
                    ->withTimestamps();
    }
}
