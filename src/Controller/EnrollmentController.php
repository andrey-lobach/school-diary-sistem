<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 25.1.19
 * Time: 12.27
 */

namespace Controller;


use Core\Response\Response;
use Core\Response\TemplateResource;
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
}