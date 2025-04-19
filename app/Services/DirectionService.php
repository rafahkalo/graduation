<?php

namespace App\Services;

use App\Repositories\DirectionRepo;
use App\Traits\Media;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class DirectionService
{
    use Media;

    public function __construct(private DirectionRepo $directionRepo)
    {
    }

    public function index(int $per_page, ?string $status = null): Collection|LengthAwarePaginator
    {
        return $this->directionRepo->index(
            per_page: $per_page,
            filters: array_filter([
                'status' => $status,
            ])
        );
    }

    public function store(array $data)
    {
        if (isset($data['image'])) {
            $data['image'] = $this->saveImage($data['image'], 'features');
        }

        return $this->directionRepo->create($data);
    }

    public function update(array $data)
    {
        if (isset($data['image'])) {
            $feature = $this->directionRepo->show($data['feature']);
            $this->deleteImage($feature->image);
            $data['image'] = $this->saveImage($data['image'], 'features');
        }

        return $this->directionRepo->update($data, $data['feature']);
    }

    public function delete(string $featureId): void
    {
        $conditions = [
            'id' => $featureId,
        ];
        $this->directionRepo->delete($conditions);
    }
}
