<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\musclegroup;

class MuscleGroupController extends Controller
{

    public function index() {

        try {
        $musclgroup = musclegroup::with('Exercices')->get();

        

        return response()->json($musclgroup);
        } catch(\Exception $e) {
              return response()->json([
                    'error' => 'Something went wrong!',
                    'message' => $e->getMessage(), // Optionally include the error message
                    'code' => $e->getCode(),       // Optionally include the error code
                ], 500); // HTTP status 500 (Internal Server Error)
        }

    }

    public function AddExerciece() {

    }
}
