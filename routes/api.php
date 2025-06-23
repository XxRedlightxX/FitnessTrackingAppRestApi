<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExerciceController;
use App\Http\Controllers\MuscleGroupController;
use App\Http\Controllers\WorkoutSessionController;
use App\Http\Controllers\UserController;

Route::get("/exercice",[ExerciceController::class, 'index']);


Route::get("/muscleGroup",[MuscleGroupController::class, 'index']);

Route::get("/muscleGroup/{id}",[MuscleGroupController::class, 'FindMuscleGroup']);

Route::post("muscleGroup/{muscleGroupId}/exercises",[MuscleGroupController::class, 'addExerciseToMuscleGroup']);
 

Route::get("/Workout",[WorkoutSessionController::class, 'index'] );


Route::get("/users/{user}",[UserController::class, 'index'] );

Route::post("/user",[UserController::class, 'addUser'] );

Route::get("/user/{id}/Workout",[UserController::class, 'getUserWorkouts'] );