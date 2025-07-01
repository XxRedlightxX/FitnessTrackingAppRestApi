<?php

namespace App\Http\DAO;


use App\Http\DAO\SourceDonnes\UserDAO;
use App\Models\User;
use Illuminate\Http\JsonResponse;


class UserDAOImpl implements UserDAO {


    public function getByEmail(string $email) {
    }


    public function save($user) {
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
      
            \Illuminate\Support\Facades\Log::error("UserDAO getAll() failed: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id) {
    }
}


   



