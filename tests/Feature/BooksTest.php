<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BooksTest extends TestCase
{
    private $token;

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

        $user = [
            'name' => 'user_example',
            'email' => 'user@gmail.com',
            'password' => 'user123',
            'password_confirmation' => 'user123',
        ];

        //login with data_super_admin
        $response = $this->post('/api/register', $user);

        // get token super admin
        $this->token = $response['token'];
    }

    public function tearDown(): void
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }

    public function test_create_book_return_book() {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->post('/api/books', [
            'title' => 'Test Title',
            'description' => 'description example',
        ]);

        $response->assertStatus(201);

    }
}
