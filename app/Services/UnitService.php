<?php

namespace App\Services;

use App\Models\Unit;
use App\Repositories\CoreRepository;
use Illuminate\Support\Facades\Log;

class UnitService extends CoreRepository
{
    public function __construct(Unit $unit)
    {
        parent::__construct($unit);
    }

    public function storeUnit(array $data)
    {
        Log::info(print_r($data, true));

        if (! isset($data['unit_id'])) {
            return $this->create($data);
        } else {
            return $this->update($data, $data['unit_id']);
        }
    }
}
