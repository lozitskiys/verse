<?php

namespace Verse\Env;

use Verse\Env;
use Verse\Service;

class EnvStd implements Env
{
    private $siteRoot;
    private $debug;
    private $defDisplayErrorsMethod;
    private $service;

    public function __construct(
        string $siteRoot,
        bool $debug,
        string $defDisplayErrorsMethod,
        Service $service
    ) {
        $this->siteRoot = $siteRoot;
        $this->debug = $debug;
        $this->defDisplayErrorsMethod = $defDisplayErrorsMethod;
        $this->service = $service;
    }

    public function service(): Service
    {
        return $this->service;
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