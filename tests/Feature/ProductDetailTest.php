<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders the product detail page', function () {
    $category = Category::factory()->create();
    $product = Product::factory()->inCategory($category)->create(['is_featured' => true]);

    $this->get("/id/produk/{$product->id}")
        ->assertOk()
        ->assertSee($product->name)
        ->assertSee($product->price);
});

it('returns 404 for a non-existent product', function () {
    $this->get('/id/produk/99999')->assertStatus(404);
});

it('renders the product index page', function () {
    $this->get('/id/products')->assertOk();
});
