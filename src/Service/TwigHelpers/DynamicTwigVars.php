<?php

namespace Verse\Service\TwigHelpers;

use Psr\Container\ContainerInterface;

/**
 * Container to pass global variables to twig.
 *
 * @author Stas Lozitskiy
 */
class DynamicTwigVars implements ContainerInterface
{
    private array $vars;

    public function set(string $id, mixed $value)
    {
        $this->vars[$id] = $value;
    }

    public function get(string $id)
    {
        return $this->has($id) ? $this->vars[$id] : null;
    }

    public function has(string $id)
    {
        return isset($this->vars[$id]);
    }
}
