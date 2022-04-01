<?php

namespace Tests\Feature\Submit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreSubmissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_submissions_are_stored_when_filled_correctly()
    {
        $this->withoutExceptionHandling();

        $patient = User::factory()->create();
        $symptoms = 'i have fever and cough';

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
            ->assertDatabaseHas('submissions', [
                'patient_id' => $patient->id,
                'symptoms' => $symptoms,
            ]);
    }
}
