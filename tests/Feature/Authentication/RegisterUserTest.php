<?php

namespace Tests\Authentication\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_controller_register_user_correctly()
    {
        $this->withoutExceptionHandling();

        $name = 'juan';
        $email = 'juan@juan.com';
        $password = '1234Juan.';

        $this
            ->postJson(
                'api/register-user',
                [
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                ]
            )
            ->assertSuccessful();
    }

    public function test_the_controller_register_user_correctly_without_name()
    {
        $this->withoutExceptionHandling();

        $name = 'juan';
        $email = 'juan@juan.com';
        $password = '1234Juan.';

        $this
            ->postJson(
                'api/register-user',
                [
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                ]
            )
            ->assertSuccessful();

        $this
            ->assertDatabaseHas('users', [
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ]);
    }

    
}
