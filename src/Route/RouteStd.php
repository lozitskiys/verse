<?php

namespace Verse\Route;

use Verse\Route;

class RouteStd implements Route
{
    private $action;
    private $method;
    private $path;
    private $tokens;

    public function __construct(
        string $action,
        string $method,
        string $path,
        array $tokens = []
    ) {
        $this->action = $action;
        $this->method = $method;
        $this->path = $path;
        $this->tokens = $tokens;
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

    /**
     * @param string $key
     * @return mixed
     * @throws \Exception
     */
    public function token(string $key)
    {
        if (!isset($this->tokens[$key])) {
            throw new \Exception("Token $key not found");
        }

        return $this->tokens[$key];
    }
}