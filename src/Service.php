<?php

namespace Verse;

interface Service
{
    function pdo(): \PDO;

    function template(): TemplateRenderer;

}