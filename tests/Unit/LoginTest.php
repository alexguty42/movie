<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Movie;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{

    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_get_user_details()
{
    $user = User::factory()->create();

    $token = $user->createToken('Test Token')->plainTextToken;

    Sanctum::actingAs($user, ['*']);

    $response = $this->get('/api/user');

    $response->assertStatus(200);

    $response->assertJson([
        'name' => $user->name,
        'email' => $user->email,
    ]);
}
}
