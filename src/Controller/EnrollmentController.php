<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 25.1.19
 * Time: 12.27
 */

namespace Controller;

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
     * EnrollmentController constructor.
     *
     * @param EnrollmentModel $enrollmentModel
     * @param ClassModel      $classModel
     * @param UserModel       $userModel
     * @param Renderer        $renderer
     * @param SecurityService $securityService
     */
    public function __construct(
        EnrollmentModel $enrollmentModel,
        ClassModel $classModel,
        UserModel $userModel,
        Renderer $renderer,
        SecurityService $securityService
    ) {
        $this->enrollmentModel = $enrollmentModel;
        $this->classModel = $classModel;
        $this->userModel = $userModel;
        $this->renderer = $renderer;
        $this->securityService = $securityService;
    }

    /**
     * @return Response
     */
    public function list(): Response
    {
        $path = 'Enrollment/list.php';

        return new Response(
            $this->renderer->render(
                $path,
                [
                    'classes'         => $this->classModel->getList(),
                    'list'            => $this->classModel->getFullList(),
                    'userModel'       => $this->userModel,
                    'classModel'      => $this->classModel,
                    'enrollmentModel' => $this->enrollmentModel,
                    'currentUserId'   => $this->securityService->getUserId(),
                    'currentRole'     => $this->securityService->getRole(),
                    'roles'           => RolesEnum::class,
                ]
            )
        );
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {
        $userId = $request->get('user_id');
        $classId = $request->get('class_id');
        if (!$this->userModel->getUser($userId)) {
            throw new \RuntimeException('Enrollment or user not exist');
        }
        $this->enrollmentModel->create($userId, $classId, RolesEnum::TEACHER);

        return new RedirectResponse('/enrollment');
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
                $this->enrollmentModel->addStudents($form->getData()['userIds'], $form->getData()['classIds'][0]);

                return new RedirectResponse('/enrollment');
            }
        }
        $path = 'Enrollment/create.php';

        return new Response(
            $this->renderer->render(
                $path,
                [
                    'form'           => $form,
                    'availableUsers' => $this->userModel->getStudentsWithoutEnrollment(),
                    'classes'        => $this->classModel->getList(),
                    'student'        => true,
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
                $this->enrollmentModel->addTeachers($form->getData()['userIds'], $form->getData()['classIds']);

                return new RedirectResponse('/enrollment');
            }
        }
        $path = 'Enrollment/create.php';

        return new Response(
            $this->renderer->render(
                $path,
                [
                    'form'           => $form,
                    'availableUsers' => $this->userModel->getAvailableTeachers(),
                    'classes'        => $this->classModel->getList(),
                    'teacher'        => true,
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
        $this->enrollmentModel->delete($userId, $classId);

        return new RedirectResponse('/enrollment');
    }
}