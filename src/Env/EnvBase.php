<?php

namespace Verse\Env;

use DateTime;
use Exception;
use PDO;
use Psr\Container\ContainerInterface;
use Verse\Auth\AuthEncrypted;
use Verse\Env;
use Verse\Routing\Route;
use Verse\Service\Mailer;
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

    /**
     * @return Mailer
     */
    public function mailer(): Mailer
    {
        return $this->container->get(__FUNCTION__);
    }

    /**
     * @param string $serviceName
     * @return mixed
     */
    public function getService(string $serviceName): mixed
    {
        if (!$this->container->has($serviceName)) {
            throw new Exception("Unknown service $serviceName");
        }

        return $this->container->get($serviceName);
    }

    public function config(): array
    {
        return $this->config;
    }

    public function siteRoot(): string
    {
        return $this->siteRoot;
    }

    public function log($message, string $logFile): string
    {
        $date = (new DateTime)->format('d.m.Y H:i:s');
        if (!is_string($message)) {
            $message = print_r($message, true);
        }

        $logPath = $this->siteRoot . '/logs/' . $logFile;
        error_log($date . ' ' . $message . "\n", 3, $logPath);

        return $date;
    }
}
