<?php

namespace Verse\Service;

use Verse\Service;
use Verse\TemplateRenderer;

class ServiceStd implements Service
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
    public function template(): TemplateRenderer
    {
        return $this->instance('template');
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