<?php

use Verse\Route\RouteList;
use Verse\Route\RouteBase;
use Verse\Route\RouteByUri;

class RouteByUriTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    private function routeList(): RouteList
    {
        return new class implements RouteList
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

    public function testRouteWithTokens()
    {
        $route = new RouteByUri($this->routeList(), 'GET', '/test3/video/777');

        $this->assertEquals('TestAction3', $route->action());
        $this->assertEquals('/test3/{tag}/{id}', $route->path());
        $this->assertEquals('GET', $route->method());
        $this->assertEquals('video', $route->token('tag'));
        $this->assertEquals('777', $route->token('id'));
    }




}