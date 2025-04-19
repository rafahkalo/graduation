<?php

namespace Database\Seeders;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'شقق',
                'description' => 'وصف فئة الشقق',
                'image' => 'apartments.jpg',
                'status' => 'active',
                'translation' => json_encode([
                    'en' => [
                        'name' => 'Apartments',
                        'description' => 'Category for apartments'
                    ]
                ])
            ],
            [
                'name' => 'فلل',
                'description' => 'وصف فئة الفلل',
                'image' => 'villas.jpg',
                'status' => 'active',
                'translation' => json_encode([
                    'en' => [
                        'name' => 'Villas',
                        'description' => 'Category for villas'
                    ]
                ])
            ],
            [
                'name' => 'محلات تجارية',
                'description' => 'محلات في مواقع تجارية',
                'image' => 'shops.jpg',
                'status' => 'inactive',
                'translation' => json_encode([
                    'en' => [
                        'name' => 'Shops',
                        'description' => 'Shops in commercial areas'
                    ]
                ])
            ],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'id' => Str::uuid(),
                'name' => $cat['name'],
                'description' => $cat['description'],
                'image' => $cat['image'],
                'status' => $cat['status'],
                'translation' => $cat['translation'],
            ]);
        }
    }
}
