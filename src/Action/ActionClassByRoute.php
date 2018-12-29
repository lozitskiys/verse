<?php

namespace Verse\Action;

use Verse\Error\RouteNotFoundException;
use Verse\Route\RouteList;

class ActionClassByRoute implements ActionClass
{
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
    public function className(): string
    {
        $url = parse_url($this->uri);

        $path = trim($url['path']);
        if ('/' !== $path) {
            $path = rtrim($url['path'], ' \/');
        }

        $httpMethod = strtoupper($this->httpMethod);

        foreach ($this->routeList as $route) {
            if ($path === $route->path() && $httpMethod === $route->method()) {
                return $this->classNameByPath($route->action());
            }
        }

        throw new RouteNotFoundException("Route $httpMethod:$path not found");
    }

    private function classNameByPath(string $actionPath): string
    {
        $className = 'Actions';

        if (false !== strpos($actionPath, '/')) {
            foreach (explode('/', $actionPath) as $subDir) {
                $className .= '\\' . $subDir;
            }
        } else {
            $className .= '\\' . $actionPath;
        }

        return $className;
    }
}