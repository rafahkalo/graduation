<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Services\FileService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private FileService $fileService) {}

    public function preview(string $fileId): StreamedResponse
    {
        $file = File::find($fileId);
        $this->authorize('viewAsAdmin', $file);

        return $this->fileService->renderFileContent($file);
    }

    public function download(string $fileId): StreamedResponse
    {
        return $this->fileService->downloadFile($fileId);
    }
}
