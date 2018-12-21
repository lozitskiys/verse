<?php

namespace Verse;

/**
 * Services to use in app.
 */
interface Service
{
    function pdo(): \PDO;

    function template(): TemplateRenderer;

}