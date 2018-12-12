<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 12.12.18
 * Time: 16.55
 */
namespace Core\HTTP;

final class Session
{
    /**
     * @var self
     */
    private static $instance;

    private function __construct()
    {
    }

    static public function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
            self::$instance->start();
        }
        return self::$instance;
    }

    public function start()
    {
        if (!$this->hasStarted()) {
            if (!session_start()) {
                throw new \Exception('Session can not be started');
            }
        }
    }

    public function hasStarted()
    {
        return php_sapi_name() !== 'cli' && session_status() === PHP_SESSION_ACTIVE;
    }

    public function set(string $key, $value)
    {
        $this->checkSessionStarted();
        $_SESSION[$key] = $value;
    }

    public function get(string $key)
    {
        $this->checkSessionStarted();
        return $_SESSION[$key];
    }

    public function has(string $key): bool
    {
        $this->checkSessionStarted();
        return isset($_SESSION[$key]);
    }

    public function remove(string $key)
    {
        $this->checkSessionStarted();
        unset($_SESSION[$key]);
    }

    private function checkSessionStarted()
    {
        if (!$this->hasStarted()) {
            throw new \LogicException('Session has not started yet');
        }
    }
}