<?php

namespace App\Traits;

use App\Const\GlobalConst;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

trait Media
{
    public function saveImage($image, $filename = 'upload'): string
    {
        return Storage::disk(GlobalConst::DISK_IMAGE)->put($filename, $image, 'public');
    }

    public function saveImages(array $images, Model $relatedModel, string $directory = 'upload'): array
    {
        $storedPaths = [];

        foreach ($images as $image) {
            $path = Storage::disk(GlobalConst::DISK_IMAGE)->put($directory, $image, 'public');

            $relatedModel->images()->create([
                'path' => $path,
            ]);

            $storedPaths[] = $path;
        }

        return $storedPaths;
    }

    public function deleteImage($filename): bool
    {
        return Storage::disk(GlobalConst::DISK_IMAGE)->delete($filename);
    }
}
