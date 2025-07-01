<?php

namespace App\Http\Service;

use App\Http\DAO\SourceDonnes\UserDAO;
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
}