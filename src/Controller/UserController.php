<?php
/**
 * Created by PhpStorm.
 * UserModel: andrei
 * Date: 21.11.18
 * Time: 1.31
 */

namespace Controller;

use Core\HTTP\Exception\NotFoundException;
use Core\MessageBag;
use Core\Response\RedirectResponse;
use Core\Response\Response;
use Core\Request\Request;
use Core\Security\PasswordHelper;
use Core\Security\StringBuilder;
use Core\Template\Renderer;
use Enum\RolesEnum;
use Form\ChangePasswordForm;
use Form\UserFilterFom;
use Form\UserForm;
use Model\UserModel;
use Service\SecurityService;

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
     * @var SecurityService
     */
    private $securityService;

    /**
     * @var MessageBag
     */
    private $messageBag;

    /**
     * UserController constructor.
     *
     * @param UserModel $user
     * @param Renderer $renderer
     * @param SecurityService $securityService
     * @param MessageBag $messageBag
     */
    public function __construct(
        UserModel $user,
        Renderer $renderer,
        SecurityService $securityService,
        MessageBag $messageBag
    )
    {
        $this->userModel = $user;
        $this->renderer = $renderer;
        $this->securityService = $securityService;
        $this->messageBag = $messageBag;
    }

    /**
     * @param Request $request
     *
     * @return Response
     * @throws \Exception
     */
    public function list(Request $request): Response
    {
        $path = 'User/list.php';
        $form = new UserFilterFom($this->userModel);
        if ($request->getPath() !== '/users') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $users = $this->userModel->getList($form->getData());
                return new Response($this->renderer->render($path, ['users' => $users, 'form' => $form, 'countOfPages' => $this->userModel->getCountOfPages($form->getData()), 'query' => parse_url($request->getPath(), PHP_URL_QUERY)]));
            }
        }
        $users = $this->userModel->getList();
        return new Response($this->renderer->render($path, ['users' => $users, 'form' => $form, 'countOfPages' => $this->userModel->getCountOfPages([])]));
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
                $this->messageBag->addMessage('User created');

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
     * @throws NotFoundException
     */
    public function edit(Request $request)
    {
        $id = $request->get('id');
        $user = $this->userModel->getUser($id);
        if (null === $user) {
            throw new NotFoundException();
        }
        $form = new UserForm($this->userModel, $user);
        if ($request->getMethod() === Request::POST) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $this->userModel->edit($form->getData(), $id);
                $this->messageBag->addMessage('User updated');

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
            throw new NotFoundException();
        }
        try {
            $this->userModel->delete($id);
        } catch (\LogicException $exception) {
            $this->messageBag->addError($exception->getMessage());

            return new RedirectResponse('/users');
        }
        $this->messageBag->addMessage('User deleted');

        return new RedirectResponse('/users');
    }

    /**
     * @param Request $request
     *
     * @return Response
     * @throws \Exception
     */
    public function profile(Request $request): Response
    {
        $form = new ChangePasswordForm($this->securityService);
        if ($request->getMethod() === Request::POST) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $this->userModel->changePassword($this->securityService->getUserId(), $form->getData()['newPassword']);
                $this->messageBag->addMessage('Password changed');
            }
        }
        $path = 'User/my_profile.php';

        return new Response(
            $this->renderer->render(
                $path,
                [
                    'role' => $this->securityService->getRole(),
                    'user' => $this->userModel->getUser($this->securityService->getUserId()),
                    'form' => $form,
                ]
            )
        );
    }
}
