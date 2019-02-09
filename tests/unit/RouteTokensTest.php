<?php

use Verse\Route\RouteBase;
use Verse\Route\RouteTokensStd;

class RouteTokensTest extends \Codeception\Test\Unit
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
            (new RouteTokensStd(
                new RouteBase(
                    'TestAction',
                    'GET',
                    '/wiki/{id}'
                ),
                '/wiki/777'
            ))->list()
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
            (new RouteTokensStd(
                new RouteBase(
                    'TestAction',
                    'GET',
                    '/wiki/{tag}/{id}'
                ),
                '/wiki/php/777'
            ))->list()
        );
    }

    public function testTokenWrongPath()
    {
        $call = function () {
            (new RouteTokensStd(
                new RouteBase(
                    'TestAction',
                    'GET',
                    '/wiki/id'
                ),
                '/wiki/777'
            ))->list();
        };

        $this->tester->expectThrowable(
            new \Verse\Error\RouteNotFoundException('Error in route /wiki/id: no tokens found'),
            $call
        );
    }
}