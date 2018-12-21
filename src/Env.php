<?php

namespace Verse;

interface Env
{
    function service(): Service;

    function siteRoot(): string;

    function debug(): bool;

    function defaultErrorDisplayType(): string;
}