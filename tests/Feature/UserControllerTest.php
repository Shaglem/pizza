<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_successfully()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
        ];

        $response = $this->postJson('api/v1/register', $data);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'User registered successfully.',
            ])
            ->assertJsonStructure(['token']);
    }

    public function test_user_cannot_register_with_invalid_data()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com'
        ];

        $response = $this->postJson('api/v1/register', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }

    public function test_user_can_login_successfully()
    {
        $user = User::factory()->create([
            'email' => 'john.doe@example.com',
            'password' => bcrypt('password123'),
        ]);

        $data = [
            'email' => $user->email,
            'password' => 'password123',
        ];

        $response = $this->postJson('api/v1/login', $data);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Login successful',
            ])
            ->assertJsonStructure(['token']);
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'john.doe@example.com',
            'password' => bcrypt('password123'),
        ]);

        $data = [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ];

        $response = $this->postJson('api/v1/login', $data);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Invalid credentials',
            ]);
    }
}
