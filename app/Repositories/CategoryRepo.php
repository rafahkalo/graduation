<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepo extends CoreRepository
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }
}
