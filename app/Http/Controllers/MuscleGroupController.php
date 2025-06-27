<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\musclegroup;
use App\Models\exercice;
class MuscleGroupController extends Controller
{

    // MuscleGroupController.php
public function index() {
    try {
  
        $muscleGroups = musclegroup::with('Exercices')->get(); // Ensure 'Exercices' method name matches the model relationship

        
        $response = $muscleGroups->map(function($muscleGroup) {
            return [
                'id' => $muscleGroup->id,
                'name' => $muscleGroup->name,
                'exercices' => $muscleGroup->Exercices->isEmpty() 
                                ? 'No exercises found' 
                                : $muscleGroup->Exercices
            ];
        });

     
        return response()->json($response, 200); 

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Something went wrong!',
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
        ], 500);
    }
}



    public function FindMuscleGroup(int $idMuscleGroup) {

   
             $muscleGroup =musclegroup::with('Exercices')->find($idMuscleGroup)->get();

             if (!$muscleGroup) {
                return response() ->json("Can't find {$idMuscleGroup}",
            404);
             }

             return response()->json( $muscleGroup, 200);
    }

    
    public function deleteMuscleGroup(int $idMuscleGroup) {

            try {
                $muscleGroup =musclegroup::findOrFail($idMuscleGroup);
                $muscleGroup->forceDelete();
               
                return response()->json( $muscleGroup, 200);
                 }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => "User with ID {$idMuscleGroup} not found."
            ], 404);

        }
             catch (\Exception $e) {
                return response() -> json($e);
            }
    }

    
    public function addExerciseToMuscleGroup(Request $request, $muscleGroupId)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'name' => 'required|string|max:255', 
                'category' => 'nullable|string|max:255', 
                'description' => 'nullable|string|max:1000', 
            ]);

            // Find the muscle group by ID
            $muscleGroup = musclegroup::find($muscleGroupId);

            // Check if the muscle group exists
            if (!$muscleGroup) {
                return response()->json([
                    'message' => 'Muscle group not found.'
                ], 404);
            }
            
           
            $exercise = Exercice::firstOrCreate(
                ['name' => $request->name], 
                [
                    'category' => $request->category, 
                    'description' => $request->description, 
                   
                ]
            );

            // Attach the exercise to the muscle group using the correct pivot table method
            // Attach the correct exercise ID to the correct muscle group ID
            
            $exercise->muscleGroups()->attach($muscleGroup->id);

            // Return success response
            return response()->json([
                
                'exercise' => $exercise
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong!',
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ], 500);
        }
    }

    public function AddExerciece() {
    }
}
