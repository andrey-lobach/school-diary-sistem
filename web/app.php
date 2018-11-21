<?php

use Core\Request\RequestFactory;
require_once __DIR__.'/../app/autoload.php';
$kernel = new Kernel;


try {
    $request = RequestFactory::createRequest();
    $response = $kernel->createResponse($request);
}   catch (\Exception $exception){

}
$response->send();



