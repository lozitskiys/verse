<?php


use Codeception\Test\Unit;
use Verse\Error\RouteNotFoundException;
use Verse\Routing\Route\RouteBase;
use Verse\Routing\Route\RouteTokens;

class RouteTokensTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testToken()
    {
        $exp = [
            'id' => 777
        ];

        $this->assertEquals(
            $exp,
            (new RouteTokens(
                new RouteBase(
                    'TestAction',
                    'GET',
                    '/wiki/{id}'
                ),
                '/wiki/777'
            ))->tokens()
        );
    }

    public function testMultipleTokens()
    {
        $exp = [
            'tag' => 'php',
            'id' => 777
        ];

        $this->assertEquals(
            $exp,
            (new RouteTokens(
                new RouteBase(
                    'TestAction',
                    'GET',
                    '/wiki/{tag}/{id}'
                ),
                '/wiki/php/777'
            ))->tokens()
        );
    }

    public function testTokenWrongPath()
    {
        $call = function () {
            (new RouteTokens(
                new RouteBase(
                    'TestAction',
                    'GET',
                    '/wiki/id'
                ),
                '/wiki/777'
            ))->tokens();
        };

        $this->tester->expectThrowable(
            new RouteNotFoundException('Error in route /wiki/id: no tokens found'),
            $call
        );
    }
}