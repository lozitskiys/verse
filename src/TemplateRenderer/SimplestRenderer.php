<?php

namespace Verse\TemplateRenderer;

use Verse\TemplateRenderer;

/**
 * Simplest possible template renderer.
 *
 * Using plain php files.
 */
class SimplestRenderer implements TemplateRenderer
{
    private $tplDir;

    public function __construct(string $tplDir)
    {
        $this->tplDir = $tplDir;
    }

    /**
     * @param string $templateName
     * @param array $params
     * @return string
     * @throws \Exception
     */
    public function render(string $templateName, array $params = []): string
    {
        $fileName = $this->tplDir . '/' . $templateName . '.php';

        if (!is_file($fileName)) {
            throw new \Exception("Template $templateName doesn't exists.");
        }

        if (!empty($params)) {
            extract($params);
        }

        ob_start();
        include $fileName;

        return ob_get_clean();
    }
}