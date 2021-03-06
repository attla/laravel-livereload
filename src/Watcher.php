<?php

namespace Attla\LiveReload;

use Illuminate\Support\Facades\Cache;
use React\EventLoop\LoopInterface;
use Symfony\Component\Finder\Finder;
use Attla\ResourceWatcher\Crc32ContentHash;
use Attla\ResourceWatcher\ResourceCacheMemory;
use Attla\ResourceWatcher\ResourceWatcher;

class Watcher
{
    protected $loop;

    protected $finder;

    public function __construct(LoopInterface $loop, Finder $finder)
    {
        $this->loop = $loop;

        $this->finder = $finder;
    }

    public function startWatching(\Closure $callback)
    {
        $watcher = new ResourceWatcher(
            new ResourceCacheMemory(),
            $this->finder,
            new Crc32ContentHash()
        );

        $this->loop->addPeriodicTimer(0.5, function () use ($watcher, $callback) {
            Cache::put('serve_websockets_running', true, 5);
            if ($watcher->findChanges()->hasChanges()) {
                call_user_func($callback);
            }
        });
    }
}
