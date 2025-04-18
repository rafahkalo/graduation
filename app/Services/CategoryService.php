<?php

namespace App\Services;

use App\Repositories\CategoryRepo;
use App\Traits\Media;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService
{
    use Media;

    public function __construct(private CategoryRepo $categoryRepo) {}

    public function index(int $per_page, ?string $status = null): Collection|LengthAwarePaginator
    {
        return $this->categoryRepo->index(
            per_page: $per_page,
            filters: array_filter([
                'status' => $status,
            ])
        );
    }

    public function store(array $data)
    {
        if (isset($data['image'])) {
            $data['image'] = $this->saveImage($data['image'], 'category');
        }

        return $this->categoryRepo->create($data);
    }

    public function update(array $data)
    {
        if (isset($data['image'])) {
            $feature = $this->categoryRepo->show($data['category']);
            $this->deleteImage($feature->image);
            $data['image'] = $this->saveImage($data['image'], 'category');
        }

        return $this->categoryRepo->update($data, $data['category']);
    }

    public function delete(string $categoryId): void
    {
        $conditions = [
            'id' => $categoryId,
        ];
        $this->categoryRepo->delete($conditions);
    }
}
