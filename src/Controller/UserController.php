<?php
/**
 * Created by PhpStorm.
 * UserModel: andrei
 * Date: 21.11.18
 * Time: 1.31
 */

namespace Controller;

use Core\Response\Response;
use Core\Request\Request;
use Model\UserModel;

class UserController
{
    private $userModel;

    public function __construct(UserModel $user)
    {
        $this->userModel = $user;
    }

    public function list() {
        $users = $this->userModel->getList();
        ob_start();
        require __DIR__.'/../../app/views/User/list.php';
        $content = ob_get_contents();
        ob_end_clean();
        return new Response($content);
    }

    public function create(Request $request) {
        if ($request->getMethod() === Request::POST){
            $user = [
                'login' => $request->get('login'),
                'password' => $request->get('password'),
                'roles' => (array)$request->get('roles', [])
            ];
            $this->userModel->create($user);
        }
        ob_start();
        require __DIR__.'/../../app/views/User/create.php';
        $content = ob_get_contents();
        ob_end_clean();
        return new Response($content);
    }
}