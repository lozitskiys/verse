<?php

namespace Verse\TemplateRenderer;

use Verse\TemplateRenderer;

class TwigRenderer implements TemplateRenderer
{
    private $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public function render(string $templateName, array $params = []): string
    {
        return $this->twig->render($templateName . '.twig', $params);
    }
}