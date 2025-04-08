<?php

namespace App\Traits;

use Tymon\JWTAuth\Facades\JWTAuth;

trait AuthTrait
{
    public function generateResponse(bool $status, string $message, $userWithToken = null): array
    {
        $response = [
            'status' => $status,
            'message' => $message,
        ];

        if ($userWithToken) {
            $response['user'] = $userWithToken;
        }

        return $response;
    }

    public function createTokenForUser($user)
    {
        return JWTAuth::fromUser($user);
    }

    public function userWithToken($user, $token)
    {
        $user->access_token = $token;
        $user->token_type = 'bearer';
        $user->expires_in = JWTAuth::factory()->getTTL();

        return $user;
    }
}
