<?php

namespace Verse\App;

use Verse\Action;
use Verse\App;
use Verse\Env;

class AppStd implements App
{
    public function start(Action $action, Env $env): void
    {
        $resp = $action->run($env);

        foreach ($resp->headers() as $h) {
            header($h);
        }

        echo $resp->body();
    }
}