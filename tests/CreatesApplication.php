<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;

trait CreatesApplication
{
    /**
     * Creates the application.
     */
    public function createApplication(): Application
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        // Ensure an application key exists during tests to avoid
        // MissingAppKeyException when encryption services are used.
        $config = $app->make('config');
        if (empty($config->get('app.key'))) {
            $config->set('app.key', 'base64:'.base64_encode(str_repeat('a', 32)));
        }

        return $app;
    }
}
