<?php

namespace Tests\Feature\Diagnose;

use App\Models\Submission;
use App\Models\User;
use Database\Seeders\UserPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadFileTest extends TestCase
{
    use RefreshDatabase;

    public function test_correct_diagnose_uploading()
    {
        $this->withoutExceptionHandling();

        $this->seed(UserPermissionsSeeder::class);

        $doctor = User::factory()->create();
        $doctor->assignRole('doctor');

        $submission = Submission::factory()->create([
            'doctor_id' => $doctor->id,
            'status' => 'in_progress', ]);

        $file = UploadedFile::fake()->create('prescription.txt');

        $this
            ->patchJson(
                'api/upload-file/'.$submission->id,
                ['prescription' => $file]
            )
            ->assertSuccessful();

        // Assert the file was stored...
        Storage::disk('do')->assertExists('prescription.txt');
    }
}
