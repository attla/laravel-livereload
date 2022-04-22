<?php

namespace Attla\LiveReload;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use Attla\LiveReload\Middleware\InjectScriptsMiddleware;

class ResponseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../views/', 'livereload');

        $this->app->make(Kernel::class)
            ->prependMiddlewareToGroup('web', InjectScriptsMiddleware::class);
    }
}
