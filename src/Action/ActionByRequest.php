<?php

namespace Verse\Action;

use Verse\Action;
use Verse\Env;
use Verse\Error\RouteNotFoundException;
use Verse\Response;

class ActionByRequest implements Action
{
    private $routes;
    private $requestUri;
    private $env;

    public function __construct(array $routes, string $requestUri, Env $env)
    {
        $this->routes = $routes;
        $this->requestUri = $requestUri;
        $this->env = $env;
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
        $url = parse_url($this->requestUri);

        $path = rtrim($url['path'], ' \/');

        if (!isset($this->routes[$path])) {
            throw new RouteNotFoundException("Route not found");
        }

        $className = 'Actions';

        if (false !== strpos($this->routes[$path], '/')) {
            foreach (explode('/', $this->routes[$path]) as $subDir) {
                $className .= '\\' . $subDir;
            }
        } else {
            $className .= '\\' . $this->routes[$path];
        }

        return new $className;
    }
}