<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/en/profile');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/en/profile', [
                'firstname' => 'Test',
                'lastname' => 'User',
                'username' => 'new_unique_username',
                'email' => 'test@example.com',
                'daily_target' => 5,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/en/profile');

        $user->refresh();

        $this->assertSame('Test', $user->firstname);
        $this->assertSame('new_unique_username', $user->username);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/en/profile', [
                'firstname' => 'Test',
                'lastname' => 'User',
                'username' => 'another_unique_username',
                'email' => $user->email,
                'daily_target' => 5,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/en/profile');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/en/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/en/profile')
            ->delete('/en/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect('/en/profile');

        $this->assertNotNull($user->fresh());
    }
}
