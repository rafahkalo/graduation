<?php

namespace App\Repositories;

use App\Models\Direction;

class DirectionRepo extends CoreRepository
{
    public function __construct(Direction $direction)
    {
        parent::__construct($direction);
    }
}
