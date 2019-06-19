<?php

namespace Verse\Routing\Route;

use ArrayAccess;
use Verse\Error\RouteNotFoundException;
use Verse\Routing\Route;

class RouteTokens implements ArrayAccess
{
    private $tokens;
    private $route;
    private $uri;

    public function __construct(Route $route, string $uri)
    {
        $this->route = $route;
        $this->uri = $uri;
    }

    public function offsetExists($offset)
    {
        return isset($this->tokens()[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->tokens()[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->tokens[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->tokens[$offset]);
    }

    public function tokens(): array
    {
        if (null !== $this->tokens) {
            return $this->tokens;
        }

        if (false === strpos($this->route->path(), '{')) {
            throw new RouteNotFoundException(
                "Error in route " . $this->route->path() . ": no tokens found"
            );
        }

        $tokensStartFrom = strpos($this->route->path(), '{');

        $routeTokens = substr($this->route->path(), $tokensStartFrom);
        $uriTokens = substr($this->uri, $tokensStartFrom);

        $routeTokensArr = explode('/', str_replace(['{', '}'], '', $routeTokens));
        $uriTokensArr = explode('/', $uriTokens);

        $tokens = [];
        foreach ($routeTokensArr as $num => $name) {
            $tokens[$name] = $uriTokensArr[$num];
        }

        $this->tokens = $tokens;

        return $this->tokens;
    }
}
