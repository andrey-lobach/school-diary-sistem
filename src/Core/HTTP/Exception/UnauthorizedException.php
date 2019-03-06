<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 23.1.19
 * Time: 19.01
 */

namespace Core\HTTP\Exception;

use Throwable;

class UnauthorizedException extends RequestException
{
    /**
     * UnauthorizedException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = 'Unauthorized', int $code = 403, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}