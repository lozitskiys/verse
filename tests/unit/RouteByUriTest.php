<?php

use Verse\Route\RouteList;
use Verse\Route\RouteStd;
use Verse\Route\RouteByUri;

class RouteByUriTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    private function routelist(): RouteList
    {
        return new class implements RouteList
        {
            public function getIterator(): Traversable
            {
                yield new RouteStd(
                    'TestAction1',
                    'GET',
                    '/test1'
                );

                yield new RouteStd(
                    'TestAction2',
                    'GET',
                    '/test2'
                );

                yield new RouteStd(
                    'TestAction3',
                    'GET',
                    '/test3/{tag}/{id}'
                );
            }
        };
    }

    public function testRoute()
    {
        $route = new RouteByUri($this->routelist(), 'GET', '/test2');

        $this->assertEquals('TestAction2', $route->action());
        $this->assertEquals('/test2', $route->path());
        $this->assertEquals('GET', $route->method());
        //$this->assertEquals('', $route->token());
    }

    public function testRouteWithTokens()
    {
        $route = new RouteByUri($this->routelist(), 'GET', '/test3/video/777');

        $this->assertEquals('TestAction3', $route->action());
        $this->assertEquals('/test3/{tag}/{id}', $route->path());
        $this->assertEquals('GET', $route->method());
        $this->assertEquals('video', $route->token('tag'));
        $this->assertEquals('777', $route->token('id'));
    }


}