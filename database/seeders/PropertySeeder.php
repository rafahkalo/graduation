<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Direction;
use App\Models\Feature;
use App\Models\Location;
use App\Models\Property;
use App\Models\Unit;
use App\Models\UnitFeatures;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        User::create(['phone' => '966598456754', 'first_name' => 'leen', 'is_verified' => true]); // تأكد من وجود مستخدم في قاعدة البيانات
        $user = User::first();
        $direction = Direction::first();
        $category = Category::first();
        $feature = Feature::first();

        $property = Property::create([
             'id' => Str::uuid(),
             'name' => 'فيلا فاخرة',
             'description1' => 'وصف تفصيلي للفيلا.',
             'user_id' => $user?->id,
             'translation' => json_encode([
                 'en' => [
                     'name' => 'Luxury Villa',
                     'description1' => 'Detailed description of the villa',
                 ],
                 'ar' => [
                     'name' => 'فيلا فاخرة',
                     'description1' => 'وصف تفصيلي للفيلا.',
                 ],

             ]),
         ]);

        Location::create([
            'id' => Str::uuid(),
            'lng' => '43.23',
            'lat' => '23.56',
            'city' => 'riad',
            'street' => 'alhamraa',
            'model_id' => $property->id,
            'model_type' => Property::class,
            'direction_id' => $direction->id,
        ]);

       $unit = Unit::create([
            'id' => Str::uuid(),
            'title' => 'شقة رائعة',
            'description2' => 'وصف الشقة بالتفصيل',
            'main_image' => 'unit1.jpg',
            'street_width' => 12,
            'space' => 150,
            'equipment' => 'furnished',
            'property_type' => 'residential',
            'floor' => 2,
            'property_age' => 5,
            'status' => 'active',
            'reservation_type' => 'monthly',
            'deposit' => 1000,
            'reservation_status' => 'available',
            'accept_by_admin' => 'accepted',
            'message_of_admin' => 'مقبول',
            'house_rules' => 'ممنوع التدخين',
            'views' => 150,
            'price' => 5000.00,
            'property_id' => $property?->id,
            'user_id' => $user?->id,
            'category_id' => $category?->id,
            'translation' => json_encode([
                'en' => [
                    'title' => 'Great Apartment',
                    'description2' => 'Detailed description of the apartment',
                ],
                'ar' => [
                    'title' => 'شقة رائعة',
                    'description2' => 'وصف الشقة بالتفصيل',
                    ],
            ]),
            'guard_name' => 'أبو أحمد',
            'guard_phone' => '0555555555',
        ]);

        UnitFeatures::create(['unit_id' => $unit->id, 'feature_id' => $feature->id]);
    }
}
