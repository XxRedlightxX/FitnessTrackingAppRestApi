<?php

namespace App\Http\Controllers;

use App\Models\exercice;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Workout;
use App\Models\ExerciceSession;
use App\Models\Set;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function index(User $user)
{
    /*try {
    
        //$workoutSessions = $user->workoutSessions()->with('exercices')->get();
        $user->load('workoutSessions.exercices');
        return response()->json($user, 200);
e
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Something went wrong!',
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
        ], 500);
    }*/

    try {
        
        $userWithWorkouts = User::with([
            'workoutSessions.exerciceSessionPivots.exercice',
            'workoutSessions.exerciceSessionPivots.sets',
        ])->findOrFail($user->id);

        return response()->json($userWithWorkouts, 200);

    } catch (\Exception $e) {
          return response()->json([
            'error' => 'Something went wrong!',
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
        ], 500);
    }
    }

    public function GetUserList() {
        try {
         return response()->json(User::all());

        
        } catch(\Exception $e) {
            response() -> json($e);
        }
    }


   // WorkoutSessionController.php
public function addExercise(Request $request, User $user, Workout $workout, exercice $exercice)
{
    try {
        // Verify workout ownership
        if ($workout->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        $validated = $request->validate([
            //'exercice_id' => $exerciceid->id,
            'sets' => 'required|array|min:1',
            'sets.*.weight' => 'required|numeric',
            'sets.*.reps' => 'required|integer'
        ]);

        // Create exercise session first
        $exerciseSession = ExerciceSession::create([
            'workout_session_id' => $workout->id,
            'exercice_id' => $exercice->id
        ]);

        // Create sets with the exercise session ID
        $sets = collect($validated['sets'])->map(function($set,$index) use ($exerciseSession) {
            return new Set([
                'set_number' => $index + 1, 
                'weight' => $set['weight'],
                'reps' => $set['reps'],
                'exercice_session_id' => $exerciseSession->id
            ]);
        });

        
        $exerciseSession->sets()->saveMany($sets);

        return response()->json([
            'message' => 'Exercise and sets added successfully',
            'data' => $exerciseSession->load('exercice', 'sets')
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Operation failed',
            'message' => $e->getMessage()
        ], 500);
    }
}


    

    public function addUser( Request $request) {
        
        try {
            $request->validate(
                [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|max:255'
                ]
            );

            $user = User::createOrFirst(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password), 
                ]
            );

            return response()->json([
                'user' => $user
            ],200);
        } catch(\Exception $e) {
            return response()->json(
                [
                'error' => 'Something went wrong!',
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                ],
            );
        }
    }

    public function getUserWorkouts($userId)
    {
        try {
            $user = User::findOrFail($userId);

            if (!$user) {
                return response() ->json("Can't find {$userId}",
            404);
             }
            $workouts = Workout::with('exercices')
                ->where('user_id', $userId)
                ->get();

        return response()->json($workouts);
        } catch (\Exception $e) {
            return response()->json(
                [
                'error' => 'Something went wrong!',
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                ],
            );
        }
    }

    public function DeleteUserById($userid) {
        try {
            $user = User::findOrFail($userid); // Will throw if not found
            $user->forceDelete();

            return response()->json([
                'message' => "User with ID {$userid} has been  deleted."
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => "User with ID {$userid} not found."
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An unexpected error occurred.',
                'details' => $e->getMessage() // Optional: remove in production
            ], 500);
        }
    }
}
