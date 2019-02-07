<?php

namespace Verse\Service;


use Psr\Container\ContainerInterface;

class ServiceContainer implements ContainerInterface
{
    private $container;
    private $instances = [];

    public function __construct(array $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $id
     * @return mixed
     * @throws \Exception
     */
    public function get($id)
    {
        if (!isset($this->instances[$id])) {
            if (!$this->has($id)) {
                throw new \Exception(
                    "Instance name=$id not found in service container"
                );
            } elseif (!is_callable($this->container[$id])) {
                throw new \Exception(
                    "Instance name=$id must be type of callable"
                );
            }

            $this->instances[$id] = $this->container[$id]();

            if (!is_object($this->instances[$id])) {
                throw new \Exception("Instance name=$id is not an object");
            }
        }

        return $this->instances[$id];
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has($id)
    {
        return isset($this->container[$id]);
    }
}