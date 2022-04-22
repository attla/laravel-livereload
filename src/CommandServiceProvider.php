<?php

namespace Attla\LiveReload;

use Attla\LiveReload\Commands\ServeCommand;
use Attla\LiveReload\Commands\ServeHttpCommand;
use Attla\LiveReload\Commands\ServeWebSocketsCommand;
use Carbon\Laravel\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class CommandServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register()
    {
        // override serve command
        $this->app->singleton('command.serve', function () {
            return new ServeCommand();
        });

        // register new commands
        $this->commands([
            ServeCommand::class,
            ServeHttpCommand::class,
            ServeWebSocketsCommand::class,
        ]);

        $this->mergeConfigFrom(__DIR__ . '/../config/livereload.php', 'livereload');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/livereload.php' => config_path('livereload.php'),
        ]);
    }

    public function provides()
    {
        return ['command.serve'];
    }
}
