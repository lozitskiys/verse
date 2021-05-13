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
    public function siteRoot(): string;

    public function config(): array;
}
