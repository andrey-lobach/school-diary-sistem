<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 5.3.19
 * Time: 16.50
 */

namespace Service;


use Core\HTTP\Exception\HTTPExceptionInterface;
use Core\Response\Response;
use Core\Template\Renderer;

class HTTPExceptionsRenderer
{
    /**
     * @var int
     */
    private $code;
    /**
     * @var string
     */
    private $message;
    /**
     * @var Renderer
     */
    private $renderer;

    /**
     * HTTPExceptionsRenderer constructor.
     * @param int $code
     * @param string $message
     * @param Renderer $renderer
     */
    public function __construct(Renderer $renderer, int $code = 400, string $message = '')
    {
        $this->code = $code;
        $this->message = $message;
        $this->renderer = $renderer;
    }

    /**
     * @param HTTPExceptionInterface $exception
     * @return Response
     * @throws \Exception
     */
    public function createResponse(HTTPExceptionInterface $exception): Response
    {
        return new Response($this->renderer->render('Core/request_exception.php', ['code' => $exception->getCode(), 'message' => $exception->getMessage()]));
    }

}