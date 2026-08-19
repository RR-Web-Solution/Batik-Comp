<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'site_name' => 'Batik Nusantara',
            'tagline' => 'Rumah batik artisanal untuk setiap momen berharga.',
            'whatsapp_number' => '6281234567890',
            'email' => 'hello@batiknusantara.id',
            'address' => 'Jl. Batik Nusantara No. 8, Jakarta Selatan',
            'opening_hours' => 'Senin - Sabtu, 09.00 - 17.00 WIB',
            'about_text' => 'Batik Nusantara berawal dari kecintaan sederhana terhadap warisan budaya Indonesia. Berdiri sejak tahun 2018, kami telah berkembang dari sebuah rumah produksi kecil menjadi rumah batik artisanal yang dipercaya oleh para pecinta batik.',
            'instagram_usn' => 'batiknusantara',
            'facebook_usn' => 'batiknusantara',
        ];

        Setting::firstOrCreate($settings);
    }
}
