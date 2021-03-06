<?php

namespace Verse\Action\Error;

use Verse\Action;
use Verse\Env;
use Verse\Response;
use Verse\Response\RespHtml;
use Verse\User;

/**
 * 403 page.
 */
class Error403 implements Action
{
    private $tplFileName;

    public function __construct(string $tplFileName)
    {
        $this->tplFileName = $tplFileName;
    }

    public function run(Env $env, User $user): Response
    {
        return new RespHtml(
            $env->tpl()->render($this->tplFileName),
            [$_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden']
        );
    }
}
