<?php

namespace Verse\Service;

interface TemplateRenderer
{
    public function render(string $templateName, array $params = []): string;
}
