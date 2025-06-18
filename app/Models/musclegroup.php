<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class musclegroup extends Model
{
    use HasFactory;
    protected $table = 'musclegroup';
    protected $fillable = ['nom'];



     public function Exercices()
    {
        //return $this->belongsToMany(Exercice::class, 'exercice_muscle_group');
         //return $this->belongsToMany(Exercice::class, 'exercice_muscle_group', 'exercice_id', 'muscle_group_id');
         return $this->belongsToMany(Exercice::class, 'exercice_musclegroup', 'muscle_group_id', 'exercice_id');
         //return $this->belongsToMany(Exercice::class, 'exercice_musclegroup','exercice_id', 'muscle_group_id');
    }
}
