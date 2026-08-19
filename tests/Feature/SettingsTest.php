<?php

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('redirects guests away from the settings pages', function () {
    $setting = Setting::create([
        'site_name' => 'Batik Nusantara',
        'whatsapp_number' => '6281234567890',
    ]);

    $this->get(route('setting'))->assertRedirect('/admin');

    $this->put(route('setting.update', $setting->id), [
        'site_name' => 'Batik Nusantara Baru',
        'whatsapp_number' => '6281234567890',
    ])->assertRedirect('/admin');
});

it('updates the site settings', function () {
    $admin = User::factory()->create();
    $setting = Setting::create([
        'site_name' => 'Batik Nusantara',
        'whatsapp_number' => '6281234567890',
    ]);

    $this->actingAs($admin)
        ->put(route('setting.update', $setting->id), [
            'site_name' => 'Batik Nusantara Baru',
            'tagline' => 'Tagline baru',
            'whatsapp_number' => '6289876543210',
            'email' => 'baru@batiknusantara.id',
            'address' => 'Jl. Uji Coba No. 1',
            'opening_hours' => 'Senin - Sabtu, 09.00 - 17.00 WIB',
            'instagram_usn' => 'batikbaru',
            'facebook_usn' => 'batikbaru',
        ])
        ->assertRedirect();

    expect($setting->fresh())
        ->site_name->toBe('Batik Nusantara Baru')
        ->whatsapp_number->toBe('6289876543210')
        ->email->toBe('baru@batiknusantara.id');
});
