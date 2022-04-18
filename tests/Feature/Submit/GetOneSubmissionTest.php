<?php

namespace Tests\Feature\Submit;

use App\Models\PatientInformation;
use App\Models\Submission;
use App\Models\User;
use Database\Seeders\UserPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetOneSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_submissions_of_a_patient()
    {
        $this->withoutExceptionHandling();

        $this->seed(UserPermissionsSeeder::class);

        $patient = User::factory()->create();
        $patient->assignRole('patient');

        Sanctum::actingAs($patient);

        $info = PatientInformation::factory()->create(['patient_id' => $patient->id]);

        $submission = Submission::factory()->create(['patient_id' => $patient->id]);

        $this
            ->getJson('api/get-one-submissions')
            ->assertSuccessful()
            ->assertJsonFragment([
                'symptoms' => $submission->symptoms,
                'id_number' => $info->id_number,
            ]);
    }

    public function test_dont_get_submission_of_another_patient()
    {
        $this->withoutExceptionHandling();

        $this->seed(UserPermissionsSeeder::class);

        $patient1 = User::factory()->create();
        $patient1->assignRole('patient');

        $patient2 = User::factory()->create();
        $patient2->assignRole('patient');

        Sanctum::actingAs($patient1);

        $info1 = PatientInformation::factory()->create(['patient_id' => $patient1->id]);
        $info2 = PatientInformation::factory()->create(['patient_id' => $patient2->id]);

        $submission1 = Submission::factory()->create(['patient_id' => $patient1->id]);
        $submission2 = Submission::factory()->create(['patient_id' => $patient2->id]);

        $this
            ->getJson('api/get-one-submissions')
            ->assertSuccessful()
            ->assertJsonFragment([
                'symptoms' => $submission1->symptoms,
                'id_number' => $info1->id_number,
            ])
            ->assertJsonMissing([
                'symptoms' => $submission2->symptoms,
                'id_number' => $info2->id_number,
            ]);
    }
}
