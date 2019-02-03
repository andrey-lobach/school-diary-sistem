<?php
/**
 * Created by PhpStorm.
 * UserModel: andrei
 * Date: 21.11.18
 * Time: 1.31
 */

namespace Controller;

use Core\Response\RedirectResponse;
use Core\Response\Response;
use Core\Request\Request;
use Core\Template\Renderer;
use Form\UserForm;
use Model\UserModel;

class UserController
{
    /**
     * @var UserModel
     */
    private $userModel;

    /**
     * @var Renderer
     */
    private $renderer;

    /**
     * UserController constructor.
     *
     * @param UserModel $user
     * @param Renderer  $renderer
     */
    public function __construct(UserModel $user, Renderer $renderer)
    {
        $this->userModel = $user;
        $this->renderer = $renderer;
    }

    /**
     * @return Response
     */
    public function list(): Response
    {
        $users = $this->userModel->getList();
        $path = 'User/list.php';

        return new Response($this->renderer->render($path, ['users' => $users]));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $form = new UserForm($this->userModel);
        if ($request->getMethod() === Request::POST) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $this->userModel->create($form->getData());

                return new RedirectResponse('/users');
            }
        }
        $path = 'User/create.php';

        return new Response($this->renderer->render($path, ['form' => $form]));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function edit(Request $request)
    {
        $id = $request->get('id');
        $user = $this->userModel->getUser($id);
        if (null === $user) {
            throw new \RuntimeException('user not found');
        }
        $form = new UserForm($this->userModel, $user);
        if ($request->getMethod() === Request::POST) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $this->userModel->edit($form->getData(), $id);

                return new RedirectResponse('/users');
            }
        }
        $path = 'User/create.php';

        return new Response($this->renderer->render($path, ['form' => $form, 'user' => $user]));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function delete(Request $request): RedirectResponse
    {
        $id = $request->get('id');
        if (!$this->userModel->getUser($id)) {
            throw new \RuntimeException('User not exist');
        }
        $this->userModel->delete($id);

        return new RedirectResponse('/users');
    }
}