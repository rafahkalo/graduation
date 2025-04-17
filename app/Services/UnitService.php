<?php

namespace App\Services;

use App\Models\Unit;
use App\Repositories\CoreRepository;

class UnitService extends CoreRepository
{
    public function __construct(Unit $unit)
    {
        parent::__construct($unit);
    }

    public function storeUnit(array $data)
    {
        if (!isset($data['unit_id'])) {
            return $this->create($data);
        } else {
            return $this->update($data, $data['unit_id']);
        }
    }
}
