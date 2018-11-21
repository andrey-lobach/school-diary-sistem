<?php
/**
 * Created by PhpStorm.
 * UserModel: andrei
 * Date: 21.11.18
 * Time: 1.31
 */

namespace Controller;

use Core\Response\Response;
use Model\UserModel;

class UserController
{
    private $user;

    public function __construct(UserModel $user)
    {
        $this->user = $user;
    }

    public function list() {
        $users = $this->user->getList();
        ob_start();
        require __DIR__.'/../../app/views/User/list.php';
        $content = ob_get_contents();
        ob_end_clean();
        return new Response($content);
    }
}