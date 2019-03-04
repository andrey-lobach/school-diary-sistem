<?php

use Core\HTTP\Exception\HTTPExceptionInterface;
use Core\Request\RequestFactory;

require_once __DIR__.'/../app/autoload.php';
$kernel = new Kernel;

try {
    $request = RequestFactory::createRequest();
    $response = $kernel->createResponse($request);
    $response->send();
} catch (HTTPExceptionInterface $exception) {
    //TODO create service to render HTTPexceptions
   // $response = $kernel->getContainer()->get()->createResponse($exception);
    //$response->send();
} catch (Exception $exception) {
    echo $exception->getCode();
    echo $exception->getMessage();
}




