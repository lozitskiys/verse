<?php

namespace Verse;

interface Action
{
    function run(Env $env, User $user): Response;
}
