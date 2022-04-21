<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DOCdnServices implements CdnService
{
    public function purge($fileName)
    {
        $folder = config('filesystems.do.folder');
        Http::asJson()->delete(
            config('filesystems.do.cdn_endpoint').'/cache',
            [
                'files' => ["{$folder}/{$fileName}"],
            ]
        );
    }
}
