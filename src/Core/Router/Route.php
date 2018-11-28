<?php
/**
 * Created by PhpStorm.
 * UserModel: andrei
 * Date: 21.11.18
 * Time: 1.55
 */

namespace Core\Router;

class Route
{
    /**
     * @var string
     */
    private $controllerClass;
    /**
     * @var string
     */
    private $method;
    /**
     * @var string
     */
    private $path;
    /**
     * @var string
     */
    private $pattern;
    /**
     * @var array
     */
    private $rules;

    public function __construct(string $path, string $controllerClass, string $method, array $rules = [])
    {
        $this->path = $path;
        $this->controllerClass = $controllerClass;
        $this->method = $method;
        $this->rules =$this->prepareRules($rules, $path);
        $this->pattern = $this->createPattern($path, $this->rules);
    }

    public function getControllerClass(): string
    {
        return $this->controllerClass;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function match(string $path): bool
    {
        return preg_match($this->pattern, $path);
    }

    public function getPathValues(string $path): array
    {
        $matches = [];
        preg_match($this->pattern, $path, $matches);
        array_shift($matches);
        return array_values($matches);
    }

    private function createPattern(string $path, $rules): string
    {
        if ($rules) {
            $search = array_map(
                function ($key) {
                    return sprintf('{%s}', $key);
                },
                array_keys($rules)
            );
            $replace = array_map(
                function ($rule) {
                    return sprintf('(%s)', $rule);
                },
                array_values($rules)
            );
            $path = str_replace($search, $replace, $path);
        }
        return sprintf('~^%s$~', $path);
    }

    private function prepareRules(array $rules, string $path)
    {
        //TODO sort rules like in the path
        return $rules;
    }
}