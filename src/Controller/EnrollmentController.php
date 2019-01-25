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
     * EnrollmentController constructor.
     * @param EnrollmentModel $enrollmentModel
     * @param ClassModel $classModel
     * @param UserModel $userModel
     */
    public function __construct(EnrollmentModel $enrollmentModel, ClassModel $classModel, UserModel $userModel)
    {
        $this->enrollmentModel = $enrollmentModel;
        $this->classModel = $classModel;
        $this->userModel = $userModel;
    }

    /**
     * @return Response
     */
    public function list(): Response
    {
        $classes = $this->classModel->getList();
        $list = [];
        foreach ($classes as $class){
            $students = $this->enrollmentModel->listOfClass($class['id'], 'student');
            $teachers = $this->enrollmentModel->listOfClass($class['id'], 'teacher');
            $list[$class['id']] = ['students' => $students, 'teachers' => $teachers];
        }
        $path = __DIR__ . '/../../app/views/Enrollment/list.php';
        return new Response(new TemplateResource($path, ['classes' => $classes, 'list' => $list, 'userModel' => $this->userModel, 'classModel' => $this->classModel]));
    }

    /**
     * @param Request $request
     * @return Response|RedirectResponse
     */
    public function addStudent(Request $request)
    {
        $form = new EnrollmentForm($this->enrollmentModel);
        if ($request->getMethod() === Request::POST) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $classId = $form->getData()['class_id'];
                foreach ($form->getData()['users'] as $user) {
                    $this->enrollmentModel->create(
                        ['class_id' => $classId, 'user_id' => $user['id'], 'role' => 'student']
                    );
                }
                return new RedirectResponse('/enrollment');
            }
        }
        $students = [];
        foreach ($this->userModel->getList() as $user){
            if (in_array('student', $user['roles']) && count($user['roles']) === 1){
                array_push($students, $user);
            }
        }
        $availableStudents = $this->enrollmentModel->getAvailableUsers($students);
        $path = __DIR__ . '/../../app/views/Enrollment/create.php';
        return new Response(new TemplateResource($path, ['availableUsers' => $availableStudents, 'classes' => $this->classModel->getList(), 'student' => true]));
    }

    /**
     * @param Request $request
     * @return Response|RedirectResponse
     */
    public function addTeacher(Request $request)
    {
        $form = new EnrollmentForm($this->enrollmentModel);
        if ($request->getMethod() === Request::POST) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $classes = $form->getData()['classes'];
                $teachers = $form->getData()['users'];
                foreach($teachers as $teacher){
                    foreach($classes as $class){
                        $this->enrollmentModel->create(['user_id' => $teacher, 'class_id' => $class['id'], 'role' => 'teacher']);
                    }
                }
                return new RedirectResponse('/enrollment');
            }
        }
        $teachers = [];
        foreach ($this->userModel->getList() as $user){
            if (in_array('teacher', $user['roles'])){
                array_push($teachers, $user);
            }
        }
        $path = __DIR__ . '/../../app/views/Enrollment/create.php';
        return new Response(new TemplateResource($path, ['availableUsers' => $teachers, 'classes' => $this->classModel->getList(), 'teacher' => true]));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function delete(Request $request): RedirectResponse
    {
        $id = $request->get('id');
        if (!$this->userModel->getUser($id)){
            throw new \Exception('Enrollment or user not exist');
        }
        $this->enrollmentModel->delete($id);
        return new RedirectResponse('/enrollment');
    }
}