<?php

namespace App\Http\Controllers;

use App\Http\Service\UserService;
use App\Models\exercice;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Workout;
use App\Models\ExerciceSession;
use App\Models\Set;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;
class UserController extends Controller
{

    protected $userService;

      public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


     public function getUserList()
    {
        $users = $this->userService->getAllUserList();
        return response()->json($users, 200);
    }
    public function getUserById(int $userId)
    {
        try {
            $user = $this->userService->getUserById($userId);
            return response()->json([$user]);
        } 
        catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => "User not found with ID {$userId}"
            ], 404);
        }
        catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ], 500);
        }
    }

    public function addExercise2(Request $request, User $user,
        Workout $workout, 
        Exercice $exercice
    ) {
        try {
            $validated = $request->validate([
                'sets' => 'required|array|min:1|max:10',
                'sets.*.weight' => 'required|numeric|min:0',
                'sets.*.reps' => 'required|integer|min:1'
            ]);

            $result = $this->userService->addExerciseToWorkout(
                $validated,
                $user,
                $workout,
                $exercice
            );

            return response()->json([
                'message' => 'Exercise added successfully',
                'data' => $result
            ], 201);

        } catch (UnauthorizedException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }  catch (\Exception $e) {
            return response()->json(['error' =>  $e->getMessage()], 500);
        }
    }

    public function CreateUser(User $user) {
    
        $result = $this->userService->addUser($user);
        return response()->json($result);
         

    }

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
