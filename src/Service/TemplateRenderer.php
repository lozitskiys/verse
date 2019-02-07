<?php

namespace Verse\Service;

interface TemplateRenderer
{
    function render(string $templateName, array $params = []): string;
}