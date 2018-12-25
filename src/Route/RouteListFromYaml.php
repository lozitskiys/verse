<?php

namespace Verse\Route;

use Exception;
use Symfony\Component\Yaml\Yaml;
use Throwable;
use Traversable;

class RouteListFromYaml implements RouteList
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
        } catch (Throwable $e) {
            throw new Exception('Error parsing routes from yaml file');
        }

        if (!is_array($res) || empty($res)) {
            throw new Exception('Empty routes in yaml file');
        }

        foreach ($res as $path => $stringOrArray) {
            if (is_string($stringOrArray)) {
                $method = 'GET';
                $action = $stringOrArray;
            } elseif (is_array($stringOrArray) && !empty($stringOrArray)) {
                $method = $this->validateAndGetHttpMethod($path, $stringOrArray);
                $action = $this->validateAndGetAction($path, $stringOrArray);
            } else {
                throw new Exception(
                    "Error configuring path $path: value must be either string or array"
                );
            }

            yield new RouteStd($action, $method, $path);
        }
    }

    /**
     * @param string $path
     * @param array $array
     * @return string
     * @throws Exception
     */
    private function validateAndGetHttpMethod(string $path, array $array): string
    {
        if (!isset($array['method'])) {
            return 'GET';
        }

        $method = strtoupper($array['method']);

        $validHttpMethods = [
            'GET',
            'HEAD',
            'POST',
            'PUT',
            'DELETE'
        ];

        if (!in_array($method, $validHttpMethods)) {
            throw new Exception(
                "Error configuring path $path: invalid HTTP method " . $array['method']
            );
        }

        return $method;
    }

    /**
     * @param string $path
     * @param array $array
     * @return string
     * @throws Exception
     */
    private function validateAndGetAction(string $path, array $array): string
    {
        if (!isset($array['action'])) {
            throw new Exception("Error configuring path $path: action not set");
        }

        return $array['action'];
    }
}