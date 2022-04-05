<?php

namespace Tests\Feature\Authentication;

use App\Models\User;
use Database\Seeders\UserPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

        $id = 12345678;
        $gender = 'female';
        $birth = '15-03-2000';
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
}
