<?php

namespace App\Traits;

use App\Const\GlobalConst;
use Illuminate\Support\Facades\Storage;

trait Media
{
    public function saveImage($image, $filename = 'upload'): string
    {
        return Storage::disk(GlobalConst::DISK_IMAGE)->put($filename, $image, 'public');
    }

    public function deleteImage($filename): bool
    {
        return Storage::disk(GlobalConst::DISK_IMAGE)->delete($filename);
    }
}
