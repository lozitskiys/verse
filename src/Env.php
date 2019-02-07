<?php

namespace Verse;

use Verse\Service\Services;

/**
 * App environment.
 *
 * App services and configuration.
 */
interface Env extends Services
{

    function siteRoot(): string;

    function devMode(): bool;

    function config(): array;
}