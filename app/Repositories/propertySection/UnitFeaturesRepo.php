<?php

namespace App\Repositories\propertySection;

class UnitFeaturesRepo
{
    public function updateOrCreateDataOfUnit(array $items, $unitId, string $modelClass, string $relationTable, string $foreignKey): void
    {
        $relationTable::where('unit_id', $unitId)->delete();

        foreach ($items as $item) {
            if ($modelClass::find($item)) {
                $relationTable::create([
                    $foreignKey => $item,
                    'unit_id' => $unitId,
                ]);
            }
        }
    }
}
