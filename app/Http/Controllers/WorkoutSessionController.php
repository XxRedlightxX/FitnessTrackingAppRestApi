<?php

namespace App\Http\Controllers;

use App\Models\exercice;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Workout;
use App\Models\ExerciceSession;
use App\Models\Set;
class WorkoutSessionController extends Controller
{
    public function index() {
    try {
        $produits = Workout::with('exerciceSessionPivots')->get();
        return response()->json($produits, 200);
    
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Something went wrong!',
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
        ], 500);
    }
}

    public function GetAllWorkout() {
        try {
        return response() -> json(Workout::all());
        }
        catch (\Exception $e) {
            response()->json($e);
        }

    }

  public function addWorkout(Request $request, $userId)
    {
        try {
            $request->validate([
                'notes' => 'required|string|max:255',
            ]);

            $user = User::findOrFail($userId);

            $workout = Workout::create([
                'user_id' => $userId,
                'notes' => $request->notes,
                'date' => now(),
            ]);

            return response()->json([
                'workout' => $workout
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => "User with ID {$userId} not found."
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function DeleteWorkout($workoutid) {
        try {
            $workout = Workout::findOrFail($workoutid);
            $workout->forceDelete();

            return response()->json(
                [
                    'message' => "Workout with ID {$workoutid} has been  deleted."
                ], 200);

        }
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => "User with ID {$workoutid} not found."
            ], 404);
        }
        
        catch(\Exception $e) {
            return response() -> json($e);
        }
    }

     public function UpdateWorkout(Request $request, $workoutid)
    {
        try {
            $request->validate([
                'notes' => 'required|string|max:255',
            ]);

            $workout = Workout::findOrFail($workoutid);
            $workout->notes = $request->notes;
            $workout->save();

            return response()->json([
                'message' => "Success",
                'workout' => $workout,
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => "Workout with ID {$workoutid} not found."
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Unexpected error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function addExerciceToWorkout(Request $request, $workoutid)
    {
        try {
            $request->validate([
                'exercice_id' => 'required|exists:exercice,id'
            ]);

            $workout = Workout::findOrFail($workoutid);

        
            if ($workout->exerciceSessionPivots()->where('exercice_id', $request->exercice_id)->exists()) {
                return response()->json([
                    'error' => 'Exercise already in workout'
                ], 409);
            }

            $exerciseSession = $workout->exerciceSessionPivots()->create([
                'exercice_id' => $request->exercice_id
            ]);

            return response()->json([
                'message' => 'Exercise added successfully',
                'data' => $exerciseSession
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function addSetToExerciseSession(Request $request, $workoutId, $exerciseSessionId)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'weight' => 'required|numeric',
                'reps' => 'required|integer',
                'set_number' => 'nullable|integer' // optional
            ]);

            // Make sure the session exists and belongs to the workout
            $exerciseSession = ExerciceSession::where('id', $exerciseSessionId)
                ->where('workout_session_id', $workoutId)
                ->firstOrFail();

            // Determine set_number if not provided
            $setNumber = $validated['set_number'] ?? ($exerciseSession->sets()->count() + 1);

            // Create the set
            $set = $exerciseSession->sets()->create([
                'set_number' => $setNumber,
                'weight' => $validated['weight'],
                'reps' => $validated['reps'],
            ]);

            return response()->json([
                'message' => 'Set added successfully',
                'data' => $set
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteSet($workoutId, $exerciseSessionId, $setId)
    {
        try {
            $set = Set::where('id', $setId)
                ->where('exercice_session_id', $exerciseSessionId)
                ->whereHas('workoutExercice', function ($query) use ($workoutId) {
                    $query->where('workout_session_id', $workoutId);
                })
                ->firstOrFail();

            $set->delete();

            return response()->json(['message' => 'Set deleted successfully'], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Set not found or unauthorized',
                'message' => $e->getMessage()
            ], 404);
        }
    }





    

}


