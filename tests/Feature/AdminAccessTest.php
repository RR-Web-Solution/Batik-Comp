<?php

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('redirects guests to the login page for admin routes', function (string $route) {
    $this->get($route)->assertRedirect('/admin');
})->with([
    '/dashboard',
    '/user',
    '/product',
    '/order',
    '/category',
    '/setting',
    '/testimonial',
]);

it('lets an authenticated admin open admin pages', function () {
    $admin = User::factory()->create();

    $this->actingAs($admin)
        ->get('/dashboard')
        ->assertOk();
});

it('lets an authenticated admin update an order status', function () {
    $admin = User::factory()->create();
    $order = Order::factory()->create(['status' => 'baru']);

    $this->actingAs($admin)
        ->patch(route('order.update', $order->id), ['status' => 'selesai'])
        ->assertRedirect();

    expect($order->fresh()->status)->toBe('selesai');
});

it('rejects an invalid order status', function () {
    $admin = User::factory()->create();
    $order = Order::factory()->create();

    $this->actingAs($admin)
        ->patch(route('order.update', $order->id), ['status' => 'batal'])
        ->assertSessionHasErrors(['status']);
});
