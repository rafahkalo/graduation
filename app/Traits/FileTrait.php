<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait FileTrait
{
    /**
     * تحميل ملف إلى التخزين المحمي.
     */
    protected function uploadFile(
        UploadedFile $file,
        string $directory = 'uploads',
        string $disk = 'private',
        bool $keepOriginalName = false
    ): array {
        // التحقق من نوع الملف
        $this->validateFileType($file);

        // إنشاء اسم فريد للملف
        $fileName = $keepOriginalName
            ? $this->sanitizeFileName($file->getClientOriginalName())
            : $this->generateUniqueFileName($file);

        // مسار التخزين الكامل
        $storagePath = $this->generateStoragePath($directory, $fileName);

        // تخزين الملف
        $file->storeAs(
            $directory,
            $fileName,
            $disk
        );

        return [
            'file_name' => $fileName,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'storage_path' => $storagePath,
            'disk' => $disk,
            'extension' => $file->getClientOriginalExtension(),
            'hash' => hash_file('sha256', $file->getRealPath()),
        ];
    }

    /**
     * إنشاء اسم فريد للملف
     */
    protected function generateUniqueFileName(UploadedFile $file): string
    {
        return Str::random(40) . '.' . $file->getClientOriginalExtension();
    }

    /**
     * تنظيف اسم الملف الأصلي.
     */
    protected function sanitizeFileName(string $filename): string
    {
        $cleaned = preg_replace("/[^a-zA-Z0-9\.\-_]/", '', $filename);

        return substr($cleaned, 0, 100); // تحديد طول اسم الملف
    }

    /**
     * توليد مسار التخزين.
     */
    protected function generateStoragePath(string $directory, string $fileName): string
    {
        return trim($directory, '/') . '/' . $fileName;
    }

    /**
     * التحقق من نوع الملف المسموح به.
     */
    protected function validateFileType(UploadedFile $file): void
    {
        $allowedMimeTypes = config('file.allowed_mime_types', [
            'image/jpeg',
            'image/png',
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ]);

        $maxSize = config('file.max_size', 10240); // 10MB

        if (!in_array($file->getMimeType(), $allowedMimeTypes)) {
            throw new \Exception('نوع الملف غير مسموح به');
        }

        if ($file->getSize() > $maxSize * 1024) {
            throw new \Exception('حجم الملف يتجاوز الحد المسموح به');
        }
    }

    /**
     * حذف الملف من التخزين.
     */
    protected function deleteFile(string $path, string $disk = 'private'): bool
    {
        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }

        return false;
    }

    /**
     * تنزيل الملف المحمي.
     */
    protected function downloadFile(
        string $path,
        string $originalName,
        string $disk = 'private',
        array $headers = []
    ) {
        if (!Storage::disk($disk)->exists($path)) {
            abort(404, 'الملف غير موجود');
        }

        return Storage::disk($disk)->download($path, $originalName, $headers);
    }

    /**
     * الحصول على رابط موقّت للملف
     */
    protected function getTemporaryFileUrl(
        string $path,
        string $disk = 'private',
        int $expiration = 30
    ): ?string {
        if (!Storage::disk($disk)->exists($path)) {
            return null;
        }

        return Storage::disk($disk)->temporaryUrl(
            $path,
            now()->addMinutes($expiration)
        );
    }
}
