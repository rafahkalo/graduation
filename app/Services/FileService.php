<?php

namespace App\Services;

use App\Models\File;
use App\Models\PropertyPublishRequest;
use App\Traits\FileTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileService
{
    use FileTrait;

    public function store(array $data, $id): void
    {
        DB::beginTransaction();

        try {

            foreach ($data['files'] as $file) {
                $fileInfo = $this->uploadFile(
                    $file,
                    'files/' . $id,
                );

                $fileRecord = File::create([
                    'model_type' => PropertyPublishRequest::class,
                    'model_id' => $id,
                    'user_id' => auth()->id(),
                    'filename' => $fileInfo['file_name'],
                    'original_name' => $fileInfo['original_name'],
                    'mime_type' => $fileInfo['mime_type'],
                    'size' => $fileInfo['size'],
                    'storage_path' => $fileInfo['storage_path'],
                    'disk' => $fileInfo['disk'],
                    'extension' => $fileInfo['extension'],
                    'hash' => $fileInfo['hash'],
                ]);

            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function renderFileContent(File $file): StreamedResponse
    {
        if (!Storage::disk($file->disk)->exists($file->storage_path)) {
            abort(404);
        }

        $mimeType = $file->mime_type;
        $contentDisposition = $this->getContentDisposition($file);

        return Storage::disk($file->disk)
            ->response(
                $file->storage_path,
                $file->original_name,
                [
                    'Content-Type' => $mimeType,
                    'Content-Disposition' => $contentDisposition
                ]
            );
    }

    protected function getContentDisposition(File $file): string
    {
        $previewAbleTypes = [
            'image/jpeg',
            'image/png',
            'image/gif',
            'application/pdf',
            'text/plain'
        ];

        return in_array($file->mime_type, $previewAbleTypes)
            ? 'inline; filename="'.$file->original_name.'"'
            : 'attachment; filename="'.$file->original_name.'"';
    }

    public function downloadFile(string $fileId): StreamedResponse
    {
        $file = File::findOrFail($fileId);

        $path = $file->storage_path;

        if (!Storage::disk($file->disk)->exists($path)) {
            abort(404, 'الملف غير موجود.');
        }

        return Storage::disk($file->disk)->download($path, $file->original_name);
    }
}
