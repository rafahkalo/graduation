<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $languages = DB::table('languages')->pluck('code')->toArray();

        // ترجمات لكل feature
        $rawTranslations = [
            'Safety Lock' => [
                'en' => 'Safety Lock',
                'ar' => 'قفل الأمان',
                'fr' => 'Verrou de sécurité',
            ],
            '24/7 Support' => [
                'en' => '24/7 Support',
                'ar' => 'دعم على مدار الساعة',
                'fr' => 'Assistance 24/7',
            ],
            'Dark Mode' => [
                'en' => 'Dark Mode',
                'ar' => 'الوضع المظلم',
                'fr' => 'Mode sombre',
            ],
            'Emergency Stop' => [
                'en' => 'Emergency Stop',
                'ar' => 'إيقاف الطوارئ',
                'fr' => 'Arrêt d\'urgence',
            ],
        ];

        $features = [
            [
                'name' => 'Safety Lock',
                'status' => 'active',
                'description' => 'Advanced safety locking mechanism',
                'type' => 'safety_element',
                'image' => 'safety-lock.jpg',
            ],
            [
                'name' => '24/7 Support',
                'status' => 'active',
                'description' => 'Round the clock customer support',
                'type' => 'main_service',
                'image' => 'support-icon.png',
            ],
            [
                'name' => 'Dark Mode',
                'status' => 'active',
                'description' => 'Eye-friendly dark theme option',
                'type' => 'feature',
                'image' => 'dark-mode.png',
            ],
            [
                'name' => 'Emergency Stop',
                'status' => 'inactive',
                'description' => 'Immediately halts all operations',
                'type' => 'safety_element',
                'image' => 'emergency-stop.jpg',
            ],
        ];

        foreach ($features as $feature) {
            $name = $feature['name'];

            $translations = [];
            foreach ($languages as $lang) {
                // إذا ما فيه ترجمة للغة معينة، نستخدم الترجمة الإنجليزية
                $translations[$lang] = $rawTranslations[$name][$lang] ?? $rawTranslations[$name]['en'];
            }

            $feature['translation'] = json_encode($translations, JSON_UNESCAPED_UNICODE);
            Feature::create($feature);
        }
    }
}
