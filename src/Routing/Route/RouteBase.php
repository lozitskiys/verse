<?php

namespace Verse\Routing\Route;

use ArrayAccess;
use Exception;
use Verse\Routing\Route;

class RouteBase implements Route
{
    private $action;
    private $method;
    private $path;
    private $tokens;

    public function __construct(
        string $action,
        string $method,
        string $path,
        ArrayAccess $tokens = null
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
     * @param bool $strict
     * @return mixed
     */
    public function token(string $key, bool $strict = true)
    {
        if (!isset($this->tokens[$key])) {
            if ($strict) {
                throw new Exception("Token $key not found");
            }

            return null;
        }

        return $this->tokens[$key];
    }
}
