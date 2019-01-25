<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 25.1.19
 * Time: 17.45
 */

namespace Form;


use Core\Request\Request;
use Model\EnrollmentModel;

class EnrollmentForm
{
    private $data;
    private $violations = [];
    private $enrollmentModel;

    /**
     * EnrollmentForm constructor.
     * @param EnrollmentModel $enrollmentModel
     * @param array $data
     */
    public function __construct(EnrollmentModel $enrollmentModel, array $data = [])
    {
        $this->data = $data;
        $this->enrollmentModel = $enrollmentModel;
    }

    /**
     * @param Request $request
     */
    public function handleRequest(Request $request)
    {
        $classId = $request->get('class_id');
        if ($classId) {
            $this->data['class_id'] = $classId;
        }
        $classes = $request->get('classes', []);
        if ($classes) {
            $this->data['classes'] = $classes;
        }
        $users = $this->data['users'] = $request->get('users', []);
        if (count($users) === 0) {
            $this->violations['users'] = 'Choose at least 1 user';
        }
        if (!$classId && !$classes) {
            $this->violations['classes'] = 'Class is required';
        }
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getViolations(): array
    {
        return $this->violations;
    }


    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return count($this->violations) === 0;
    }

}