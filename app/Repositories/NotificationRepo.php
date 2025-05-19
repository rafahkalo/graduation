<?php

namespace App\Repositories;

use App\Models\Notification;

class NotificationRepo extends CoreRepository
{
    public function __construct(Notification $model)
    {
        parent::__construct($model);
    }
}
