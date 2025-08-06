<?php

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('retorna status da API', function () {
    $this->getJson('/api/status')
         ->assertOk()
         ->assertJson([
             'status' => 'OK',
             'message' => 'API is running OK!',
         ]);
});

it('retorna lista de clientes paginada', function () {
    Client::factory()->count(15)->create();

    $this->getJson('/api/clients')
         ->assertOk()
         ->assertJsonStructure([
             'status',
             'message',
             'data' => [
                 'data',
                 'links',
                 'current_page',
                 'first_page_url',
                 'last_page_url',
                 'total',
             ],
         ]);
});

it('retorna cliente por ID', function () {
    $client = Client::factory()->create();

    $this->getJson("/api/client-by-id/{$client->id}")
         ->assertOk()
         ->assertJson([
             'data' => [
                 'id' => $client->id,
                 'name' => $client->name,
                 'email' => $client->email,
             ]
         ]);
});

it('retorna erro ao buscar cliente sem ID no corpo da requisição', function () {
    $this->postJson('/api/client', [])
         ->assertStatus(400)
         ->assertJson([
             'status' => 'error',
             'message' => 'Client ID is required',
         ]);
});

it('retorna cliente por ID via POST', function () {
    $client = Client::factory()->create();

    $this->postJson('/api/client', ['id' => $client->id])
         ->assertOk()
         ->assertJson([
             'data' => [
                 'id' => $client->id,
                 'name' => $client->name,
                 'email' => $client->email,
             ]
         ]);
});

it('cria um novo cliente', function () {
    $data = ['name' => 'André Scherrer', 'email' => 'andre@example.com'];

    $this->postJson('/api/add-client', $data)
         ->assertCreated()
         ->assertJson([
             'status' => 'OK',
             'message' => 'success',
             'data' => [
                 'name' => $data['name'],
                 'email' => $data['email'],
             ]
         ]);

    $this->assertDatabaseHas('clients', $data);
});

it('atualiza um cliente existente', function () {
    $client = Client::factory()->create();

    $this->putJson('/api/update-client', [
        'id' => $client->id,
        'name' => 'Novo Nome',
        'email' => 'novo@email.com'
    ])
    ->assertOk()
    ->assertJson([
        'data' => [
            'name' => 'Novo Nome',
            'email' => 'novo@email.com',
        ]
    ]);

    $this->assertDatabaseHas('clients', [
        'id' => $client->id,
        'name' => 'Novo Nome',
        'email' => 'novo@email.com'
    ]);
});

it('deleta um cliente', function () {
    $client = Client::factory()->create();

    $this->deleteJson("/api/delete-client/{$client->id}")
         ->assertOk()
         ->assertJson([
             'status' => 'OK',
             'message' => 'success',
         ]);

    $this->assertDatabaseMissing('clients', ['id' => $client->id]);
});
