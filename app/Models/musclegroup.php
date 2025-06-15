<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class musclegroup extends Model
{
    use HasFactory;
    protected $table = 'musclegroup';
    protected $fillable = [ 'nom'];

     public function type()
    {
        return $this->belongsToMany(Exercice::class, 'exercice_muscle_group');
    }
}
