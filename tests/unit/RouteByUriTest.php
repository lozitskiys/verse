<?php

use Codeception\Test\Unit;
use Verse\Routing\Route\RouteBase;
use Verse\Routing\Route\RouteByUri;
use Verse\Routing\Routes;

class RouteByUriTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    private function routeList(): Routes
    {
        return new class implements Routes
        {
            public function getIterator(): Traversable
            {
                yield new RouteBase(
                    'TestAction1',
                    'GET',
                    '/test1'
                );

                yield new RouteBase(
                    'TestAction2',
                    'GET',
                    '/test2'
                );

                yield new RouteBase(
                    'TestAction3',
                    'GET',
                    '/test3/{tag}/{id}'
                );

                yield new RouteBase(
                    'TestAction4',
                    'GET',
                    '/test4/{id}'
                );

                yield new RouteBase(
                    'TestAction5',
                    'GET',
                    '/test5/{id}/video'
                );

                yield new RouteBase(
                    'TestAction6',
                    'POST',
                    '/test4/{id}'
                );
            }
        };
    }

    public function testRoute()
    {
        $route = new RouteByUri($this->routeList(), 'GET', '/test2');

        $this->assertEquals('TestAction2', $route->action());
        $this->assertEquals('/test2', $route->path());
        $this->assertEquals('GET', $route->method());
    }

    public function testRouteWithToken()
    {
        $route = new RouteByUri($this->routeList(), 'GET', '/test4/777');

        $this->assertEquals('TestAction4', $route->action());
        $this->assertEquals('/test4/{id}', $route->path());
        $this->assertEquals('GET', $route->method());
        $this->assertEquals('777', $route->token('id'));
    }

    public function testRouteWithTokenNotStrict()
    {
        $route = new RouteByUri($this->routeList(), 'GET', '/test4/777');

        $this->assertNull($route->token('unknown', false));
    }

    public function testRouteWithTokens()
    {
        $route = new RouteByUri($this->routeList(), 'GET', '/test3/video/777');

        $this->assertEquals('TestAction3', $route->action());
        $this->assertEquals('/test3/{tag}/{id}', $route->path());
        $this->assertEquals('GET', $route->method());
        $this->assertEquals('video', $route->token('tag'));
        $this->assertEquals('777', $route->token('id'));
    }

    public function testRouteWithTokensInMiddleOfTheRoute()
    {
        $route = new RouteByUri($this->routeList(), 'GET', '/test5/777/video');

        $this->assertEquals('TestAction5', $route->action());
        $this->assertEquals('/test5/{id}/video', $route->path());
        $this->assertEquals('GET', $route->method());
        $this->assertEquals('777', $route->token('id'));
    }

    public function testRouteHttpMethod()
    {
        $route = new RouteByUri($this->routeList(), 'POST', '/test4/123');

        $this->assertEquals('TestAction6', $route->action());
        $this->assertEquals('/test4/{id}', $route->path());
        $this->assertEquals('POST', $route->method());
    }
}
