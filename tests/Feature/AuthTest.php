<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_me_kredenciale_te_sakta(): void
    {
        $this->createAdmin();

        $response = $this->postJson('/api/login', [
            'PERD_EMAIL'   => 'testadmin@uni.edu.al',
            'PERD_FJKALIM' => 'password123',
        ]);

        $response->assertStatus(200)->assertJsonStructure(['data' => ['token', 'user']]);
    }

    public function test_login_me_kredenciale_te_gabuara(): void
    {
        $response = $this->postJson('/api/login', [
            'PERD_EMAIL'   => 'nobody@uni.edu.al',
            'PERD_FJKALIM' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
    }

    public function test_login_pa_email(): void
    {
        $response = $this->postJson('/api/login', [
            'PERD_FJKALIM' => 'password123',
        ]);

        $response->assertStatus(422);
    }

    public function test_login_pa_fjkalim(): void
    {
        $response = $this->postJson('/api/login', [
            'PERD_EMAIL' => 'testadmin@uni.edu.al',
        ]);

        $response->assertStatus(422);
    }
}
