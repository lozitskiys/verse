<?php

namespace Verse\Env;

use Exception;
use Psr\Container\ContainerInterface;
use Verse\Auth\AuthEncrypted;
use Verse\Env;
use Verse\Routing;
use Verse\Service\TemplateRenderer;

class EnvBase implements Env
{
    private $container;
    private $siteRoot;
    private $config;

    public function __construct(
        ContainerInterface $container,
        string $siteRoot,
        array $config = []
    ) {
        $this->container = $container;
        $this->siteRoot = $siteRoot;
        $this->config = $config;
    }

    /**
     * @return \PDO
     * @throws Exception
     */
    public function pdo(): \PDO
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

    /**
     * @return bool
     * @throws Exception
     */
    public function devMode(): bool
    {
        if (!isset($this->config['debug'])) {
            throw new Exception('"debug" variable not found in .env file');
        }

        return
            true === $this->config['debug'] ||
            'yes' === $this->config['debug'] ||
            'on' === $this->config['debug'] ||
            '1' === $this->config['debug'] ||
            1 === $this->config['debug'];
    }

    public function siteRoot(): string
    {
        return $this->siteRoot;
    }
}
