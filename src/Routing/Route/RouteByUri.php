<?php

namespace Verse\Routing\Route;

use Verse\Error\RouteNotFoundException;
use Verse\Routing\Route;
use Verse\Routing\Routes;

class RouteByUri implements Route
{
    private $routeCached;
    private $routeList;
    private $httpMethod;
    private $uri;

    public function __construct(Routes $routeList, string $httpMethod, string $uri)
    {
        $this->routeList = $routeList;
        $this->httpMethod = $httpMethod;
        $this->uri = $uri;
    }

    /**
     * @return string
     * @throws RouteNotFoundException
     */
    public function method(): string
    {
        return $this->route()->method();
    }

    /**
     * @return string
     * @throws RouteNotFoundException
     */
    public function action(): string
    {
        return $this->route()->action();
    }

    /**
     * @return string
     * @throws RouteNotFoundException
     */
    public function path(): string
    {
        return $this->route()->path();
    }

    /**
     * @param string $key
     * @param bool $strict
     * @return mixed
     * @throws RouteNotFoundException
     */
    public function token(string $key, bool $strict = true)
    {
        return $this->route()->token($key, $strict);
    }

    /**
     * @return Route
     * @throws RouteNotFoundException
     */
    private function route(): Route
    {
        if (null !== $this->routeCached) {
            return $this->routeCached;
        }

        $url = parse_url($this->uri);

        $path = trim($url['path']);
        if ('/' !== $path) {
            $path = rtrim($url['path'], ' \/');
        }

        $currentPathArray = explode('/', $path);

        $httpMethod = strtoupper($this->httpMethod);

        foreach ($this->routeList as $route) {
            if ($httpMethod !== $route->method()) {
                continue;
            }

            $pathArray = explode('/', $route->path());

            if (count($pathArray) != count($currentPathArray)) {
                continue;
            }

            $pathMatched = true;
            $routeHasTokens = false;
            foreach ($pathArray as $ind => $pathPart) {
                if ($pathPart == $currentPathArray[$ind]) {
                    continue;
                }

                if (0 === strpos($pathPart, '{')) {
                    $routeHasTokens = true;
                    continue;
                }

                $pathMatched = false;
                break;
            }

            if (!$pathMatched) {
                continue;
            }

            if ($routeHasTokens) {
                $this->routeCached = new RouteBase(
                    $route->action(),
                    $route->method(),
                    $route->path(),
                    new RouteTokens($route, $path)
                );
            } else {
                $this->routeCached = $route;
            }

            break;
        }

        if (null === $this->routeCached) {
            throw new RouteNotFoundException("Route $httpMethod:$path not found");
        }

        return $this->routeCached;
    }
}
