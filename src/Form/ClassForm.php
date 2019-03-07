<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 12.12.18
 * Time: 14.19
 */

namespace Form;
use Core\Request\Request;
use Model\ClassModel;

class ClassForm
{

    private $data;
    private $violations = [];
    private $classModel;

    /**
     * ClassForm constructor.
     * @param ClassModel $classModel
     * @param array $data
     */
    public function __construct(ClassModel $classModel, array $data = [])
    {
        $this->classModel = $classModel;
        $this->data = $data;
    }

    /**
     * @param Request $request
     */
    public function handleRequest(Request $request)
    {
        $this->data['title'] = $request->get('title');
        $id = $this->data['id'] ?? null;
        if ($this->classModel->checkTitle($this->data['title'], $id)) {
            $this->violations['title'] = 'Such title exists';
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