<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\exercice;

class ExerciceController extends Controller
{
    public function index() {
          
        return response()->json(exercice::all());
    }
}
