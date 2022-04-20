<?php

namespace Tests\Feature\Submit;

use App\Models\Submission;
use App\Models\User;
use Database\Seeders\UserPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EditSubmissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_submissions_can_be_edited_and_updated_in_the_database()
    {
        $this->withoutExceptionHandling();

        $this->seed(UserPermissionsSeeder::class);

        $patient = User::factory()->create();
        $patient->assignRole('patient');
        $submission = Submission::factory()->create(['patient_id' => $patient->id]);

        Sanctum::actingAs($patient);

        $symptoms = 'feeling really bad';

        $this
            ->patchJson(
                'api/edit-submission/'.$submission->id,
                [
                    'symptoms' => $symptoms,
                ]
            )
            ->assertSuccessful();

        $this
            ->assertDatabaseHas('submissions', [
                'patient_id' => $patient->id,
                'symptoms' => $symptoms,
            ])
            ->assertDatabaseMissing('submissions', [
                'symptoms' => $submission->symptoms,
            ]);
    }

    public function test_submission_cant_be_edited_by_doctor()
    {
        $this->seed(UserPermissionsSeeder::class);

        $patient = User::factory()->create();
        $patient->assignRole('patient');
        $submission = Submission::factory()->create(['patient_id' => $patient->id]);

        $doctor = User::factory()->create();
        $doctor->assignRole('doctor');

        $symptoms = 'i have fever and cough';

        Sanctum::actingAs($doctor);

        $this
            ->patchJson(
                'api/edit-submission/'.$submission->id,
                [
                    'symptoms' => $symptoms,
                ]
            )
            ->assertForbidden();
    }

    public function test_editing_submission_from_another_patient()
    {
        $this->seed(UserPermissionsSeeder::class);

        $patient1 = User::factory()->create();
        $patient1->assignRole('patient');

        $patient2 = User::factory()->create();
        $patient2->assignRole('patient');

        Sanctum::actingAs($patient2);

        $submission = Submission::factory()->create(['patient_id' => $patient1->id]);

        $symptoms = 'i have fever and cough';

        $this
            ->patchJson(
                'api/edit-submission/'.$submission->id,
                [
                    'symptoms' => $symptoms,
                ]
            )
            ->assertForbidden();
    }

    public function test_editing_with_empty_symptoms()
    {
        $this->seed(UserPermissionsSeeder::class);

        $patient = User::factory()->create();
        $patient->assignRole('patient');

        Sanctum::actingAs($patient);

        $submission = Submission::factory()->create(['patient_id' => $patient->id]);

        $this
            ->patchJson(
                'api/edit-submission/'.$submission->id,
                [
                ]
            )
            ->assertUnprocessable();
    }
}
