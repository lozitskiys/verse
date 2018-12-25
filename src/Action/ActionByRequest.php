<?php

namespace Verse\Action;

use Verse\Route\RouteList;
use Verse\Action;
use Verse\Env;
use Verse\Error\RouteNotFoundException;
use Verse\Response;

class ActionByRequest implements Action
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
     * @param Env $env
     * @return Response
     * @throws RouteNotFoundException
     */
    public function run(Env $env): Response
    {
        return $this->action()->run($env);
    }

    /**
     * @return Action
     * @throws RouteNotFoundException
     */
    private function action(): Action
    {
        $url = parse_url($this->uri);

        $path = trim($url['path']);
        if ('/' !== $path) {
            $path = rtrim($url['path'], ' \/');
        }

        $httpMethod = strtoupper($this->httpMethod);

        foreach ($this->routeList as $route) {
            if ($path === $route->path() && $httpMethod === $route->method()) {
                return $this->actionInstance($route->action());
            }
        }

        throw new RouteNotFoundException("Route $httpMethod:$path not found");
    }

    private function actionInstance(string $actionPath): Action
    {
        $className = 'Actions';

        if (false !== strpos($actionPath, '/')) {
            foreach (explode('/', $actionPath) as $subDir) {
                $className .= '\\' . $subDir;
            }
        } else {
            $className .= '\\' . $actionPath;
        }

        return new $className;
    }
}