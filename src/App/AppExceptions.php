<?php

namespace Verse\App;

use Throwable;
use TypeError;
use Verse\Action;
use Verse\App;
use Verse\Env;
use Verse\Error\RouteNotFoundException;
use Verse\User;

/**
 * Application with caught exceptions and type errors.
 *
 * App decorator.
 */
class AppExceptions implements App
{
    public function __construct(private App $app)
    {
    }

    public function start(Action $action, Env $env, User $user): void
    {
        try {
            $this->app->start($action, $env, $user);
        } catch (TypeError $error) {
            $code = 500;
            $errorMsg = $error->getMessage();
        } catch (RouteNotFoundException $exception) {
            $code = 404;
            $errorMsg = $exception->getMessage();
        } catch (Throwable $exception) {
            $code = 500;
            $errorMsg = $exception->getMessage();
        }

        if (isset($errorMsg)) {
            // redirect to errors page
            exit($errorMsg . $code);
        }
    }
}
