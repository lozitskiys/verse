<?php

namespace Verse\Action\Error;

use Verse\Action;
use Verse\Env;
use Verse\Response;
use Verse\Response\RespJson;
use Verse\User;

/**
 * Api error.
 */
class ErrorJson implements Action
{
    public function __construct(private string $msg)
    {
    }

    public function run(Env $env, User $user): Response
    {
        return new RespJson([
            'result' => 'error',
            'message' => $this->msg
        ]);
    }
}
