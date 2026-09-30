<?php

namespace App\Services;

use App\Contracts\CategoryItemServiceInterface;
use App\Models\CategoryItem;
use App\Repositories\CategoryItemRepository;
use Str;

class CategoryItemService implements CategoryItemServiceInterface
{
    public function __construct(
        private CategoryItemRepository $categoryItemRepository,
    ) {}

    public function getAll()
    {
        return CategoryItem::all();
    }

    public function findById($id)
    {
        return CategoryItem::find($id);
    }

    public function store(array $data)
    {
        $data['code'] = Str::upper(Str::random(6));

        return $this->categoryItemRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->categoryItemRepository->update($data, $id);
    }

    public function delete(int $id)
    {
        return $this->categoryItemRepository->delete($id);
    }
}
