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

    /**
     * @dataProvider correctPatientInformationProvider
     */
    public function test_setting_information_of_patient($info)
    {
        $this->withoutExceptionHandling();

        $this->seed(UserPermissionsSeeder::class);

        $patient = User::factory()->create();
        $patient->assignRole('patient');

        Sanctum::actingAs($patient);

        $this
            ->postJson(
                'api/store-information',
                [
                    'patient_id' => $patient->id,
                    'id_number' => $info['id_number'],
                    'gender' => $info['gender'],
                    'birth_date' => $info['birth_date'],
                    'height' => $info['height'],
                    'weight' => $info['weight'],
                ]
            )
            ->assertSuccessful();
    }

    /**
     * @dataProvider correctPatientInformationProvider
     */
    public function test_setting_information_of_patient_by_doctor($info)
    {
        $this->seed(UserPermissionsSeeder::class);

        $patient = User::factory()->create();
        $patient->assignRole('doctor');

        Sanctum::actingAs($patient);

        $this
            ->postJson(
                'api/store-information',
                [
                    'patient_id' => $patient->id,
                    'id_number' => $info['id_number'],
                    'gender' => $info['gender'],
                    'birth_date' => $info['birth_date'],
                    'height' => $info['height'],
                    'weight' => $info['weight'],
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

    public function correctPatientInformationProvider(): array
    {
        return [
            ['buen array' => ['id_number' => 12345678,
            'gender' => 'female',
            'birth_date' => '2000-03-02 15:51:00',
            'height' => 84,
            'weight' => 105, ],
        ],

        ];
    }

    public function invalidPatientInformationProvider(): array
    {
        return [

            ['empty id number' => [
                'patient_id' => 1,
                'gender' => 'female',
                'birth_date' => '2000-03-02 15:51:00',
                'height' => 84,
                'weight' => 105,
            ]],
            ['invalid gender' => [
                'patient_id' => 1,
                'id_number' => 12345678,
                'gender' => 'dog',
                'birth_date' => '2000-03-02 15:51:00',
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
                'birth_date' => '2000-03-02 15:51:00',
                'weight' => 105,
            ]],
            ['empty weight' => [
                'patient_id' => 1,
                'id_number' => 12345678,
                'gender' => 'female',
                'birth_date' => '2000-03-02 15:51:00',
                'height' => 84,
            ]],
        ];
    }
}
