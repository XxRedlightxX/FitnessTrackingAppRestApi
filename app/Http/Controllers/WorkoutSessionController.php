<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workout;
class WorkoutSessionController extends Controller
{
    public function index() {
    try {
        $produits = Workout::with('exercices')->get();
        return response()->json($produits, 200);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Something went wrong!',
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
        ], 500);
    }
}

}
