<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Workout extends Model
{
    use HasFactory;

       protected $fillable = ['name', 'date', 'user_id'];

    // Each workout belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Each workout can have many exercises, via pivot table
    public function exercices()
    {
        return $this->belongsToMany(Exercice::class, 'exercise_workout') // Pivot table
                    ->withPivot('sets', 'reps', 'weight')
                    ->withTimestamps();
    }
}
