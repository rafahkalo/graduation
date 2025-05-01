<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CouponsTableSeeder extends Seeder
{
    public function run()
    {
        // Get existing user IDs
        $userIds = User::pluck('id')->where('is_verified', 1)->toArray();

        $coupons = [
            [
                'code' => 'WELCOME20',
                'type' => 'percent',
                'value' => 20,
                'max_uses' => 100,
                'max_uses_per_user' => 1,
                'starts_at' => now(),
                'expires_at' => now()->addMonth(),
                'status' => 'active',
                'description' => 'Welcome discount for new users',
                'minimum_reservation_amount' => 100,
                'user_id' => count($userIds) ? $userIds[array_rand($userIds)] : null,
            ],
            [
                'code' => 'FIXED50',
                'type' => 'fixed',
                'value' => 50,
                'max_uses' => 200,
                'max_uses_per_user' => 2,
                'starts_at' => now()->subDays(5),
                'expires_at' => now()->addMonth(),
                'status' => 'active',
                'description' => 'Flat discount for all services',
                'minimum_reservation_amount' => null,
                'user_id' => count($userIds) ? $userIds[array_rand($userIds)] : null,
            ],
            [
                'code' => 'VIP15',
                'type' => 'percent',
                'value' => 15,
                'max_uses' => 10,
                'max_uses_per_user' => 3,
                'starts_at' => now(),
                'expires_at' => now()->addYear(),
                'status' => 'active',
                'description' => 'Special VIP discount',
                'minimum_reservation_amount' => 500,
                'user_id' => count($userIds) ? $userIds[array_rand($userIds)] : null,
            ],
        ];

        foreach ($coupons as $couponData) {
            Coupon::create([
                'id' => Str::uuid(),
                'code' => $couponData['code'],
                'type' => $couponData['type'],
                'value' => $couponData['value'],
                'max_uses' => $couponData['max_uses'],
                'current_uses' => rand(0, $couponData['max_uses'] ? (int) ($couponData['max_uses'] * 0.3) : 50),
                'max_uses_per_user' => $couponData['max_uses_per_user'],
                'starts_at' => $couponData['starts_at'],
                'expires_at' => $couponData['expires_at'],
                'status' => $couponData['status'],
                'description' => $couponData['description'],
                'minimum_reservation_amount' => $couponData['minimum_reservation_amount'],
                'user_id' => $couponData['user_id'],
            ]);
        }
    }
}
