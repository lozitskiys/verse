<?php

namespace Verse\Route;

use Verse\Error\RouteNotFoundException;
use Verse\Route;

class RouteTokensStd implements RouteTokens
{
    private $route;
    private $uri;

    public function __construct(Route $route, string $uri)
    {
        $this->route = $route;
        $this->uri = $uri;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function list(): array
    {
        $this->validateTokenExists();

        $tokensStartFrom = strpos($this->route->path(), '{');

        $routeTokens = substr($this->route->path(), $tokensStartFrom);
        $uriTokens = substr($this->uri, $tokensStartFrom);

        $routeTokensArr = explode('/', str_replace(['{', '}'], '', $routeTokens));
        $uriTokensArr = explode('/', $uriTokens);

        $tokens = [];
        foreach ($routeTokensArr as $num => $name) {
            $tokens[$name] = $uriTokensArr[$num];
        }

        return $tokens;
    }

    /**
     * @throws \Exception
     */
    private function validateTokenExists(): void
    {
        if (false === strpos($this->route->path(), '{')) {
            throw new RouteNotFoundException(
                "Error in route " . $this->route->path() . ": no tokens found"
            );
        }
    }
}