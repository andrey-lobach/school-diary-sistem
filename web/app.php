<?php

use Core\HTTP\Exception\HTTPExceptionInterface;
use Core\Request\RequestFactory;

require_once __DIR__.'/../app/autoload.php';
$kernel = new Kernel;

try {
    $container = \Core\ServiceContainer::getInstance();
    $request = RequestFactory::createRequest();
    $response = $kernel->createResponse($request);
    $response->send();
} catch (HTTPExceptionInterface $exception) {
    echo $exception->getCode();
    echo $exception->getMessage();
} catch (Exception $exception) {
    echo $exception->getCode();
    echo $exception->getMessage();
}




