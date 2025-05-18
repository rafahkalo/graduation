<?php

namespace App\Rules;

use App\Models\PropertySection\Unit;
use Illuminate\Contracts\Validation\Rule;

class CompleteUnitOrNot implements Rule
{
    protected $unitId;

    public function __construct($unitId)
    {
        $this->unitId = $unitId;
    }

    public function passes($attribute, $value)
    {
        $unit = Unit::find($this->unitId);

        return $unit && $unit->unit_is_completed == 0;
    }

    public function message()
    {
        return 'The selected unit is completed.';
    }
}
