<?php

namespace App\Http\DAO\SourceDonnes;
use App\Models\User;
use App\Models\Workout;
use App\Models\exercice;
use \App\Http\DAO\DAO;

interface UserDAO extends DAO {
     public function save($user);
    public function update(int $userid, array $data): ?User;

    public function addSetToUserExerciceSession(array $request, User $user, Workout $workout, exercice $exercice);


    // Add specific methods for User if needed
    public function getByEmail(string $email);


}