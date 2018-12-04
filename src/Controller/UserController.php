<?php
/**
 * Created by PhpStorm.
 * UserModel: andrei
 * Date: 21.11.18
 * Time: 1.31
 */

namespace Controller;

use Core\Response\EmptyResource;
use Core\Response\RedirectResponse;
use Core\Response\Response;
use Core\Request\Request;
use Core\Response\TemplateResource;
use Form\UserForm;
use Model\UserModel;

class UserController
{
    private $userModel;

    public function __construct(UserModel $user)
    {
        $this->userModel = $user;
    }

    public function list()
    {
        $users = $this->userModel->getList();
        $path =__DIR__.'/../../app/views/User/list.php';
        return new Response(new TemplateResource($path, ['users' => $users]));
    }

    public function create(Request $request)
    {
        $form = new UserForm($this->userModel);
        if ($request->getMethod() === Request::POST){
            $form->handleRequest($request);
            if ($form->isValid()) {
                print_r($form->getViolations());
                $this->userModel->create($form->getData());
                return new RedirectResponse('/app.php/users');
            }
        }
        $path =__DIR__.'/../../app/views/User/create.php';
        return new Response(new TemplateResource($path, ['form' => $form, 'action' => 'create']));
    }

    public function edit (Request $request, int $id)
    {
        $form = new UserForm($this->userModel, $this->userModel->getUser($id));
        if ($request->getMethod() === Request::POST){
            $form->handleRequest($request);
            if ($form->isValid()) {
                $this->userModel->edit($form->getData(), $id);
                return new RedirectResponse('/app.php/users');
            }
        }
        $path =__DIR__.'/../../app/views/User/create.php';
        $form->action='/app.php/users/'.$id.'/edit';
        return new Response(new TemplateResource($path, ['form' => $form, 'action' => $id.'/edit']));
    }

    public function delete(Request $request, int $id)
    {
        $this->userModel->delete($id);
        return new RedirectResponse('/app.php/users');
    }
}