<?php

namespace Tests\Feature\Submit;

use App\Models\Submission;
use App\Models\User;
use Database\Seeders\UserPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetSubmissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_submissions_of_a_patient()
    {
        $this->withoutExceptionHandling();

        $this->seed(UserPermissionsSeeder::class);

        $patient = User::factory()->create();
        $patient->assignRole('patient');

        Sanctum::actingAs($patient);

        $submission1 = Submission::factory()->create(['patient_id' => $patient->id]);
        $submission2 = Submission::factory()->create(['patient_id' => $patient->id]);

        $this
            ->postJson('api/get-submissions')
            ->assertSuccessful()
            ->assertJsonFragment([
                'symptoms' => $submission1->symptoms,
                'symptoms' => $submission2->symptoms,
            ]);
    }

    public function test_dont_get_submissions_of_another_patient()
    {
        $this->withoutExceptionHandling();

        $this->seed(UserPermissionsSeeder::class);

        $patient1 = User::factory()->create();
        $patient1->assignRole('patient');

        $patient2 = User::factory()->create();
        $patient2->assignRole('patient');

        Sanctum::actingAs($patient1);

        $submission1 = Submission::factory()->create(['patient_id' => $patient1->id]);
        $submission2 = Submission::factory()->create(['patient_id' => $patient2->id]);

        $this
            ->postJson('api/get-submissions')
            ->assertSuccessful()
            ->assertSee([
                'symptoms' => $submission1->symptoms,
            ])
            ->assertJsonMissing([
                'symptoms' => $submission2->symptoms,
            ]);
    }

    public function test_get_submissions_by_status_of_a_patient()
    {
        $this->withoutExceptionHandling();

        $this->seed(UserPermissionsSeeder::class);

        $patient = User::factory()->create();
        $patient->assignRole('patient');

        Sanctum::actingAs($patient);

        $submission1 = Submission::factory()->create(['patient_id' => $patient->id, 'symptoms'=>'resfrio']);
        $submission2 = Submission::factory()->create(['patient_id' => $patient->id, 'status' => 'in_progress', 'symptoms'=>'tos']);

        $this
            ->postJson('api/get-submissions', ['status' => 'pending'])
            ->assertSuccessful()
            ->assertJsonFragment([
                'symptoms' => $submission1->symptoms,
            ])
            ->assertJsonMissing([
                'symptoms' => $submission2->symptoms,
            ]);
    }

    public function test_get_submissions_by_unexisting_status_of_a_patient()
    {
        $this->seed(UserPermissionsSeeder::class);

        $patient = User::factory()->create();
        $patient->assignRole('patient');

        Sanctum::actingAs($patient);

        $this
            ->postJson('api/get-submissions', ['status' => 'nothing'])
            ->assertUnprocessable();
    }
}
