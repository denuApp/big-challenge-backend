<?php

namespace App\Http\Controllers\Files;

use App\Events\Diagnosed;
use App\Http\Controllers\Controller;
use App\Http\Requests\DigitalOceanDeleteRequest;
use App\Http\Requests\DigitalOceanStoreRequest;
use App\Http\Requests\DigitalOceanUpdateRequest;
use App\Models\Submission;
use App\Services\CdnService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DoSpacesController extends Controller
{
    private $cdnService;

    public function __construct(CdnService $cdnService)
    {
        $this->cdnService = $cdnService;
    }

    public function store(DigitalOceanStoreRequest $request, Submission $submission)
    {
        $file = $request->File('prescription');
        $fileName = (string) Str::uuid();
        $folder = config('filesystems.disks.do.folder');

        Storage::disk('do')->put(
            "{$folder}/{$fileName}",
            file_get_contents($file)
        );

        $submission->update(['prescription' => "{$folder}/{$fileName}"]);

        Diagnosed::dispatch($submission);

        return response()->json(['message' => 'File uploaded', 'url' => $submission->prescription], 200);
    }

    public function delete(DigitalOceanDeleteRequest $request)
    {
        $fileName = $request->validated()['doctorProfileImageFileName'];
        $folder = config('filesystems.disks.do.folder');

        Storage::disk('do')->delete("{$folder}/{$fileName}");
        $this->cdnService->purge($fileName);

        return response()->json(['message' => 'File deleted'], 200);
    }

    public function update(DigitalOceanUpdateRequest $request)
    {
        $file = $request->File('doctorProfileImageFile');
        $fileName = $request->validated()['doctorProfileImageFileName'];
        $folder = config('filesystems.disks.do.folder');

        Storage::disk('do')->put(
            "{$folder}/{$fileName}",
            file_get_contents($file)
        );
        $this->cdnService->purge($fileName);

        return response()->json(['message' => 'File updated'], 200);
    }
}
