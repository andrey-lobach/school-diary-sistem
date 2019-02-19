<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 19.2.19
 * Time: 16.25
 */

namespace Core;

use Core\HTTP\Session;

class MessageBag
{
    /**
     * @var Session
     */
    private $session;

    /**
     * MessageBag constructor.
     *
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @param string $message
     */
    public function addMessage(string $message)
    {
        $this->add('messages', $message);
    }

    /**
     * @return array
     */
    public function pullMessages():array
    {
        return $this->pull('messages');
    }

    /**
     * @param string $message
     */
    public function addError(string $message)
    {
        $this->add('errors', $message);
    }

    /**
     * @return array
     */
    public function pullErrors():array
    {
        return $this->pull('errors');

    }

    /**
     * @param string $key
     * @param string $message
     */
    private function add(string $key, string $message)
    {
        $messages = $this->session->get($key, []);
        $messages[] = $message;
        $this->session->set($key, $messages);
    }

    /**
     * @param string $key
     *
     * @return array
     */
    private function pull(string $key): array
    {
        $messages = $this->session->get($key, []);
        $this->session->remove($key);
        return $messages;
    }


}