<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 12.12.18
 * Time: 2.28
 */

namespace Controller;

use Core\HTTP\Exception\NotFoundException;
use Core\HTTP\Exception\RequestException;
use Core\MessageBag;
use Core\Template\Renderer;
use Enum\RolesEnum;
use Model\ClassModel;
use Core\Response\RedirectResponse;
use Core\Response\Response;
use Core\Request\Request;
use Form\ClassForm;
use Model\EnrollmentModel;
use Model\UserModel;
use Service\SecurityService;

class ClassController
{
    private $classModel;

    /**
     * @var Renderer
     */
    private $renderer;

    /**
     * @var UserModel
     */
    private $userModel;

    /**
     * @var SecurityService
     */
    private $securityService;

    /**
     * @var EnrollmentModel
     */
    private $enrollmentModel;

    /**
     * @var MessageBag
     */
    private $messageBag;

    /**
     * ClassController constructor.
     *
     * @param ClassModel      $classModel
     * @param UserModel       $userModel
     * @param Renderer        $renderer
     * @param SecurityService $securityService
     * @param EnrollmentModel $enrollmentModel
     * @param MessageBag      $messageBag
     */
    public function __construct(
        ClassModel $classModel,
        UserModel $userModel,
        Renderer $renderer,
        SecurityService $securityService,
        EnrollmentModel $enrollmentModel,
        MessageBag $messageBag
    ) {
        $this->classModel = $classModel;
        $this->renderer = $renderer;
        $this->userModel = $userModel;
        $this->securityService = $securityService;
        $this->enrollmentModel = $enrollmentModel;
        $this->messageBag = $messageBag;
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function list(): Response
    {
        $classes = $this->classModel->getList();
        $path = 'Class/list.php';

        return new Response(
            $this->renderer->render(
                $path,
                [
                    'classes'         => $classes,
                    'role'            => $this->securityService->getRole(),
                    'enrollmentModel' => $this->enrollmentModel,
                    'currentUserId'   => $this->securityService->getUserId(),
                    'countOfUsers'    => $this->enrollmentModel->countOfUsers(),
                ]
            )
        );
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $form = new ClassForm($this->classModel);
        if ($request->getMethod() === Request::POST) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $this->classModel->create($form->getData());
                $this->messageBag->addMessage('Class created');

                return new RedirectResponse('/classes');
            }
        }
        $path = 'Class/create.php';

        return new Response($this->renderer->render($path, ['form' => $form]));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function edit(Request $request)
    {
        $id = $request->get('id');
        $class = $this->classModel->getClass($id);
        if (null === $class) {
            throw new NotFoundException('Class not found');
        }
        $form = new ClassForm($this->classModel, $class);
        if ($request->getMethod() === Request::POST) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $this->classModel->edit($form->getData(), $id);
                $this->messageBag->addMessage('Class updated');

                return new RedirectResponse('/classes');
            }
        }
        $path = 'Class/create.php';

        return new Response($this->renderer->render($path, ['form' => $form, 'class' => $class]));
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
        if (!$this->classModel->getClass($id)) {
            throw new NotFoundException('Class not found');
        }
        $this->classModel->delete($id);
        $this->messageBag->addMessage('Class deleted');

        return new RedirectResponse('/classes');
    }

    /**
     * @param Request $request
     *
     * @return Response
     * @throws \Exception
     */
    public function listOfClass(Request $request): Response
    {
        $path = 'Class/users.php';
        if ($request->getPath() === '/my-class') {
            $classId = $this->classModel->getStudentClass($this->securityService->getUserId());
        } else {
            $classId = $request->get('id');
        }

        return new Response(
            $this->renderer->render(
                $path,
                [
                    'class'           => $this->classModel->getClass($classId),
                    'list'            => $this->classModel->getListOfClass($classId),
                    'userModel'       => $this->userModel,
                    'role'            => $this->securityService->getRole(),
                    'enrollmentModel' => $this->enrollmentModel,
                    'currentUserId'   => $this->securityService->getUserId(),
                ]
            )
        );
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function joinClass(Request $request): RedirectResponse
    {
        $classId = $request->get('id');
        $teacherId = $this->securityService->getUserId();
        $this->enrollmentModel->create($teacherId, $classId, RolesEnum::TEACHER);
        $this->messageBag->addMessage(sprintf('You are joined to %s class', $this->classModel->getClass($classId)['title']));

        return new RedirectResponse('/classes');
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function leaveClass(Request $request): RedirectResponse
    {
        $classId = $request->get('id');
        $teacherId = $this->securityService->getUserId();
        $this->enrollmentModel->delete($teacherId, $classId);
        $this->messageBag->addMessage(sprintf('You are leaved %s class', $this->classModel->getClass($classId)['title']));

        return new RedirectResponse('/classes');
    }
}