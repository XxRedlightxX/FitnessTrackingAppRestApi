<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class exercice extends Model
{
    use HasFactory;

        protected $table = 'exercice';
       protected $fillable = ['name' , 'category' , 'description'];

       public $timestamps = false;

        // Many-to-many with muscle groups
        public function muscleGroups()
        {
            return $this->belongsToMany(MuscleGroup::class, 'exercice_musclegroup', 'exercice_id', 'muscle_group_id');
        }

        // Many-to-many with workout sessions via pivot table (exercise_session)
        public function workoutSessions()
        {
            return $this->belongsToMany(Workout::class, 'exercice_session', 'exercice_id', 'workout_session_id')
                        ->withPivot('sets', 'reps', 'weight')
                        ->withTimestamps();
        }
}
