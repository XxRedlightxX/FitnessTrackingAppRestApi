<?php

namespace App\Http\Service;

use App\Http\DAO\SourceDonnes\UserDAO;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\set;
use App\Models\User;
use App\Models\Workout;
use App\Models\exercice;
use App\Models\ExerciceSession;
use Illuminate\Validation\UnauthorizedException;
class UserService
{
    protected $userDAO;

     

    public function __construct(UserDAO $userDAO)
    {
        $this->userDAO = $userDAO;
    }

    public function getAllUserList()
    {
         try {
            return $this->userDAO->getAll();
        } catch (\Exception $e) {
            return $e;
        }
    }
    public function getUserById(int $userId)
    {
        $user = $this->userDAO->getById($userId);
        
        if (!$user) {
            throw new ModelNotFoundException("User not found");
        }

        return $user; 
    }

    public function addUser( User $user) {
        return $this->userDAO->save($user);
    }


      public function addExerciseToWorkout(array $validatedData, User $user,
        Workout $workout, Exercice $exercise
        ): ExerciceSession {


        if ($workout->user_id !== $user->id) {
            throw new UnauthorizedException('User does not own this workout');
        }

        $alreadyExists = ExerciceSession::where('workout_session_id', $workout->id)
            ->where('exercice_id', $exercise->id)
            ->exists();

         if ($alreadyExists) {
            throw new Exception("This exercise has already been added to this workout session.");
        }


        return $this->userDAO->addSetToUserExerciceSession(
            $validatedData['sets'],
            $user,
            $workout,
            $exercise
        );
    }

    
}