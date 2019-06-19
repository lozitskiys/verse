<?php

namespace Verse\Action\Error;

use Verse\Action;
use Verse\Env;
use Verse\Response;
use Verse\Response\RespHtml;
use Verse\User;

/**
 * Internal server error page.
 */
class Error50x implements Action
{
    private $tplFileName;
    private $errMsg;

    public function __construct(string $tplFileName, string $errMsg)
    {
        $this->tplFileName = $tplFileName;
        $this->errMsg = $errMsg;
    }

    public function run(Env $env, User $user): Response
    {
        return new RespHtml(
            $env->tpl()->render($this->tplFileName, ['message' => $this->errMsg]),
            [$_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error']
        );
    }
}
