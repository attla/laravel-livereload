<?php

namespace Attla\LiveReload;

use Carbon\Laravel\ServiceProvider;
use Attla\LiveReload\Commands\ServeCommand;
use Attla\LiveReload\Commands\ServeHttpCommand;
use Attla\LiveReload\Commands\ServeWebSocketsCommand;
use Illuminate\Contracts\Support\DeferrableProvider;

class CommandServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the application services
     *
     * @return void
     */
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

        $this->mergeConfigFrom($this->configPath(), 'livereload');
    }

    /**
     * Bootstrap the application services
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            $this->configPath() => config_path('livereload.php'),
        ], 'attla/livereload/config');
    }

    /**
     * Get config path
     *
     * @param bool
     */
    protected function configPath()
    {
        return __DIR__ . '/../config/livereload.php';
    }

    public function provides()
    {
        return ['command.serve'];
    }
}
