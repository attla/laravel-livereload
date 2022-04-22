<?php

namespace Attla\LiveReload\Commands;

use Attla\Console\Commands\ServeCommand;

class ServeHttpCommand extends ServeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'serve:http';

    /**
     * @var bool
     */
    protected $hidden = true;
}
