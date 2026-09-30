<?php

namespace App\Contracts;

interface CategoryItemServiceInterface
{
    public function getAll();

    public function findById($id);

    public function store(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);
}
