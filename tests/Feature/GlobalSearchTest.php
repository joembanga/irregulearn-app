<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Verb;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class GlobalSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_global_search_reproduction(): void
    {
        $user = User::factory()->create(['username' => 'searchable_user']);
        $anotherUser = User::factory()->create(['username' => 'other_user']);
        
        $verb = Verb::create([
            'infinitive' => 'go',
            'past_simple' => 'went',
            'past_participle' => 'gone',
            'slug' => 'go',
            'level' => 'beginner'
        ]);

        $this->actingAs($anotherUser);

        // Test if URL defaults are set by the middleware (running via actingAs and a request)
        // Or manually simulate middleware
        session(['locale' => 'fr']);
        app()->setLocale('fr');
        \Illuminate\Support\Facades\URL::defaults(['locale' => 'fr']);

        $generatedUrl = route('profile.public', ['user' => 'searchable_user']);
        $this->assertStringContainsString('/fr/u/searchable_user', $generatedUrl);

        // Try to reproduce the issue by verifying results
        Livewire::test(\App\Livewire\GlobalSearch::class)
            ->set('query', 'searchable')
            ->assertSet('results', function($results) {
                return count($results) > 0 && $results[0]['title'] === 'searchable_user';
            });
            
        Livewire::test(\App\Livewire\GlobalSearch::class)
            ->set('query', 'go')
            ->assertSet('results', function($results) {
                return count($results) > 0 && $results[0]['title'] === 'go';
            });
    }
}
