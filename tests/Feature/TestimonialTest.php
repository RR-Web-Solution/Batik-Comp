<?php

use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows active testimonials on homepage', function () {
    Testimonial::create([
        'customer_name' => 'Andi',
        'content' => 'Batiknya bagus sekali.',
        'rating' => 5,
        'is_active' => true,
    ]);

    $this->get('/id/')->assertOk()->assertSee('Andi');
});

it('does not show inactive testimonials on homepage', function () {
    Testimonial::create([
        'customer_name' => 'Hidden',
        'content' => 'Tidak terlihat.',
        'rating' => 3,
        'is_active' => false,
    ]);

    $this->get('/id/')->assertOk()->assertDontSee('Hidden');
});

it('lets admin access testimonials page', function () {
    $admin = User::factory()->create();

    $this->actingAs($admin)->get('/testimonial')->assertOk();
});
