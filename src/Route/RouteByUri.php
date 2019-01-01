<?php

namespace Verse\Route;

use Verse\Error\RouteNotFoundException;
use Verse\Route;

class RouteByUri implements Route
{
    private $routeCached;
    private $routeList;
    private $httpMethod;
    private $uri;

    public function __construct(RouteList $routeList, string $httpMethod, string $uri)
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
     * @return mixed
     * @throws RouteNotFoundException
     */
    public function token(string $key)
    {
        return $this->route()->token($key);
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

        $httpMethod = strtoupper($this->httpMethod);

        foreach ($this->routeList as $route) {
            if ($path === $route->path() && $httpMethod === $route->method()) {
                $this->routeCached = $route;
                break;
            }
        }

        if (null === $this->routeCached) {
            throw new RouteNotFoundException("Route $httpMethod:$path not found");
        }

        return $this->routeCached;
    }
}