<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 12.12.18
 * Time: 17.22
 */

namespace Controller;


use Core\HTTP\Session;
use Core\Request\Request;
use Core\Response\RedirectResponse;
use Core\Response\Response;
use Core\Response\TemplateResource;
use Form\LoginForm;
use Service\SecurityService;

class SecurityController
{
    /**
     * @var SecurityService
     */
    private $securityService;
    /**
     * @var Session
     */
    private $session;

    public function __construct(SecurityService $securityService, Session $session)
    {

        $this->securityService = $securityService;
        $this->session = $session;
    }

    public function login(Request $request)
    {
        echo json_encode($this->session->get('user'));
        $form = new LoginForm($this->securityService);
        if ($request->getMethod() === Request::POST) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $this->securityService->authorize($form->getData());
                return new RedirectResponse('/app.php');
            }
        }
        $path = __DIR__ . '/../../app/views/User/login.php';
        return new Response(new TemplateResource($path, ['form' => $form]));
    }

    public function logout()
    {
        $this->securityService->logout();
        return new RedirectResponse('/app.php');

    }
}