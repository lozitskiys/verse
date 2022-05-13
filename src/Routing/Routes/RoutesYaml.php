<?php

namespace Verse\Routing\Routes;

use Exception;
use Symfony\Component\Yaml\Yaml;
use Throwable;
use Traversable;
use Verse\Routing\Route\RouteBase;
use Verse\Routing\Routes;

class RoutesYaml implements Routes
{
    private $path;
    private $yamlParser;

    public function __construct(string $path, Yaml $yamlParser = null)
    {
        $this->path = $path;
        $this->yamlParser = $yamlParser ?? new Yaml();
    }

    /**
     * @return Traversable
     * @throws Exception
     */
    public function getIterator(): Traversable
    {
        try {
            $res = $this->yamlParser::parseFile($this->path);
        } catch (Throwable) {
            throw new Exception('Error parsing routes from yaml file');
        }

        if (!is_array($res) || empty($res)) {
            throw new Exception('Empty routes in yaml file');
        }

        foreach ($res as $pathStr => $action) {
            if (!is_string($action)) {
                throw new Exception(
                    "Error configuring path $pathStr: value must be valid action name"
                );
            }

            $pathArray = explode(' ', $pathStr);
            if (isset($pathArray[1])) {
                $method = $this->validateAndGetHttpMethod($pathStr, $pathArray[1]);
                $path = $pathArray[0];
            } else {
                $method = 'GET';
                $path = $pathStr;
            }

            yield new RouteBase($action, $method, $path);
        }
    }

    /**
     * @param string $path
     * @param string $method
     * @return string
     * @throws Exception
     */
    private function validateAndGetHttpMethod(string $path, string $method): string
    {
        $method = strtoupper($method);

        $validHttpMethods = [
            'GET',
            'HEAD',
            'POST',
            'PUT',
            'DELETE',
            'OPTIONS'
        ];

        if (!in_array($method, $validHttpMethods)) {
            throw new Exception(
                "Error configuring path $path: invalid HTTP method $method"
            );
        }

        return $method;
    }
}
