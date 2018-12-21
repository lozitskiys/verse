<?php

namespace Verse;

interface TemplateRenderer
{
    function render(string $templateName, array $params = []): string;
}