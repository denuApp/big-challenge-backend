<?php

namespace Tests\Feature\Authentication;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogoutUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_logout_user()
    {
        $this->withoutExceptionHandling();

        Sanctum::actingAs(User::factory()->create());

        $this
            ->postJson('api/logout-user')
            ->assertSuccessful();
    }

    public function test_logout_user_without_login_in()
    {
        $this
            ->postJson('api/logout-user')
            ->assertUnauthorized();
    }
}
