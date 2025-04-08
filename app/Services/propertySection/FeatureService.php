<?php

namespace App\Services\propertySection;

use App\Repositories\propertySection\FeatureRepo;
use App\Traits\Media;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class FeatureService
{
    use Media;

    public function __construct(private FeatureRepo $featureRepo)
    {
    }

    public function index(int $per_page, ?string $status = null): Collection|LengthAwarePaginator
    {
        return $this->featureRepo->index(
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

        return $this->featureRepo->create($data);
    }

    public function update(array $data)
    {
        if (isset($data['image'])) {
            $feature = $this->featureRepo->show($data['feature']);
            $this->deleteImage($feature->image);
            $data['image'] = $this->saveImage($data['image'], 'features');
        }

        return $this->featureRepo->update($data, $data['feature']);
    }

    public function delete(string $featureId): void
    {
        $conditions = [
            'id' => $featureId,
        ];
        $this->featureRepo->delete($conditions);
    }
}
