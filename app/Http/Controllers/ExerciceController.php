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

    public function addExercice(Request $request) {
        try {
            $request->validate(
                [
                    'name' => 'required|string|max:255',
                    'category' => 'required|string|max:255',
                    'description' => 'required|string|max:255'
                ]
            );

            $exercice = Exercice::createOrFirst(
                [
                'name' => $request->name,
                'category' => $request->category,
                'description' => $request->description,
                ]
            );

             return response()->json([
                'user' =>  $exercice
            ],200);


        } catch(\Exception $e) {
            return response() -> json($e);
        }
    }

    public function findExercice($exerciceid) {
        try {
            
            $exercice = exercice::findOrFail($exerciceid);


             return response()->json([
                'user' =>  $exercice
            ],200);

        }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => "User with ID {$exerciceid} not found."
            ], 404);

        } catch(\Exception $e) {
            return response() -> json($e);
        }
    }


    public function updateExercice(Request $request, $exerciceid) {
        try {

              $request->validate([
                'name' => 'required|string|max:255',
                'category' => 'required|string|max:255',
                'description' => 'required|string|max:255',
            ]);
            $exercice = exercice::findOrFail($exerciceid);
            
            $exercice->name = $request->name;
            $exercice->category = $request->category;
            $exercice->description = $request->description;
            $exercice->save();

             return response()->json([
                'excercice' =>  $exercice
            ],200);

        }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => "User with ID {$exerciceid} not found."
            ], 404);

        } catch(\Exception $e) {
            return response() -> json($e);
        }
    }

    public function deleteExercicebyId($exerciceid) {

        try {
            $exercice = exercice::findOrFail($exerciceid);

           $exercice->forceDelete();

        
        }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => "User with ID {$exerciceid} not found."
            ], 404);

        }  catch(\Exception $e) {
            return response() -> json($e);
        }
    }


    
}
