<?php

namespace Verse\App;

use Verse\Action;
use Verse\App;
use Verse\Env;
use Verse\Error\RouteNotFoundException;

/**
 * Application with caught exceptions and type errors.
 *
 * AppStd decorator.
 */
class AppExceptions implements App
{
    private $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function start(Action $action, Env $env): void
    {
        try {
            $this->app->start($action, $env);
        } catch (\TypeError $error) {
            $code = 500;
            $errorMsg = $error->getMessage();
        } catch (RouteNotFoundException $exception) {
            $code = 404;
            $errorMsg = $exception->getMessage();
        } catch (\Throwable $exception) {
            $code = 500;
            $errorMsg = $exception->getMessage();
        }

        if (isset($errorMsg)) {
            // redirect to errors page
            exit($errorMsg.$code);
        }
    }
}