<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExerciceController;
use App\Http\Controllers\MuscleGroupController;
use App\Http\Controllers\WorkoutSessionController;
use App\Http\Controllers\UserController;

Route::get("/exercice",[ExerciceController::class, 'index']);

Route::post("/exercice",[ExerciceController::class, 'addExercice']);

Route::put("/exercice/{exerciceid}",[ExerciceController::class, 'updateExercice']);


Route::get("/muscleGroup",[MuscleGroupController::class, 'index']);

Route::get("/muscleGroup/{id}",[MuscleGroupController::class, 'FindMuscleGroup']);

Route::post("muscleGroup/{muscleGroupId}/exercises",[MuscleGroupController::class, 'addExerciseToMuscleGroup']);

Route::delete("/muscleGroup/{idMuscleGroup}",[MuscleGroupController::class, 'deleteMuscleGroup']);

Route::post('/Workout/{workout}/exercises/{exerciseSession}/sets', [WorkoutSessionController::class, 'addSetToExerciseSession']);

Route::get("/Workout",[WorkoutSessionController::class, 'index'] );

Route::get("/Workouts",[WorkoutSessionController::class, 'GetAllWorkout'] );

Route::post("/Workouts/{userid}",[WorkoutSessionController::class, 'AddWorkout'] );

Route::post("/Workouts/{workoutid}/excercice",[WorkoutSessionController::class, 'addExerciceToWorkout'] );

Route::put("/Workouts/{workoutid}",[WorkoutSessionController::class, 'UpdateWorkout'] );

Route::delete("/Workouts/{workoutid}",[WorkoutSessionController::class, 'DeleteWorkout'] );





Route::get("/users/{user}",[UserController::class, 'index'] );

Route::post("/user",[UserController::class, 'addUser'] );


Route::get("/user",[UserController::class, 'GetUserList'] );

Route::get("/user/{userid}",[UserController::class, 'getUserbyId'] );

Route::delete("/user/{userid}",[UserController::class, 'DeleteUserById'] );

Route::get("/user/{id}/Workout",[UserController::class, 'getUserWorkouts'] );



//Test
Route::post("user/{user}/workouts/{workout}/exercises/{exercice}",[UserController::class, 'addExercise2'] );

Route::post("/users",[UserController::class, 'CreateUser'] );