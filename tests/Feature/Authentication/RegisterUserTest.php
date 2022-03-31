<?php

namespace Tests\Authentication\Feature;

use Database\Seeders\UserPermissionsSeeder;
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

        $this->seed(UserPermissionsSeeder::class);

        $name = 'juan';
        $email = 'juan@juan.com';
        $password = '1234Juan.';
        $roles = 'doctor';

        $this
            ->postJson(
                'api/register-user',
                [
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                    'roles' => $roles,
                ]
            )
            ->assertSuccessful()
            ->assertJsonCount(1, 'data.roles');

        $this
            ->assertDatabaseHas('users', [
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ]);
    }

    /**
     * @dataProvider invalidUserProvider
     */
    public function test_invalid_users_registration($user)
    {
        $this
            ->postJson('api/register-user', $user)
            ->assertUnprocessable();
    }

    public function invalidUserProvider(): array
    {
        return [
            ['empty name' => [
                'email' => 'juan@juan.com',
                'password' => '1234Juan.',
                'roles' => 'patient',
            ]],
            ['empty email' => [
                'name' => 'juan',
                'password' => '1234Juan.',
                'roles' => 'patient',
            ]],
            ['empty password' => [
                'name' => 'juan',
                'email' => 'juan@juan.com',
                'roles' => 'patient',
            ]],
            ['empty roles' => [
                'name' => 'juan',
                'email' => 'juan@juan.com',
                'password' => '1234Juan.',
            ]],
            ['name too short' => [
                'name' => 'ju',
                'email' => 'juan@juan.com',
                'password' => '1234Juan.',
                'roles' => 'patient',
            ]],
            ['password too short' => [
                'name' => 'juan',
                'email' => 'juan@juan.com',
                'password' => '123',
                'roles' => 'patient',
            ]],
            ['name too long' => [
                'name' => 'juan rodriguez zlotejablko',
                'email' => 'juan@juan.com',
                'password' => '1234Juan.',
                'roles' => 'patient',
            ]],
            ['email too long' => [
                'name' => 'juan ',
                'email' => 'juan_rodriguez_zlotejablko@juan.com',
                'password' => '1234Juan.',
                'roles' => 'patient',
            ]],
            ['invalid email' => [
                'name' => 'juan ',
                'email' => 'juan@juan',
                'password' => '1234Juan.',
                'roles' => 'patient',
            ]],
            ['invalid roles' => [
                'name' => 'juan ',
                'email' => 'juan@juan.com',
                'password' => '1234Juan.',
                'roles' => 'writer',
            ]],

        ];
    }
}
