<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserTest extends TestCase
{
    use WithoutMiddleware;
    /**
     * A basic unit test example.
     */
    public function test_returns_user(): void
    {
        $user = User::factory()->create();
        $response = $this->get("/api/search/{$user->id}");
        $response->assertSuccessful()
                 ->assertJson([
                    "id" => $user->id,
                    "name" => $user->name,
                    "email" => $user->email,
                 ]);
    }
}
