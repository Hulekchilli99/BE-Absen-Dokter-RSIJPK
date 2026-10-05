<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_login_returns_token_and_user_for_valid_credentials(): void
    {
        $user = User::factory()->create([
            'no_pegawai' => '123456',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson(route('api.login'), [
            'no_pegawai' => '123456',
            'password' => 'password123',
        ]);

        $response->assertOk()
            ->assertJsonPath('message', 'Login berhasil.')
            ->assertJsonStructure(['token', 'user' => ['id', 'name', 'no_pegawai', 'email']]);

        $this->assertNotNull($user->fresh()->api_token);
    }

    public function test_api_login_fails_with_invalid_credentials(): void
    {
        User::factory()->create([
            'no_pegawai' => '123456',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson(route('api.login'), [
            'no_pegawai' => '123456',
            'password' => 'wrong-pass',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('no_pegawai');
    }

    public function test_api_protected_routes_reject_unauthenticated_requests(): void
    {
        $this->getJson(route('api.dashboard'))->assertStatus(401);
        $this->getJson(route('api.attendances.index'))->assertStatus(401);
        $this->postJson(route('api.doctors.store'), ['name' => 'Dokter Test'])->assertStatus(401);
    }

    public function test_api_protected_routes_allow_authenticated_requests_with_bearer_token(): void
    {
        $user = User::factory()->create([
            'api_token' => 'sample-test-token-123',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer sample-test-token-123')
            ->getJson(route('api.me'));

        $response->assertOk()
            ->assertJsonPath('data.id', $user->id)
            ->assertJsonPath('data.no_pegawai', $user->no_pegawai);

        $dashResponse = $this->withHeader('Authorization', 'Bearer sample-test-token-123')
            ->getJson(route('api.dashboard'));

        $dashResponse->assertOk();
    }

    public function test_api_logout_clears_token(): void
    {
        $user = User::factory()->create([
            'api_token' => 'sample-test-token-123',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer sample-test-token-123')
            ->postJson(route('api.logout'));

        $response->assertOk()
            ->assertJsonPath('message', 'Logout berhasil.');

        $this->assertNull($user->fresh()->api_token);
    }

    public function test_public_routes_remain_accessible_without_token(): void
    {
        Doctor::factory()->create(['is_active' => true]);

        $this->getJson(route('api.doctors.index'))->assertOk();
    }
}
