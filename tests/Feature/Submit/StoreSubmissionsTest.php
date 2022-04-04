<?php

namespace Tests\Feature\Submit;

use App\Models\User;
use Database\Seeders\UserPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class StoreSubmissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_submissions_are_stored_when_filled_correctly()
    {
        $this->withoutExceptionHandling();

        $this->seed(UserPermissionsSeeder::class);

        $patient = User::factory()->create();
        $patient->assignRole('patient');
        $symptoms = 'i have fever and cough';

        Sanctum::actingAs($patient);

        $this
            ->postJson(
                'api/store-submissions',
                [
                    'patient_id' => $patient->id,
                    'symptoms' => $symptoms,
                ]
            )
            ->assertSuccessful();

        $this
            ->assertDatabaseHas('users', [
                'id' => $patient->id,
            ]);

        $this
            ->assertDatabaseHas('submissions', [
                'patient_id' => $patient->id,
                'symptoms' => $symptoms,
            ]);
    }

    public function test_inavlid_submissions_made_by_doctor()
    {
        $this->withoutExceptionHandling();

        $this->seed(UserPermissionsSeeder::class);

        $patient = User::factory()->create();
        $patient->assignRole('doctor');
        $symptoms = 'i have fever and cough';

        Sanctum::actingAs($patient);

        $this
            ->postJson(
                'api/store-submissions',
                [
                    'patient_id' => $patient->id,
                    'symptoms' => $symptoms,
                ]
            )
            ->assertUnprocessable();
    }
}
