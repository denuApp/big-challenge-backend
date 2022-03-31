<?php

namespace Tests\Authentication\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_of_an_user()
    {
//        $this->artisan('db:seed');

        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $this
            ->postJson('api/login-user', [
                'email' => $user['email'],
                'password' => '123456password',

            ])
            ->assertSuccessful();
    }

    /**
     * @dataProvider invalidLoginProvider
     */
    public function test_invalid_users_login($user)
    {
        User::factory()->create([
            'email' => 'good@email.com',
            'password' => '123password',
        ]);

        $this->postJson('api/login-user', [
            'email' => $user['email'],
            'password' => $user['password'],
            ])
            ->assertUnprocessable();
    }

    /**
     * @dataProvider invalidFormatLoginProvider
     */
    public function test_invalid_format_users_login($user)
    {
        $this
            ->postJson('api/login-user', $user)
            ->assertUnprocessable();
    }

    public function invalidLoginProvider(): array
    {
        return [

            ['incorrect email' => [
                'email' => 'wrong@email.com',
                'password' => '123password',
            ]],
            ['incorrect password' => [
                'email' => 'good@email.com',
                'password' => '123wrongpassword',
            ]],
        ];
    }

    public function invalidFormatLoginProvider(): array
    {
        return [
            ['incorrect email format' => [
                'email' => 'good@email',
                'password' => '123password',
            ]],
            ['incorrect password format' => [
                'email' => 'good@email.com',
                'password' => '123',
            ]],

        ];
    }
}
