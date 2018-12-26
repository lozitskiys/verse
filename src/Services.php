<?php

namespace Verse;

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

}