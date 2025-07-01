<?php

namespace App\Http\DAO;

interface DAO {
    public function getById(int $id);
    public function getAll();
    public function save(mixed $entity); 
    public function update(int $id, array $data);
    public function delete(int $id);
}