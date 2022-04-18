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
                    'patient_id' => $patient->id,
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
}
