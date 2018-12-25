<?php

namespace Verse\Route;

use Verse\Route;

class RouteStd implements Route
{
    private $action;
    private $method;
    private $path;

    public function __construct(
        string $action,
        string $method,
        string $path
    ) {
        $this->action = $action;
        $this->method = $method;
        $this->path = $path;
    }

    public function action(): string
    {
        return $this->action;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function path(): string
    {
        return $this->path;
    }
}