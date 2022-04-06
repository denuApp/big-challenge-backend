<?php

namespace Tests\Feature\Submit;

use App\Models\Submission;
use App\Models\User;
use Database\Seeders\UserPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteSubmissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_submission_by_patient()
    {
        $this->withoutExceptionHandling();

        $this->seed(UserPermissionsSeeder::class);

        $patient = User::factory()->create();
        $patient->assignRole('patient');

        Sanctum::actingAs($patient);

        $submission1 = Submission::factory()->create(['patient_id' => $patient->id]);
        $submission2 = Submission::factory()->create(['patient_id' => $patient->id]);

        $this
            ->deleteJson('api/delete-submissions/', ['id' => $submission1->id])
            ->assertSuccessful();

        $this
            ->assertDatabaseMissing('submissions', [
                'id' => $submission1->id,
                'symptoms' => $submission1->symptoms,
            ])
            ->assertDatabaseHas('submissions', [
                'id' => $submission2->id,
                'symptoms' => $submission2->symptoms,
            ]);
    }
}
