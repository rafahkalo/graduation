<?php

namespace App\Services;

use App\Repositories\UnitReviewRepo;

class UnitReviewService
{
    public function __construct(private UnitReviewRepo $unitReviewRepositories)
    {
    }

    public function store(array $data)
    {
        return $this->unitReviewRepositories->create($data);
    }
}
