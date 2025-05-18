<?php

namespace App\Observers;

use App\Jobs\TranslateModelJob;
use App\Models\Direction;

class DirectionObserver
{
    public function created(Direction $direction): void
    {
        $columns = Direction::$translatable;
        TranslateModelJob::dispatch($direction, $columns);
    }

    public function updated(Direction $direction): void
    {
        $columns = Direction::$translatable;
        TranslateModelJob::dispatch($direction, $columns);
    }
}
