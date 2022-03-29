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


    /**
     * @dataProvider invalidUserProvider
     */
    public function test_invalid_users_registration($user)
    {
        $this
            ->postJson(  'api/register-user',$user)
            ->assertUnprocessable();
    }

    public function invalidUserProvider (): array
    {
        return [
            ['empty name' =>
            [
                'email' => 'juan@juan.com',
                'password' => '1234Juan.'
            ]],
            ['empty name' =>
            [
                'name' => 'juan',
                'password' => '1234Juan.'
            ]],
            ['empty password' =>
            [
                'name' => 'juan',
                'email' => 'juan@juan.com',
            ]],
            ['name too short' =>
            [
                'name' => 'ju',
                'email' => 'juan@juan.com',
                'password' => '1234Juan.'
            ]],
            ['password too short' =>
            [
                'name' => 'juan',
                'email' => 'juan@juan.com',
                'password' => '123'
            ]
            ],
            ['name too long' =>
            [
                'name' => 'juan rodriguez zlotejablko',
                'email' => 'juan@juan.com',
                'password' => '1234Juan.'
            ]],
            ['email too long' =>
                [
                    'name' => 'juan ',
                    'email' => 'juan_rodriguez_zlotejablko@juan.com',
                    'password' => '1234Juan.'
                ]],
            ['invalid email' =>
            [
                'name' => 'juan ',
                'email' => 'juan@juan',
                'password' => '1234Juan.'
            ]]

        ];
    }
}
