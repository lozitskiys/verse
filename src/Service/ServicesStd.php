<?php

namespace Verse\Service;

use Verse\Auth\AuthEncrypted;
use Verse\Route;
use Verse\Services;
use Verse\TemplateRenderer;

class ServicesStd implements Services
{
    private $container;
    private $instances = [];

    public function __construct(array $container)
    {
        $this->container = $container;
    }

    /**
     * @return \PDO
     * @throws \Exception
     */
    public function pdo(): \PDO
    {
        return $this->instance('pdo');
    }

    /**
     * @return TemplateRenderer
     * @throws \Exception
     */
    public function tpl(): TemplateRenderer
    {
        return $this->instance('template');
    }

    /**
     * @return AuthEncrypted
     * @throws \Exception
     */
    public function auth(): AuthEncrypted
    {
        return $this->instance('auth');
    }

    /**
     * @return Route
     * @throws \Exception
     */
    public function route(): Route
    {
        return $this->instance('route');
    }

    /**
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    private function instance(string $name)
    {
        if (!isset($this->instances[$name])) {
            if (!isset($this->container[$name])) {
                throw new \Exception(
                    "Instance name=$name not found in service container"
                );
            } elseif (!is_callable($this->container[$name])) {
                throw new \Exception(
                    "Instance name=$name must be type of callable"
                );
            }

            $this->instances[$name] = $this->container[$name]();

            if (!is_object($this->instances[$name])) {
                throw new \Exception("Instance name=$name is not an object");
            }
        }

        return $this->instances[$name];
    }
}