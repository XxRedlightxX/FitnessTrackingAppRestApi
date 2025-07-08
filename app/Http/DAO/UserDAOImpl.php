<?php

namespace App\Http\DAO;


use App\Http\DAO\SourceDonnes\UserDAO;
use App\Models\set;
use App\Models\User;
use App\Models\Workout;
use App\Models\exercice;
use App\Models\ExerciceSession;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\Log;





class UserDAOImpl implements UserDAO {


    public function getByEmail(string $email) {
    }


   public function save($userData) 
{
    // Use firstOrCreate to prevent duplicates
    $user = User::firstOrCreate(
        ['email' => $userData->email], // Check if email exists
        [
            'name' => $userData->name,
              'name' => $userData->email,
            'password' => Hash::make($userData->password),
            'email_verified_at' => now(), // Or null if not verified
        ]
    );

    return $user;
}

    /**
     * @inheritDoc
     */
    public function update($userid, $data): ?User {

        $user = User::find($userid);
        if (!$user) return null;

        $user->update($data);
        return $user;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id) {
    }

 
    public function getAll() {
        try {
            return User::all();
       
        } catch (\Exception $e) {
      
            Log::error("UserDAO getAll() failed: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id)  {
        try 
        {
            return User::findOrFail($id);
        } 
        catch (\Exception $e) {
             Log::error("Failed to retrieve  " . $e->getMessage());
        }
    }
   

   
    public function addSetToUserExerciceSession(array $request, User $user, 
    Workout $workout, Exercice $exercice) {

        $exerciceSession = ExerciceSession::create([
        'workout_session_id' => $workout->id,
        'exercice_id' => $exercice->id
        ]);

        $sets = collect($request)->map(fn ($set, $index) => new Set([
                'set_number' => $index + 1,
                'weight' => $set['weight'],
                'reps' => $set['reps'],
                'exercice_session_id' =>  $exerciceSession->id
            ]));

        $exerciceSession->sets()->saveMany($sets);
        return  $exerciceSession->load('exercice', 'sets');
    }

    

}


   



