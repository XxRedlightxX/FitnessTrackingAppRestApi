<?php

namespace App\DAO;

interface DAO {
    public function getById(int $id);
    public function getAll();
    public function save($entity); 
    public function update($entity);
    public function delete(int $id);
}