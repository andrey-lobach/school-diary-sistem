<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 21.11.18
 * Time: 18.28
 */

namespace Core;


final class ServiceContainer
{
    /**
     * @var self
     */
    private static $instance;
    /**
     * @var array
     */
    private $config;
    /**
     * @var array
     */
    private $services = [];

    public static function getInstance(array $config = null): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self($config);
        } elseif ($config !== null) {
            throw new \LogicException('Service Container has configured already');
        }
        return self::$instance;
    }

    private function __construct(array $config)
    {
        $this->config = $config;
    }

    public function get(string $key)
    {
        if (!array_key_exists($key, $this->services)){
            $this->services[$key] = $this->createService($key);
        }
        return $this->services[$key];
    }

    public function getParameter(string $key)
    {
        return $this->config['parameters'][$key];
    }

    private function createService(string $class)
    {
        $parameters = [];

        $config = $this->config['services'][$class]?? [];
        foreach ($config as $parameter) {
            if (substr($parameter, 0, 1) === '%' && substr($parameter, -1) === '%'){
                $parameters[] = $this->getParameter(substr($parameter,1,-1));
            }else {

                $service = $this->get($parameter);
                if ($service instanceof InvokeInterface){
                 $parameters[] = $service();
                } else {
                    $parameters[] = $this->get($parameter);
                }
            }
        }
        return new $class(...$parameters);

    }

}