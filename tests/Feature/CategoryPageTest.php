<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows the products belonging to a category', function () {
    Setting::create([
        'site_name' => 'Batik Nusantara',
        'whatsapp_number' => '6281234567890',
    ]);

    $category = Category::factory()->create(['name' => 'Batik Tulis']);
    $product = Product::factory()->inCategory($category)->create(['name' => 'Batik Parang Unik']);

    $this->get(route('category.show', $category->slug))
        ->assertOk()
        ->assertSee('Batik Tulis')
        ->assertSee('Batik Parang Unik');
});

it('does not show products from other categories', function () {
    $category = Category::factory()->create(['name' => 'Batik Cap']);
    $other = Category::factory()->create(['name' => 'Kain & Pakaian']);
    Product::factory()->inCategory($category)->create(['name' => 'Batik Cap Modern']);
    Product::factory()->inCategory($other)->create(['name' => 'Kemeja Batik Dewasa']);

    $this->get(route('category.show', $category->slug))
        ->assertOk()
        ->assertSee('Batik Cap Modern')
        ->assertDontSee('Kemeja Batik Dewasa');
});
