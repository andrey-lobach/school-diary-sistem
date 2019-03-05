<?php

use Core\HTTP\Exception\HTTPExceptionInterface;
use Core\Request\RequestFactory;
use Service\HTTPExceptionsRenderer;

require_once __DIR__.'/../app/autoload.php';
$kernel = new Kernel;

try {
    $request = RequestFactory::createRequest();
    $response = $kernel->createResponse($request);
    $response->send();
} catch (HTTPExceptionInterface $exception) {
   $response = $kernel->getContainer()->get(HTTPExceptionsRenderer::class)->createResponse($exception);
   $response->send();
} catch (Exception $exception) {
    echo $exception->getCode();
    echo $exception->getMessage();
}




