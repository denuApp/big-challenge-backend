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
            ->assertForbidden();
    }

    /**
     * @dataProvider invalidSubmissionProvider
     */
    public function test_invalid_submissions($submission)
    {
        $this->seed(UserPermissionsSeeder::class);

        $patient = User::factory()->create(
            ['id' => 1]
        );
        $patient->assignRole('patient');

        Sanctum::actingAs($patient);

        $this
            ->postJson(
                'api/store-submissions',
                [
                    $submission,
                ]
            )
            ->assertUnprocessable();
    }

    public function invalidSubmissionProvider(): array
    {
        return [
            ['incorrect patient id' => [
                'patient_id' => 2,
                'symptoms' => 'my arm hurt really bad',
            ]],
            ['empty symptoms' => [
                'patient_id' => 1,
            ]],

        ];
    }
}
