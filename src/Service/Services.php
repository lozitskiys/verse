<?php

namespace Verse\Service;

use PDO;
use Verse\Auth\AuthEncrypted;
use Verse\Routing\Route;

/**
 * App services list.
 *
 * All possible services, including communication with database, template engine,
 * cache, mailer and so on.
 */
interface Services
{
    /**
     * @return PDO DB interface
     */
    public function pdo(): PDO;

    /**
     * @return TemplateRenderer
     */
    public function tpl(): TemplateRenderer;

    /**
     * @return AuthEncrypted
     */
    public function auth(): AuthEncrypted;

    /**
     * @return Route
     */
    public function route(): Route;

    /**
     * @return Mailer
     */
    public function mailer(): Mailer;
}
