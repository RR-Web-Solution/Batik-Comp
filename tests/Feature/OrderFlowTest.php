<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('validates required fields when storing an order', function () {
    $this->post(route('order.store'), [])
        ->assertSessionHasErrors(['product_id', 'quantity', 'customer_name', 'customer_phone']);
});

it('creates an order with the computed total', function () {
    $product = Product::factory()->create(['price' => 100000]);

    $response = $this->post(route('order.store'), [
        'product_id' => $product->id,
        'quantity' => 2,
        'notes' => 'Tolong dibungkus kado',
        'customer_name' => 'Budi Santoso',
        'customer_phone' => '081234567890',
    ]);

    $order = Order::first();

    expect($order)->not->toBeNull()
        ->and($order->status)->toBe('menunggu')
        ->and((int) $order->total)->toBe(200000)
        ->and($order->order_number)->toStartWith('ORD-'.now()->format('ymd'));

    $response->assertRedirect(route('order.success', ['orderNumber' => $order->order_number]));
});

it('prevents duplicate orders within five minutes', function () {
    $product = Product::factory()->create(['price' => 50000]);

    $payload = [
        'product_id' => $product->id,
        'quantity' => 1,
        'customer_name' => 'Dewi Lestari',
        'customer_phone' => '081298765432',
    ];

    $this->post(route('order.store'), $payload);
    $existing = Order::first();

    $this->post(route('order.store'), $payload)
        ->assertRedirect(route('order.success', ['orderNumber' => $existing->order_number]));

    expect(Order::count())->toBe(1);
});

it('finds an order on the track page', function () {
    Setting::create([
        'site_name' => 'Batik Nusantara',
        'whatsapp_number' => '6281234567890',
    ]);

    $order = Order::factory()->create(['status' => 'diproses']);

    $this->get(route('order.track', ['order_number' => $order->order_number]))
        ->assertOk()
        ->assertSee($order->order_number)
        ->assertSee($order->product->name);
});

it('shows a not found alert on the track page', function () {
    $this->get(route('order.track', ['order_number' => 'ORD-999999999']))
        ->assertOk()
        ->assertSee('tidak ditemukan');
});
