<?php

namespace Verse;

/**
 * Application entry point
 */
interface App
{
    public function start(Action $action, Env $env, User $user): void;
}
