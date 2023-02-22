<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;


class TestUser extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate --seed');
    }

    public function tearDown(): void
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }

    /** @test */
    public function test_register_return_access_token()
    {
        $dataUser = [
            'name' => 'nameexample',
            'email' => 'example@email.com',
            'password' => 'examplepassword',
            'password_confirmation' => 'examplepassword',
        ];

        $response = $this->post('/api/register', $dataUser);

        $response->assertStatus(201);

        $response->assertJsonStructure(['token']);

        $this->assertDatabaseHas('users', [
            'name' => 'nameexample',
            'email' => 'example@email.com',
        ]);
    }


}
