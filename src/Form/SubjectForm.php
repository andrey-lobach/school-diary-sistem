<?php

namespace Form;

use Core\Request\Request;
use Model\SubjectModel;


class SubjectForm
{

    private $data;
    private $violations = [];
    private $SubjectModel;

    public function __construct(SubjectModel $subjectModel, array $data = [])
    {
        $this->subjectModel = $subjectModel;
        $this->data = $data;
    }

    public function handleRequest(Request $request)
    {
        $this->data['name'] = $request->get('name');
        $id = $this->data['id'] ?? null;
        if ($this->subjectModel->checkName($this->data['name'], $id)) {
            $this->violations['name'] = 'Such subject exists';
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


    public function isValid()
    {
        return count($this->violations) === 0;
    }


}