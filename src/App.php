<?php

namespace Verse;

interface App
{
    function start(Action $action, Env $env): void;
}