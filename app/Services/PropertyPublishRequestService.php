<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\PropertyPublishRequestRepo;
use App\Traits\FileTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class PropertyPublishRequestService
{
    use FileTrait;

    public function __construct(
        private PropertyPublishRequestRepo $publishRequestRepo,
        private FileService $fileService,
        private AuthService $authService,
    ) {}

    public function index(int $per_page, ?string $status = null): Collection|LengthAwarePaginator
    {
        // التحقق من حالة المصادقة
        if (Auth::guard('api')->check()) {
            $filters = ['user_id' => Auth::id()];
            $with = [];
        } else {
            $filters = [];
            $with = ['user'];
        }

        // إضافة فلتر status إذا كان غير فارغ أو غير null
        if ($status !== null) {
            $filters['status'] = $status;
        }

        return $this->publishRequestRepo->index(
            per_page: $per_page,
            filters: $filters,
            with: $with
        );
    }

    public function store(array $data)
    {
        $publishRequest = $this->publishRequestRepo->updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'property_type' => $data['property_type'],
            ]
        );

        if (! empty($data['files'])) {
            $this->fileService->store($data, $publishRequest->id);
        }

        return $publishRequest;
    }

    public function update(array $data)
    {
        $publishRequest = $this->publishRequestRepo->show($data['property_approval_request']);
        if (Auth::guard('api_admin')->check()) {
            $data['admin_id'] = Auth::guard('api_admin')->id();
            if ($data['status'] === 'approved') {
                // تعديل حالة المستخدم ل متحقق منه
                $this->authService->updateProfile(['is_verified' => true], User::class, $publishRequest->user_id);
            }
        }

        return $this->publishRequestRepo->update($data, $data['property_approval_request']);
    }

    public function show(string $property_approval_request_id)
    {
        $filters = ['id' => $property_approval_request_id];
        $with = ['user'];

        return $this->publishRequestRepo->getObject(filters: $filters, with: $with);
    }
}
