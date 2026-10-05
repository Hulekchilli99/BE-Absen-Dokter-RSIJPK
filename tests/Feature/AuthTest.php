<?php

namespace Tests\Feature;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_can_be_rendered(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk();
        $response->assertSeeText('Nomor Pegawai');
        $response->assertSeeText('Password');
        $response->assertSee('name="no_pegawai"', false);
        $response->assertSee('name="password"', false);
    }

    public function test_frontend_renders_profile_logo_button_linking_to_login_for_guests(): void
    {
        Doctor::factory()->create();

        $response = $this->get(route('frontend.attendance.create'));

        $response->assertOk();
        $response->assertSee('aria-label="Login Panel Admin"', false);
        $response->assertSee(route('login'), false);
        $response->assertDontSeeText('Panel Admin');
    }

    public function test_frontend_profile_logo_links_to_backend_for_authenticated_users(): void
    {
        Doctor::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('frontend.attendance.create'));

        $response->assertOk();
        $response->assertSee('aria-label="Panel Admin"', false);
        $response->assertSee(route('backend.dashboard'), false);
    }

    public function test_unauthenticated_user_cannot_access_backend_dashboard(): void
    {
        $response = $this->get(route('backend.dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_user_can_login_using_no_pegawai_and_password(): void
    {
        $user = User::factory()->create([
            'no_pegawai' => '123456',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('login.store'), [
            'no_pegawai' => '123456',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('backend.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_incorrect_password(): void
    {
        $user = User::factory()->create([
            'no_pegawai' => '123456',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->from(route('login'))->post(route('login.store'), [
            'no_pegawai' => '123456',
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('no_pegawai');
        $this->assertGuest();
    }

    public function test_user_cannot_login_with_non_existent_no_pegawai(): void
    {
        $response = $this->from(route('login'))->post(route('login.store'), [
            'no_pegawai' => '999999',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('no_pegawai');
        $this->assertGuest();
    }

    public function test_authenticated_user_is_redirected_away_from_login_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('login'));

        $response->assertRedirect(route('backend.dashboard'));
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('logout'));

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }
}
