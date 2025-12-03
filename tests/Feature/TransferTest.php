<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows authenticated user to transfer money', function () {
    $sender = User::factory()->create([
        'balance' => 2000,
        'name' => 'Phone Htut Khaung',
    ]);

    $receiver = User::factory()->create([
        'balance' => 500,
        'name' => 'Test User',
    ]);

    \Pest\Laravel\actingAs($sender, 'sanctum');

    $payload = [
        'receiver_id' => $receiver->id,
        'amount' => 1000,
        'note' => 'Testing',
    ];

    $response = $this->postJson('/api/v1/payment/transfer', $payload);

    $response->assertStatus(200)
        ->assertJson(fn ($json) =>
        $json->where('success', true)
            ->where('message', 'Transfer success.')
            ->where('data.sender', 'Phone Htut Khaung')
            ->where('data.receiver', 'Test User')
            ->where('data.note', 'Testing')
            ->has('data.transaction.user_id')
            ->has('data.transaction.type')
            ->has('data.transaction.amount')
            ->has('data.transaction.reference_no')
            ->has('data.transaction.related_id')
            ->has('data.transaction.status')
        );

    expect((float) $sender->fresh()->balance)->toBe(1000.0);
    expect((float) $receiver->fresh()->balance)->toBe(1500.0);
});

it('fails if receiver not found', function () {
    $sender = User::factory()->create();
    \Pest\Laravel\actingAs($sender, 'sanctum');

    $payload = [
        'receiver_id' => 999999,
        'amount' => 1000, // must satisfy validation
        'note' => 'Test',
    ];

    $response = $this->postJson('/api/v1/payment/transfer', $payload);

    $response->assertStatus(404)
        ->assertJson([
            'success' => false,
            'message' => 'Receiver not found.',
        ]);
});

it('does not allow unauthenticated users to transfer', function () {
    $receiver = User::factory()->create();

    $payload = [
        'receiver_id' => $receiver->id,
        'amount' => 1000,
        'note' => 'Test',
    ];

    // First, hit the csrf-cookie endpoint
    $this->get('/sanctum/csrf-cookie');

    // Then make the POST request
    $response = $this->postJson('/api/v1/payment/transfer', $payload);

    $response->assertStatus(401); // now this will pass
});

