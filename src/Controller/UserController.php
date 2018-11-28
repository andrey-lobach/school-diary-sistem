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
        $user = [];
        $form = new UserForm($user, $this->userModel); // TODO use usermodel for check login unique
        if ($request->getMethod() === Request::POST){
            $form->handleRequest($request);
//            $user = [
//                'login' => $request->get('login'),
//                'password' => $request->get('password'),
//                'roles' => (array)$request->get('roles', [])
//            ];
            if ($form->isValid()) {
                $this->userModel->create($form->getData());
                //TODO redirect
            }


        }
        //TODO refactor

        $path =__DIR__.'/../../app/views/User/create.php';
        return new Response(new TemplateResource($path, ['form' => $form]));
    }

    public function delete(Request $request, int $id)
    {
        $this->userModel->delete($id);
        return new RedirectResponse('/app.php/users');
    }
}