<?php

namespace Verse;

use Verse\Auth\AuthEncrypted;

/**
 * Services to use in app.
 */
interface Services
{
    /**
     * @return \PDO DB interface
     */
    function pdo(): \PDO;

    /**
     * @return TemplateRenderer
     */
    function tpl(): TemplateRenderer;

    /**
     * @return AuthEncrypted
     */
    function auth(): AuthEncrypted;

    /**
     * @return Route
     */
    function route(): Route;
}