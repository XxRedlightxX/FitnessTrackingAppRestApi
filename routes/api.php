<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExerciceController;
use App\Http\Controllers\MuscleGroupController;


Route::get("/exercice",[ExerciceController::class, 'index']);


Route::get("/muscleGroup",[MuscleGroupController::class, 'index']);
 