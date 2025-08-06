<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

/*
|--------------------------------------------------------------------------
| Global Traits for Tests
|--------------------------------------------------------------------------
|
| Aplica a trait RefreshDatabase para todas as classes dentro das pastas
| Feature e Unit. Isso garante que o banco será migrado e limpo a cada teste.
|
*/
uses(RefreshDatabase::class)->in('Feature', 'Unit');

/*
|--------------------------------------------------------------------------
| Custom TestCase Binding
|--------------------------------------------------------------------------
|
| Você pode configurar aqui para usar uma TestCase base personalizada.
| Se não for usar nada extra, pode manter assim.
|
*/
pest()->extend(Tests\TestCase::class)
    ->in('Feature', 'Unit'); // Aqui incluí Unit para manter padrão

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| Extensões customizadas para a API de expectativas do Pest.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Helper Functions
|--------------------------------------------------------------------------
|
| Funções globais auxiliares que você queira disponibilizar para todos testes.
|
*/

function something()
{
    // ..
}
