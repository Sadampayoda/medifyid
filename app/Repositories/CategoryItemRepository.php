<?php

namespace App\Repositories;

use App\Models\CategoryItem;

class CategoryItemRepository
{
    public function __construct(
        private CategoryItem $model,
    ) {}

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, int $id)
    {
        return $this->model->find($id)->update($data);
    }

    public function delete(int $id)
    {
        return $this->model->find($id)->delete();
    }
}
