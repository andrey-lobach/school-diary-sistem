<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 12.12.18
 * Time: 1.20
 */

namespace Controller;


use Model\SubjectModel;
use Core\Response\EmptyResource;
use Core\Response\RedirectResponse;
use Core\Response\Response;
use Core\Request\Request;
use Core\Response\TemplateResource;
use Form\SubjectForm;

class SubjectController
{
    private $subjectModel;

    public function __construct(SubjectModel $subjectModel)
    {
        $this->subjectModel = $subjectModel;
    }

    public function list()
    {
        $subjects = $this->subjectModel->getList();
        $path = __DIR__ . '/../../app/views/Subject/list.php';
        return new Response(new TemplateResource($path, ['subjects' => $subjects]));
    }
    public function create(Request $request)
    {
        $form = new SubjectForm($this->subjectModel);
        if ($request->getMethod() === Request::POST) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $this->subjectModel->create($form->getData());
                return new RedirectResponse('/subjects');
            }
        }
        $path = __DIR__ . '/../../app/views/Subject/create.php';
        return new Response(new TemplateResource($path, ['form' => $form]));
    }

    public function edit(Request $request)
    {
        $id = $request->get('id');
        $subject = $this->subjectModel->getSubject($id);
        if (null === $subject) {
            throw new \Exception('subject not found');
        }
        $form = new SubjectForm($this->subjectModel, $subject);
        if ($request->getMethod() === Request::POST) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $this->subjectModel->edit($form->getData(), $id);
                return new RedirectResponse('/subjects');
            }
        }
        $path = __DIR__ . '/../../app/views/Subject/create.php';
        return new Response(new TemplateResource($path, ['form' => $form, 'subject' => $subject]));
    }

    public function delete(Request $request)
    {
        $id = $request->get('id');
        if (!$this->subjectModel->getSubject($id)){
            throw new \Exception('Subject not exist');
        }
        $this->subjectModel->delete($id);
        return new RedirectResponse('/subjects');
    }

}