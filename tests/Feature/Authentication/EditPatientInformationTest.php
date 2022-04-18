<?php

namespace Tests\Feature\Authentication;

use App\Models\PatientInformation;
use App\Models\User;
use Database\Seeders\UserPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EditPatientInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_editing_information_of_patient()
    {
        $this->withoutExceptionHandling();

        $this->seed(UserPermissionsSeeder::class);

        $patient = User::factory()->create();
        $patient->assignRole('patient');

        Sanctum::actingAs($patient);

        $info = PatientInformation::factory()->create(['patient_id' => $patient->id]);

        $this
            ->patchJson(
                'api/edit-information/'.$info->id,
                [
                    'patient_id' => $patient->id,
                    'id_number' => $info['id_number'],
                    'gender' => $info['gender'],
                    'birth_date' => $info['birth_date'],
                    'height' => 70,
                    'weight' => 180,
                ]
            )
            ->assertSuccessful();

        $this
            ->assertDatabaseHas('patient_information', [
                'height' => 70,
                'weight' => 180,
            ]);

        $this
            ->assertDatabaseMissing('patient_information', [
                'height' => $info->height,
                'weight' => $info->weight,
            ]);
    }

    public function test_editing_information_of_patient_by_doctor()
    {
        $this->seed(UserPermissionsSeeder::class);

        $patient = User::factory()->create();
        $patient->assignRole('patient');

        $doctor = User::factory()->create();
        $doctor->assignRole('doctor');

        Sanctum::actingAs($doctor);

        $info = PatientInformation::factory()->create(['patient_id' => $patient->id]);

        $this
            ->patchJson(
                'api/edit-information/'.$info->id,
                [
                    'patient_id' => $patient->id,
                    'id_number' => $info['id_number'],
                    'gender' => $info['gender'],
                    'birth_date' => $info['birth_date'],
                    'height' => 70,
                    'weight' => 180,
                ]
            )
            ->assertForbidden();
    }

    /**
     * @dataProvider invalidPatientInformationProvider
     */
    public function test_invalid_edit_of_information($information)
    {
        $this->seed(UserPermissionsSeeder::class);

        $patient = User::factory()->create(['id' => 1]);
        $patient->assignRole('patient');

        Sanctum::actingAs($patient);

        $info = PatientInformation::factory()->create([
            'patient_id' => $patient->id, ]);

        $this
            ->patchJson(
                'api/edit-information/'.$info->id,
                $information
            )
            ->assertUnprocessable();
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
