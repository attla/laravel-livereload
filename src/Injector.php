<?php

namespace Attla\LiveReload;

use Attla\LiveReload\Commands\ServeWebSocketsCommand;

class Injector
{
    /**
     * Append script to html
     * I dont care it doesn't place before </body> tag or not.
     *
     * @param string $content
     *
     * @return string
     */
    public function injectScripts($content)
    {
        $content = $content . view('livereload::script', [
            'host' => '127.0.0.1',
            'port' => ServeWebSocketsCommand::port(),
        ])->getContent();

        return $content;
    }
}
