<?php

namespace App\Providers;

use App\Services\CdnService;
use App\Services\DOCdnServices;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->app->bind(CdnService::class, DOCdnServices::class);

        Filesystem::macro('getSignedUri', function ($filePath) {
            /** @phpstan-ignore-next-line */
            $adapter = Storage::getAdapter();
            $client = $adapter->getClient();
            $bucket = $adapter->getBucket();

            $cmd = $client->getCommand('PutObject', [
                'Bucket' => $bucket,
                'Key' => $filePath,
                'ACL' => 'public-read',
            ]);

            $signedRequest = $client->createPresignedRequest($cmd, '+20 minutes');

            return (string) $signedRequest->getUri();
        });
    }
}
