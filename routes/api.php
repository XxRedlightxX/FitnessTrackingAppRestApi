<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExerciceController;


Route::get("/exercice",[ExerciceController::class, 'index']);
