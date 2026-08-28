<?php

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders the homepage with contact form', function () {
    $this->get('/id/')
        ->assertOk()
        ->assertSee('Hubungi Kami')
        ->assertSee('Kirim Pesan');
});

it('validates contact form required fields', function () {
    $this->post('/id/kontak', [])->assertSessionHasErrors(['name', 'message']);
});

it('stores a valid contact message', function () {
    $this->post('/id/kontak', [
        'name' => 'Budi',
        'email' => 'budi@example.com',
        'subject' => 'Test',
        'message' => 'Halo, saya ingin bertanya.',
    ])->assertRedirect();

    expect(ContactMessage::count())->toBe(1);
    expect(ContactMessage::first()->name)->toBe('Budi');
});
