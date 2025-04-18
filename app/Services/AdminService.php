<?php

namespace App\Services;

use App\Repositories\AdminRepo;
use App\Traits\AuthTrait;

class AdminService
{
    use AuthTrait;

    public function __construct(private AdminRepo $adminRepo) {}

    public function loginAsAdmin(array $data): array
    {
        $admin = $this->adminRepo->getAdminByEmail($data['email']);

        if (! $this->adminRepo->isValidAdmin($admin, $data['password'])) {
            return $this->generateResponse(false, 'unauthorized');
        }

        $token = $this->createTokenForUser($admin);

        return $this->generateResponse(true, 'login_success', $this->userWithToken($admin, $token));
    }
}
