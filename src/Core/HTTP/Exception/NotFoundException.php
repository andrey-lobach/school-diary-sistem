<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 27.2.19
 * Time: 16.34
 */

namespace Core\HTTP\Exception;

use Throwable;

class NotFoundException extends RequestException
{
    /**
     * NotFoundException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = 'Not Found', int $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}