<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\exercice;

class ExerciceController extends Controller
{
    public function index() {
        
        try {
       
        $produits = Exercice::with('muscleGroups')->get();

  
        return response()->json($produits);

        } catch (\Exception $e) {
                
                return response()->json([
                    'error' => 'Something went wrong!',
                    'message' => $e->getMessage(), 
                    'code' => $e->getCode(),       
                ], 500); 
        }
    }


    
}
