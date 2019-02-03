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
use Core\Response\TemplateResource;
use Core\Template\Renderer;
use Enum\RolesEnum;
use Form\EnrollmentForm;
use Model\ClassModel;
use Model\EnrollmentModel;
use Model\UserModel;

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
     * EnrollmentController constructor.
     *
     * @param EnrollmentModel $enrollmentModel
     * @param ClassModel      $classModel
     * @param UserModel       $userModel
     * @param Renderer        $renderer
     */
    public function __construct(EnrollmentModel $enrollmentModel, ClassModel $classModel, UserModel $userModel, Renderer $renderer)
    {
        $this->enrollmentModel = $enrollmentModel;
        $this->classModel = $classModel;
        $this->userModel = $userModel;
        $this->renderer = $renderer;
    }

    /**
     * @return Response
     */
    public function list(): Response
    {
        $classes = $this->classModel->getList();
        $list = [];
        foreach ($classes as $class) { // TODO
            $students = $this->enrollmentModel->listOfClass($class['id'], RolesEnum::STUDENT);
            $teachers = $this->enrollmentModel->listOfClass($class['id'], RolesEnum::TEACHER);
            $list[$class['id']] = ['students' => $students, 'teachers' => $teachers];
        }
        $path = 'Enrollment/list.php';

        return new Response(
            $this->renderer->render(
                $path,
                [
                    'classes'    => $classes,
                    'list'       => $list,
                    'userModel'  => $this->userModel,
                    'classModel' => $this->classModel,
                ]
            )
        );
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
                $classes = $form->getData()['classIds'];
                $teachers = $form->getData()['userIds'];
                foreach ($teachers as $teacher) {
                    foreach ($classes as $class) {
                        $this->enrollmentModel->create(
                            ['user_id' => $teacher, 'class_id' => $class['id'], 'role' => 'teacher']
                        );
                    }
                }

                return new RedirectResponse('/enrollment');
            }
        }
        $teachers = [];
        foreach ($this->userModel->getList() as $user) {
            if (in_array('teacher', $user['role'])) {
                array_push($teachers, $user);
            }
        }
        $path = 'Enrollment/create.php';

        return new Response(
            new TemplateResource(
                $path,
                [
                    'form'           => $form,
                    'availableUsers' => $this->enrollmentModel->getAvailableTeachers(
                        $teachers,
                        count($this->classModel->getList())
                    ),
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
            throw new \Exception('Enrollment or user not exist');
        }
        $this->enrollmentModel->delete($userId, $classId);

        return new RedirectResponse('/enrollment');
    }
}