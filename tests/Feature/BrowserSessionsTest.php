<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\LogoutOtherBrowserSessionsForm;
use Livewire\Livewire;
use Tests\TestCase;

class BrowserSessionsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->withSession(['_token' => 'test-token']);
        config(['session.driver' => 'array']);
    }

    public function test_other_browser_sessions_can_be_logged_out(): void
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create([
            'password' => bcrypt('password')
        ]);
        $this->actingAs($user)
            ->withSession(['auth.password_confirmed_at' => time()]);
        Livewire::test(LogoutOtherBrowserSessionsForm::class)
            ->set('password', 'password')
            ->call('logoutOtherBrowserSessions')
            ->assertSuccessful();
    }

}
