<?php

namespace Tests\Feature\Authentication;

use App\Models\User;
use Database\Seeders\UserPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SetPatientInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_setting_information_of_patient()
    {
        $this->withoutExceptionHandling();

        $this->seed(UserPermissionsSeeder::class);

        $patient = User::factory()->create();
        $patient->assignRole('patient');

        Sanctum::actingAs($patient);

        $id = 12345678;
        $gender = 'female';
        $birth = time();
        $height = 84;
        $weight = 105;

        $this
            ->postJson(
                'api/store-information',
                [
                    'patient_id' => $patient->id,
                    'id_number' => $id,
                    'gender' => $gender,
                    'birth_date' =>$birth,
                    'height' => $height,
                    'weight' => $weight,
                ]
            )
            ->assertSuccessful();
    }

    public function test_setting_information_of_patient_by_doctor()
    {
        $this->seed(UserPermissionsSeeder::class);

        $patient = User::factory()->create();
        $patient->assignRole('doctor');

        Sanctum::actingAs($patient);

        $id = 12345678;
        $gender = 'female';
        $birth = time();
        $height = 84;
        $weight = 105;

        $this
            ->postJson(
                'api/store-information',
                [
                    'patient_id' => $patient->id,
                    'id_number' => $id,
                    'gender' => $gender,
                    'birth_date' =>$birth,
                    'height' => $height,
                    'weight' => $weight,
                ]
            )
            ->assertForbidden();
    }

    /**
     * @dataProvider invalidPatientInformationProvider
     */
    public function test_invalid_sets_of_information($information)
    {
        $this->seed(UserPermissionsSeeder::class);

        $patient = User::factory()->create(['id' => 1]);
        $patient->assignRole('patient');

        Sanctum::actingAs($patient);

        $this
            ->postJson(
                'api/store-information',
                $information
            )
            ->assertUnprocessable();
    }

    public function invalidPatientInformationProvider(): array
    {
        return [
            ['wrong patient id' => [
                'patient_id' => 2,
                'id_number' => 12345678,
                'gender' => 'female',
                'birth_date' =>time(),
                'height' => 84,
                'weight' => 105,
            ]],
            ['empty id number' => [
                'patient_id' => 1,
                'gender' => 'female',
                'birth_date' =>time(),
                'height' => 84,
                'weight' => 105,
            ]],
            ['invalid gender' => [
                'patient_id' => 1,
                'id_number' => 12345678,
                'gender' => 'dog',
                'birth_date' =>time(),
                'height' => 84,
                'weight' => 105,
            ]],
            ['empty birth date' => [
                'patient_id' => 1,
                'id_number' => 12345678,
                'gender' => 'female',
                'height' => 84,
                'weight' => 105,
            ]],
            ['empty height' => [
                'patient_id' => 1,
                'id_number' => 12345678,
                'gender' => 'female',
                'birth_date' =>time(),
                'weight' => 105,
            ]],
            ['empty weight' => [
                'patient_id' => 1,
                'id_number' => 12345678,
                'gender' => 'female',
                'birth_date' =>time(),
                'height' => 84,
            ]],
        ];
    }
}
