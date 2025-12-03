<?php

use App\Models\User;
use App\Models\EncryptedValue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->withoutMiddleware(\Illuminate\Routing\Middleware\ThrottleRequests::class);
});

/**
 * ----------------------------------------------------------------
 * REGISTER TESTS
 * ----------------------------------------------------------------
 */

it('registers a user successfully', function () {

    // Sanctum session requires csrf cookie before POST
    $this->get('/sanctum/csrf-cookie');

    $payload = [
        'name' => 'Test User',
        'phone' => '09999999999',
        'password' => '123456',
        'nrc_number' => '12/KaMaNa(N)123456',
        'address' => 'Yangon, Myanmar',
        'nrc_front_image' => UploadedFile::fake()->image('front.jpg'),
        'nrc_back_image' => UploadedFile::fake()->image('back.jpg'),
    ];

    $response = $this->post('/api/v1/auth/register', $payload);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Registered successfully',
        ])
        ->assertJsonStructure([
            'data' => [
                'user' => ['id', 'name', 'phone']
            ]
        ]);

    // Verify user stored
    $user = User::where('phone', '09999999999')->first();
    expect($user)->not()->toBeNull();
    expect($user->name)->toBe('Test User');

    // Verify encrypted values stored
    expect(EncryptedValue::where('user_id', $user->id)->count())->toBe(4);
});

/**
 * ----------------------------------------------------------------
 * LOGIN TESTS
 * ----------------------------------------------------------------
 */

it('logs in successfully with correct credentials', function () {
    $user = User::factory()->create([
        'phone' => '09987654321',
        'password' => bcrypt('111111'),
    ]);

    // This is required for session-based Sanctum login
    $this->get('/sanctum/csrf-cookie');

    $payload = [
        'phone' => '09987654321',
        'pin' => '111111',
    ];

    $response = $this->postJson('/api/v1/auth/login', $payload);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Login successfully',
        ]);

    $this->assertAuthenticated();
});



it('fails to login with wrong credentials', function () {
    $user = User::factory()->create([
        'phone' => '09911112222',
        'password' => bcrypt('123456'),
    ]);

    $this->get('/sanctum/csrf-cookie');

    $payload = [
        'phone' => '09911112222',
        'pin' => '111111',
    ];

    $response = $this->post('/api/v1/auth/login', $payload);

    $response->assertStatus(401)
        ->assertJson([
            'success' => false,
            'message' => 'Login failed',
        ]);

    $this->assertGuest();
});
