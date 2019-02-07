<?php

namespace Verse\Service;

use Verse\Auth\AuthEncrypted;
use Verse\Route;

/**
 * App services list.
 *
 * All possible services, including communication with database, template engine,
 * cache, mailer and so on.
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