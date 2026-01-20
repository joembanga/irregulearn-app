<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Verb;
use App\Models\VerbExample;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SocialRoutesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test grambuds route accessibility and data.
     */
    public function test_grambuds_route_is_accessible()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/en/grambuds');

        $response->assertStatus(200);
        $response->assertViewIs('grambuds');
    }

    /**
     * Test sentences route accessibility and data.
     */
    public function test_sentences_route_is_accessible()
    {
        $user = User::factory()->create();
        $verb = Verb::factory()->create();
        VerbExample::create([
            'verb_id' => $verb->id,
            'user_id' => $user->id,
            'body' => 'Test sentence example for the verb.',
            'xp_given' => 10
        ]);

        $response = $this->actingAs($user)->get('/en/sentences');

        $response->assertStatus(200);
        $response->assertViewIs('sentences');
        $response->assertSee('Test sentence example');
    }

    /**
     * Test routes are protected by auth middleware.
     */
    public function test_social_routes_require_auth()
    {
        $response = $this->get('/en/grambuds');
        $response->assertRedirect('/en/login');

        $response = $this->get('/en/sentences');
        $response->assertRedirect('/en/login');
    }
}
