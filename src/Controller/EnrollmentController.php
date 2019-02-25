<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 25.1.19
 * Time: 12.27
 */

namespace Controller;

use Core\MessageBag;
use Core\Request\Request;
use Core\Response\RedirectResponse;
use Core\Response\Response;
use Core\Template\Renderer;
use Enum\RolesEnum;
use Form\EnrollmentForm;
use Model\ClassModel;
use Model\EnrollmentModel;
use Model\UserModel;
use Service\SecurityService;

class EnrollmentController
{
    /**
     * @var EnrollmentModel
     */
    private $enrollmentModel;

    /**
     * @var ClassModel
     */
    private $classModel;

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
     * EnrollmentController constructor.
     *
     * @param EnrollmentModel $enrollmentModel
     * @param ClassModel      $classModel
     * @param UserModel       $userModel
     * @param Renderer        $renderer
     * @param SecurityService $securityService
     * @param MessageBag      $messageBag
     */
    public function __construct(
        EnrollmentModel $enrollmentModel,
        ClassModel $classModel,
        UserModel $userModel,
        Renderer $renderer,
        SecurityService $securityService,
        MessageBag $messageBag
    ) {
        $this->enrollmentModel = $enrollmentModel;
        $this->classModel = $classModel;
        $this->userModel = $userModel;
        $this->renderer = $renderer;
        $this->securityService = $securityService;
        $this->messageBag = $messageBag;
    }

    /**
     * @param Request $request
     *
     * @return Response|RedirectResponse
     */
    public function addStudent(Request $request)
    {
        $form = new EnrollmentForm($this->enrollmentModel);
        if ($request->getMethod() === Request::POST) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $this->enrollmentModel->addUsers(
                    $form->getData()['userIds'],
                    $classId = $form->getData()['classId'],
                    RolesEnum::STUDENT
                );
                $this->messageBag->addMessage('Students added');
                return new RedirectResponse('/classes/'.$classId);
            }
        }
        $path = 'Enrollment/create.php';

        return new Response(
            $this->renderer->render(
                $path,
                [
                    'form'           => $form,
                    'availableUsers' => $this->userModel->getStudentsWithoutEnrollment(),
                    'student'        => true,
                    'class'          => $this->classModel->getClass($request->get('id')),
                ]
            )
        );
    }

    /**
     * @param Request $request
     *
     * @return Response|RedirectResponse
     */
    public function addTeacher(Request $request)
    {
        $form = new EnrollmentForm($this->enrollmentModel);

        if ($request->getMethod() === Request::POST) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $this->enrollmentModel->addUsers(
                    $form->getData()['userIds'],
                    $form->getData()['classId'],
                    RolesEnum::TEACHER
                );
                $this->messageBag->addMessage('Teachers added');

                return new RedirectResponse('/classes/'.$form->getData()['classId']);
            }
        }
        $path = 'Enrollment/create.php';

        return new Response(
            $this->renderer->render(
                $path,
                [
                    'form'           => $form,
                    'availableUsers' => $this->userModel->getAvailableTeachers($request->get('id')),
                    'student'        => true,
                    'class'          => $this->classModel->getClass($request->get('id')),
                ]
            )
        );
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function delete(Request $request): RedirectResponse
    {
        $userId = $request->get('user_id');
        $classId = $request->get('class_id');
        if (!$this->userModel->getUser($userId)) {
            throw new \RuntimeException('Enrollment or user not exist');
        }
        if ($this->userModel->getUser($userId)['role'] === RolesEnum::TEACHER){
            $this->messageBag->addMessage('Teacher removed');
        } else {
            $this->messageBag->addMessage('Student removed');
        }
        if ($this->securityService->getRole() === RolesEnum::ADMIN) {
            $this->enrollmentModel->delete($userId, $classId);
            return new RedirectResponse('/classes/'.$classId);
        }
        if ($this->userModel->getUser($userId)['role'] === RolesEnum::TEACHER) {
            $this->enrollmentModel->re($userId, $classId);
            return new RedirectResponse('/classes');
        }

        return new RedirectResponse('/classes/'.$classId);
    }


}
