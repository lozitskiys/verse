<?php

namespace Verse;

/**
 * App environment.
 *
 * App services and configuration.
 */
interface Env
{
    function service(): Service;

    function siteRoot(): string;

    function debug(): bool;

    function defaultErrorDisplayType(): string;
}