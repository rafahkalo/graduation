<?php

namespace App\Observers;

use App\Const\GlobalConst;
use App\Models\Image;
use App\Models\Unit;
use App\Traits\Media;
use Illuminate\Support\Facades\Storage;

class UnitObserver
{
    use Media;

    public function creating(Unit $unit)
    {
        $unit->rating_details = [
            'cleanliness' => 0,
            'accuracy' => 0,
            'check_in' => 0,
            'communication' => 0,
            'value' => 0,
            'overall_rating_1' => 0,
            'overall_rating_2' => 0,
            'overall_rating_3' => 0,
            'overall_rating_4' => 0,
            'overall_rating_5' => 0,
            'total_reviewers' => 0,
            'current_overall_rating' => 0,
            'current_badge_code' => 0,
        ];
    }

    public function updating(Unit $unit)
    {
        // هل الصور الجديدة مرفقة مع الموديل؟
        if (!empty($unit->images)) {
            // حذف الصور القديمة المرتبطة بالوحدة
            $oldImages = $unit->images;

            foreach ($oldImages as $image) {
                if (Storage::disk(GlobalConst::DISK_IMAGE)->exists($image->path)) {
                    Storage::disk(GlobalConst::DISK_IMAGE)->delete($image->path);
                }
                $image->delete();
            }
        }
    }

    /**
     * Handle the Unit "deleted" event.
     */
    public function deleted(Unit $unit): void
    {
        //
    }

    /**
     * Handle the Unit "restored" event.
     */
    public function restored(Unit $unit): void
    {
        //
    }

    /**
     * Handle the Unit "force deleted" event.
     */
    public function forceDeleted(Unit $unit): void
    {
        //
    }
}
