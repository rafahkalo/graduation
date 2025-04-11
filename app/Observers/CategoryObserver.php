<?php

namespace App\Observers;

use App\Jobs\TranslateModelJob;
use App\Models\Category;

class CategoryObserver
{
    public function created(Category $category): void
    {
        $columns = Category::$translatable;
        TranslateModelJob::dispatch($category, $columns);
    }

    public function updated(Category $feature): void
    {
        $columns = Category::$translatable;
        TranslateModelJob::dispatch($feature, $columns);
    }
}
