<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_create_user(): void
    {
        $user = [
            'name' => 'Ester',
            'email' => 'example@example.com',
            'password' => 'PasswordSecret'
        ];
        
        $response = $this->post('/api/register', $user);
        $response->assertStatus(200);
        $this->assertDatabaseHas('user', ['email' => 'example@example.com']);

    
    }
}

