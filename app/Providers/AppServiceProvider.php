<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\AzureBlobStorage\AzureBlobStorageAdapter;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    
    public function boot()
    {
        Storage::extend('azure', function ($app, $config) {
            $connectionString = config('filesystems.disks.azure.connection_string');
            $container = config('filesystems.disks.azure.container');
            
            $client = BlobRestProxy::createBlobService($connectionString);

            return new \League\Flysystem\Filesystem(
                new AzureBlobStorageAdapter($client, $container)
            );
        });
    }

}
