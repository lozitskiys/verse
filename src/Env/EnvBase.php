<?php

namespace Verse\Env;

use Verse\Env;
use Verse\Services;

class EnvBase implements Env
{
    private $siteRoot;
    private $debug;
    private $defDisplayErrorsMethod;
    private $services;

    public function __construct(
        string $siteRoot,
        bool $debug,
        string $defDisplayErrorsMethod,
        Services $services
    ) {
        $this->siteRoot = $siteRoot;
        $this->debug = $debug;
        $this->defDisplayErrorsMethod = $defDisplayErrorsMethod;
        $this->services = $services;
    }

    public function srv(): Services
    {
        return $this->services;
    }

    public function siteRoot(): string
    {
        return $this->siteRoot;
    }

    public function debug(): bool
    {
        return $this->debug;
    }

    public function defaultErrorDisplayType(): string
    {
        return $this->defDisplayErrorsMethod;
    }
}