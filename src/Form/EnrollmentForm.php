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
     *
     * @param EnrollmentModel $enrollmentModel
     * @param array           $data
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
        $classIds = $this->data['classIds'] = $request->get('class_ids', []);
        if (!$classIds) {
            $this->violations['classIds'] = 'Choose at least 1 class';
        }
        $userIds = $this->data['userIds'] = $request->get('user_ids', []);
        if (!$userIds) {
            $this->violations['userIds'] = 'Choose at least 1 user';
        }
        $hasEnrollments = [];

        foreach ($userIds as $userId) {
            foreach ($classIds as $classId) {
                $hasEnrollments[] =$this->enrollmentModel->isEnrollment($userId, $classId);
            }
        }
        if (array_filter($hasEnrollments)) {
            $this->violations['userIds'] = 'Some users has enrolled already';
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