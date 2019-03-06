<?php
/**
 * Created by PhpStorm.
 * UserModel: andrei
 * Date: 14.11.18
 * Time: 17.58
 */

namespace Core\Response;


class RedirectResponse extends Response
{
    /**
     * RedirectResponse constructor.
     *
     * @param     $url
     * @param int $code
     */
    public function __construct($url, int $code = self::MOVED_TEMPORARILY)
    {
        $this->resource = new EmptyResource();
        $this->headers= ['Location' => $url];
    }
}