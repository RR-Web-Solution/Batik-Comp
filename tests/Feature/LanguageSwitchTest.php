<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('redirects root to Indonesian locale', function () {
    $this->get('/')->assertRedirect('/id');
});

it('renders the homepage in Indonesian', function () {
    $this->get('/id/')
        ->assertOk()
        ->assertSee('Seni Membatik');
});

it('renders the homepage in English', function () {
    $this->get('/en/')
        ->assertOk()
        ->assertSee('Art');
});

it('includes a language switcher', function () {
    $this->get('/id/')
        ->assertOk()
        ->assertSee('English')
        ->assertSee('Bahasa Indonesia');
});
