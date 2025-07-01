<?php

namespace App\Http\DAO\SourceDonnes;
use App\Models\User;
use \App\Http\DAO\DAO;

interface UserDAO extends DAO {
     public function save($user);
    public function update(int $userid, array $data): ?User;

    // Add specific methods for User if needed
    public function getByEmail(string $email);


}