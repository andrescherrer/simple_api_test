<?php

use App\Models\Client;

it('cria um cliente com os atributos corretos', function () {
    $client = new Client([
        'name' => 'João da Silva',
        'email' => 'joao@example.com',
    ]);

    expect($client->name)->toBe('João da Silva');
    expect($client->email)->toBe('joao@example.com');
});

it('usa a trait HasFactory', function () {
    $uses = class_uses(Client::class);

    expect($uses)->toContain(\Illuminate\Database\Eloquent\Factories\HasFactory::class);
});
