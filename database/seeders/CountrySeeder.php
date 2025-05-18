<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            [
                'name' => 'Afghanistan',
                'code' => 'AF',
                'phone_code' => '+93',
                'translation' => [
                    'ar' => 'أفغانستان',
                    'en' => 'Afghanistan',
                ],
            ],
            [
                'name' => 'Albania',
                'code' => 'AL',
                'phone_code' => '+355',
                'translation' => [
                    'ar' => 'ألبانيا',
                    'en' => 'Albania',
                ],
            ],
            [
                'name' => 'Algeria',
                'code' => 'DZ',
                'phone_code' => '+213',
                'translation' => [
                    'ar' => 'الجزائر',
                    'en' => 'Algeria',
                ],
            ],
            [
                'name' => 'Andorra',
                'code' => 'AD',
                'phone_code' => '+376',
                'translation' => [
                    'ar' => 'أندورا',
                    'en' => 'Andorra',
                ],
            ],
            [
                'name' => 'Angola',
                'code' => 'AO',
                'phone_code' => '+244',
                'translation' => [
                    'ar' => 'أنغولا',
                    'en' => 'Angola',
                ],
            ],
            [
                'name' => 'Antigua and Barbuda',
                'code' => 'AG',
                'phone_code' => '+1-268',
                'translation' => [
                    'ar' => 'أنتيغوا وباربودا',
                    'en' => 'Antigua and Barbuda',
                ],
            ],
            [
                'name' => 'Argentina',
                'code' => 'AR',
                'phone_code' => '+54',
                'translation' => [
                    'ar' => 'الأرجنتين',
                    'en' => 'Argentina',
                ],
            ],
            [
                'name' => 'Armenia',
                'code' => 'AM',
                'phone_code' => '+374',
                'translation' => [
                    'ar' => 'أرمينيا',
                    'en' => 'Armenia',
                ],
            ],
            [
                'name' => 'Australia',
                'code' => 'AU',
                'phone_code' => '+61',
                'translation' => [
                    'ar' => 'أستراليا',
                    'en' => 'Australia',
                ],
            ],
            [
                'name' => 'Austria',
                'code' => 'AT',
                'phone_code' => '+43',
                'translation' => [
                    'ar' => 'النمسا',
                    'en' => 'Austria',
                ],
            ],
            [
                'name' => 'Azerbaijan',
                'code' => 'AZ',
                'phone_code' => '+994',
                'translation' => [
                    'ar' => 'أذربيجان',
                    'en' => 'Azerbaijan',
                ],
            ],
            [
                'name' => 'Bahamas',
                'code' => 'BS',
                'phone_code' => '+1-242',
                'translation' => [
                    'ar' => 'باهاماس',
                    'en' => 'Bahamas',
                ],
            ],
            [
                'name' => 'Bahrain',
                'code' => 'BH',
                'phone_code' => '+973',
                'translation' => [
                    'ar' => 'البحرين',
                    'en' => 'Bahrain',
                ],
            ],
            [
                'name' => 'Bangladesh',
                'code' => 'BD',
                'phone_code' => '+880',
                'translation' => [
                    'ar' => 'بنغلاديش',
                    'en' => 'Bangladesh',
                ],
            ],
            [
                'name' => 'Barbados',
                'code' => 'BB',
                'phone_code' => '+1-246',
                'translation' => [
                    'ar' => 'باربادوس',
                    'en' => 'Barbados',
                ],
            ],
            [
                'name' => 'Belarus',
                'code' => 'BY',
                'phone_code' => '+375',
                'translation' => [
                    'ar' => 'بيلاروسيا',
                    'en' => 'Belarus',
                ],
            ],
            [
                'name' => 'Belgium',
                'code' => 'BE',
                'phone_code' => '+32',
                'translation' => [
                    'ar' => 'بلجيكا',
                    'en' => 'Belgium',
                ],
            ],
            [
                'name' => 'Belize',
                'code' => 'BZ',
                'phone_code' => '+501',
                'translation' => [
                    'ar' => 'بليز',
                    'en' => 'Belize',
                ],
            ],
            [
                'name' => 'Benin',
                'code' => 'BJ',
                'phone_code' => '+229',
                'translation' => [
                    'ar' => 'بنين',
                    'en' => 'Benin',
                ],
            ],
            [
                'name' => 'Bhutan',
                'code' => 'BT',
                'phone_code' => '+975',
                'translation' => [
                    'ar' => 'بوتان',
                    'en' => 'Bhutan',
                ],
            ],
            [
                'name' => 'Bolivia',
                'code' => 'BO',
                'phone_code' => '+591',
                'translation' => [
                    'ar' => 'بوليفيا',
                    'en' => 'Bolivia',
                ],
            ],
            [
                'name' => 'Bosnia and Herzegovina',
                'code' => 'BA',
                'phone_code' => '+387',
                'translation' => [
                    'ar' => 'البوسنة والهرسك',
                    'en' => 'Bosnia and Herzegovina',
                ],
            ],
            [
                'name' => 'Botswana',
                'code' => 'BW',
                'phone_code' => '+267',
                'translation' => [
                    'ar' => 'بوتسوانا',
                    'en' => 'Botswana',
                ],
            ],
            [
                'name' => 'Brazil',
                'code' => 'BR',
                'phone_code' => '+55',
                'translation' => [
                    'ar' => 'البرازيل',
                    'en' => 'Brazil',
                ],
            ],
            [
                'name' => 'Brunei',
                'code' => 'BN',
                'phone_code' => '+673',
                'translation' => [
                    'ar' => 'بروناي',
                    'en' => 'Brunei',
                ],
            ],
            [
                'name' => 'Bulgaria',
                'code' => 'BG',
                'phone_code' => '+359',
                'translation' => [
                    'ar' => 'بلغاريا',
                    'en' => 'Bulgaria',
                ],
            ],
            [
                'name' => 'Burkina Faso',
                'code' => 'BF',
                'phone_code' => '+226',
                'translation' => [
                    'ar' => 'بوركينا فاسو',
                    'en' => 'Burkina Faso',
                ],
            ],
            [
                'name' => 'Burundi',
                'code' => 'BI',
                'phone_code' => '+257',
                'translation' => [
                    'ar' => 'بوروندي',
                    'en' => 'Burundi',
                ],
            ],
            [
                'name' => 'Cambodia',
                'code' => 'KH',
                'phone_code' => '+855',
                'translation' => [
                    'ar' => 'كمبوديا',
                    'en' => 'Cambodia',
                ],
            ],
            [
                'name' => 'Cameroon',
                'code' => 'CM',
                'phone_code' => '+237',
                'translation' => [
                    'ar' => 'الكاميرون',
                    'en' => 'Cameroon',
                ],
            ],
            [
                'name' => 'Canada',
                'code' => 'CA',
                'phone_code' => '+1',
                'translation' => [
                    'ar' => 'كندا',
                    'en' => 'Canada',
                ],
            ],
            [
                'name' => 'Cape Verde',
                'code' => 'CV',
                'phone_code' => '+238',
                'translation' => [
                    'ar' => 'الرأس الأخضر',
                    'en' => 'Cape Verde',
                ],
            ],
            [
                'name' => 'Central African Republic',
                'code' => 'CF',
                'phone_code' => '+236',
                'translation' => [
                    'ar' => 'جمهورية أفريقيا الوسطى',
                    'en' => 'Central African Republic',
                ],
            ],
            [
                'name' => 'Chad',
                'code' => 'TD',
                'phone_code' => '+235',
                'translation' => [
                    'ar' => 'تشاد',
                    'en' => 'Chad',
                ],
            ],
            [
                'name' => 'Chile',
                'code' => 'CL',
                'phone_code' => '+56',
                'translation' => [
                    'ar' => 'تشيلي',
                    'en' => 'Chile',
                ],
            ],
            [
                'name' => 'China',
                'code' => 'CN',
                'phone_code' => '+86',
                'translation' => [
                    'ar' => 'الصين',
                    'en' => 'China',
                ],
            ],
            [
                'name' => 'Colombia',
                'code' => 'CO',
                'phone_code' => '+57',
                'translation' => [
                    'ar' => 'كولومبيا',
                    'en' => 'Colombia',
                ],
            ],
            [
                'name' => 'Comoros',
                'code' => 'KM',
                'phone_code' => '+269',
                'translation' => [
                    'ar' => 'جزر القمر',
                    'en' => 'Comoros',
                ],
            ],
            [
                'name' => 'Congo',
                'code' => 'CG',
                'phone_code' => '+242',
                'translation' => [
                    'ar' => 'الكونغو',
                    'en' => 'Congo',
                ],
            ],
            [
                'name' => 'Costa Rica',
                'code' => 'CR',
                'phone_code' => '+506',
                'translation' => [
                    'ar' => 'كوستاريكا',
                    'en' => 'Costa Rica',
                ],
            ],
            [
                'name' => 'Croatia',
                'code' => 'HR',
                'phone_code' => '+385',
                'translation' => [
                    'ar' => 'كرواتيا',
                    'en' => 'Croatia',
                ],
            ],
            [
                'name' => 'Cuba',
                'code' => 'CU',
                'phone_code' => '+53',
                'translation' => [
                    'ar' => 'كوبا',
                    'en' => 'Cuba',
                ],
            ],
            [
                'name' => 'Cyprus',
                'code' => 'CY',
                'phone_code' => '+357',
                'translation' => [
                    'ar' => 'قبرص',
                    'en' => 'Cyprus',
                ],
            ],
            [
                'name' => 'Czech Republic',
                'code' => 'CZ',
                'phone_code' => '+420',
                'translation' => [
                    'ar' => 'جمهورية التشيك',
                    'en' => 'Czech Republic',
                ],
            ],
            [
                'name' => 'Denmark',
                'code' => 'DK',
                'phone_code' => '+45',
                'translation' => [
                    'ar' => 'الدنمارك',
                    'en' => 'Denmark',
                ],
            ],
            [
                'name' => 'Djibouti',
                'code' => 'DJ',
                'phone_code' => '+253',
                'translation' => [
                    'ar' => 'جيبوتي',
                    'en' => 'Djibouti',
                ],
            ],
            [
                'name' => 'Dominica',
                'code' => 'DM',
                'phone_code' => '+1-767',
                'translation' => [
                    'ar' => 'دومينيكا',
                    'en' => 'Dominica',
                ],
            ],
            [
                'name' => 'Dominican Republic',
                'code' => 'DO',
                'phone_code' => '+1-809, +1-829, +1-849',
                'translation' => [
                    'ar' => 'جمهورية الدومينيكان',
                    'en' => 'Dominican Republic',
                ],
            ],
            [
                'name' => 'Ecuador',
                'code' => 'EC',
                'phone_code' => '+593',
                'translation' => [
                    'ar' => 'الإكوادور',
                    'en' => 'Ecuador',
                ],
            ],
            [
                'name' => 'Egypt',
                'code' => 'EG',
                'phone_code' => '+20',
                'translation' => [
                    'ar' => 'مصر',
                    'en' => 'Egypt',
                ],
            ],
            [
                'name' => 'El Salvador',
                'code' => 'SV',
                'phone_code' => '+503',
                'translation' => [
                    'ar' => 'السلفادور',
                    'en' => 'El Salvador',
                ],
            ],
            [
                'name' => 'Equatorial Guinea',
                'code' => 'GQ',
                'phone_code' => '+240',
                'translation' => [
                    'ar' => 'غينيا الاستوائية',
                    'en' => 'Equatorial Guinea',
                ],
            ],
            [
                'name' => 'Eritrea',
                'code' => 'ER',
                'phone_code' => '+291',
                'translation' => [
                    'ar' => 'إريتريا',
                    'en' => 'Eritrea',
                ],
            ],
            [
                'name' => 'Estonia',
                'code' => 'EE',
                'phone_code' => '+372',
                'translation' => [
                    'ar' => 'إستونيا',
                    'en' => 'Estonia',
                ],
            ],
            [
                'name' => 'Eswatini',
                'code' => 'SZ',
                'phone_code' => '+268',
                'translation' => [
                    'ar' => 'إسواتيني',
                    'en' => 'Eswatini',
                ],
            ],
            [
                'name' => 'Ethiopia',
                'code' => 'ET',
                'phone_code' => '+251',
                'translation' => [
                    'ar' => 'إثيوبيا',
                    'en' => 'Ethiopia',
                ],
            ],
            [
                'name' => 'Fiji',
                'code' => 'FJ',
                'phone_code' => '+679',
                'translation' => [
                    'ar' => 'فيجي',
                    'en' => 'Fiji',
                ],
            ],
            [
                'name' => 'Finland',
                'code' => 'FI',
                'phone_code' => '+358',
                'translation' => [
                    'ar' => 'فنلندا',
                    'en' => 'Finland',
                ],
            ],
            [
                'name' => 'France',
                'code' => 'FR',
                'phone_code' => '+33',
                'translation' => [
                    'ar' => 'فرنسا',
                    'en' => 'France',
                ],
            ],
            [
                'name' => 'Gabon',
                'code' => 'GA',
                'phone_code' => '+241',
                'translation' => [
                    'ar' => 'الغابون',
                    'en' => 'Gabon',
                ],
            ],
            [
                'name' => 'Gambia',
                'code' => 'GM',
                'phone_code' => '+220',
                'translation' => [
                    'ar' => 'غامبيا',
                    'en' => 'Gambia',
                ],
            ],
            [
                'name' => 'Georgia',
                'code' => 'GE',
                'phone_code' => '+995',
                'translation' => [
                    'ar' => 'جورجيا',
                    'en' => 'Georgia',
                ],
            ],
            [
                'name' => 'Germany',
                'code' => 'DE',
                'phone_code' => '+49',
                'translation' => [
                    'ar' => 'ألمانيا',
                    'en' => 'Germany',
                ],
            ],
            [
                'name' => 'Ghana',
                'code' => 'GH',
                'phone_code' => '+233',
                'translation' => [
                    'ar' => 'غانا',
                    'en' => 'Ghana',
                ],
            ],
            [
                'name' => 'Greece',
                'code' => 'GR',
                'phone_code' => '+30',
                'translation' => [
                    'ar' => 'اليونان',
                    'en' => 'Greece',
                ],
            ],
            [
                'name' => 'Grenada',
                'code' => 'GD',
                'phone_code' => '+1-473',
                'translation' => [
                    'ar' => 'غرينادا',
                    'en' => 'Grenada',
                ],
            ],
            [
                'name' => 'Guatemala',
                'code' => 'GT',
                'phone_code' => '+502',
                'translation' => [
                    'ar' => 'غواتيمالا',
                    'en' => 'Guatemala',
                ],
            ],
            [
                'name' => 'Guinea',
                'code' => 'GN',
                'phone_code' => '+224',
                'translation' => [
                    'ar' => 'غينيا',
                    'en' => 'Guinea',
                ],
            ],
            [
                'name' => 'Guinea-Bissau',
                'code' => 'GW',
                'phone_code' => '+245',
                'translation' => [
                    'ar' => 'غينيا بيساو',
                    'en' => 'Guinea-Bissau',
                ],
            ],
            [
                'name' => 'Guyana',
                'code' => 'GY',
                'phone_code' => '+592',
                'translation' => [
                    'ar' => 'غيانا',
                    'en' => 'Guyana',
                ],
            ],
            [
                'name' => 'Haiti',
                'code' => 'HT',
                'phone_code' => '+509',
                'translation' => [
                    'ar' => 'هايتي',
                    'en' => 'Haiti',
                ],
            ],
            [
                'name' => 'Honduras',
                'code' => 'HN',
                'phone_code' => '+504',
                'translation' => [
                    'ar' => 'هندوراس',
                    'en' => 'Honduras',
                ],
            ],
            [
                'name' => 'Hungary',
                'code' => 'HU',
                'phone_code' => '+36',
                'translation' => [
                    'ar' => 'المجر',
                    'en' => 'Hungary',
                ],
            ],
            [
                'name' => 'Iceland',
                'code' => 'IS',
                'phone_code' => '+354',
                'translation' => [
                    'ar' => 'آيسلندا',
                    'en' => 'Iceland',
                ],
            ],
            [
                'name' => 'India',
                'code' => 'IN',
                'phone_code' => '+91',
                'translation' => [
                    'ar' => 'الهند',
                    'en' => 'India',
                ],
            ],
            [
                'name' => 'Indonesia',
                'code' => 'ID',
                'phone_code' => '+62',
                'translation' => [
                    'ar' => 'إندونيسيا',
                    'en' => 'Indonesia',
                ],
            ],
            [
                'name' => 'Syria',
                'code' => 'SY',
                'phone_code' => '+963',
                'translation' => [
                    'ar' => 'سوريا',
                    'en' => 'Syria',
                ],
            ],
        ];

        foreach ($countries as $country) {
            Country::updateOrCreate(
                ['code' => $country['code']],
                [
                    'id' => Str::uuid(),
                    'code' => $country['code'],
                    'translation' => json_encode($country['translation'], JSON_UNESCAPED_UNICODE),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'name' => $country['name'],
                    'phone_code' => $country['phone_code'],
                ]
            );
        }
    }
}
