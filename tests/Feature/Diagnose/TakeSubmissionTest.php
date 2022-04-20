<?php

namespace Tests\Feature\Diagnose;

use App\Models\Submission;
use App\Models\User;
use Database\Seeders\UserPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TakeSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_doctor_can_take_patient_submission()
    {
        $this->withoutExceptionHandling();

        $this->seed(UserPermissionsSeeder::class);

        $submission = Submission::factory()->create();

        $doctor = User::factory()->create();
        $doctor->assignRole('doctor');

        Sanctum::actingAs($doctor);

        $this
            ->patch('api/take-submission/'.$submission->id, [
                'doctor_id' => $doctor->id,
            ])
            ->assertSuccessful();

        $this
            ->assertDatabaseHas('submissions', [
                'doctor_id' => $doctor->id,
                'status' => 'in_progress',
            ]);
    }

    public function test_doctor_cant_take_submission_already_taken()
    {
        $this->seed(UserPermissionsSeeder::class);

        $doctor = User::factory()->create();
        $doctor->assignRole('doctor');

        $submission = Submission::factory()->create([
            'doctor_id' => $doctor->id,
            'status' => 'in_progress',
        ]);

        Sanctum::actingAs($doctor);

        $this
            ->patch('api/take-submission/'.$submission->id, [
                'doctor_id' => $doctor->id,
            ])
            ->assertForbidden();
    }

    public function test_patient_cant_take_submission()
    {
        $this->seed(UserPermissionsSeeder::class);

        $patient = User::factory()->create();
        $patient->assignRole('patient');

        $submission = Submission::factory()->create();

        Sanctum::actingAs($patient);

        $this
            ->patch('api/take-submission/'.$submission->id, [
                'doctor_id' => $patient->id,
            ])
            ->assertForbidden();
    }
}
