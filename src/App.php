<?php

namespace Verse;

/**
 * Application entry point
 */
interface App
{
    function start(Action $action, Env $env, User $user): void;
}