<?php

namespace Verse\Env;

use Exception;
use PDO;
use Psr\Container\ContainerInterface;
use Verse\Auth\AuthEncrypted;
use Verse\Env;
use Verse\Routing\Route;
use Verse\Service\TemplateRenderer;

class EnvBase implements Env
{
    public function __construct(
        private ContainerInterface $container,
        private string $siteRoot,
        private array $config = []
    ) {
    }

    /**
     * @return PDO
     * @throws Exception
     */
    public function pdo(): PDO
    {
        return $this->container->get(__FUNCTION__);
    }

    /**
     * @return TemplateRenderer
     * @throws Exception
     */
    public function tpl(): TemplateRenderer
    {
        return $this->container->get(__FUNCTION__);
    }

    /**
     * @return AuthEncrypted
     * @throws Exception
     */
    public function auth(): AuthEncrypted
    {
        return $this->container->get(__FUNCTION__);
    }

    /**
     * @return Route
     * @throws Exception
     */
    public function route(): Route
    {
        return $this->container->get(__FUNCTION__);
    }

    public function config(): array
    {
        return $this->config;
    }

    public function siteRoot(): string
    {
        return $this->siteRoot;
    }
}
