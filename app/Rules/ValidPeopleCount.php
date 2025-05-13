<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ValidPeopleCount implements Rule
{
    protected $unitId;

    public function __construct($unitId)
    {
        $this->unitId = $unitId;
    }

    public function passes($attribute, $value)
    {
        if (!$this->unitId || !$value) {
            return false;
        }

        $unit = DB::table('units')->where('id', $this->unitId)->first();

        if (!$unit || !isset($unit->num_person)) {
            return false;
        }

        return $value <= $unit->num_person;
    }

    public function message()
    {
        return __('validation.custom.people_count.exceeds_unit_limit');
    }
}
