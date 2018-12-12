<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 12.12.18
 * Time: 2.28
 */

namespace Controller;
use Model\ClassModel;
use Core\Response\EmptyResource;
use Core\Response\RedirectResponse;
use Core\Response\Response;
use Core\Request\Request;
use Core\Response\TemplateResource;
use Form\ClassForm;


class ClassController
{
    private $classModel;

    public function __construct(ClassModel $classModel)
    {
        $this->classModel = $classModel;
    }

    public function list()
    {
        $classes = $this->classModel->getList();
        $path = __DIR__ . '/../../app/views/Class/list.php';
        return new Response(new TemplateResource($path, ['classes' => $classes]));
    }
    public function create(Request $request)
    {
        $form = new ClassForm($this->classModel);
        if ($request->getMethod() === Request::POST) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $this->classModel->create($form->getData());
                return new RedirectResponse('/app.php/classes');
            }
        }
        $path = __DIR__ . '/../../app/views/Class/create.php';
        return new Response(new TemplateResource($path, ['form' => $form]));
    }

    public function edit(Request $request)
    {
        $id = $request->get('id');
        $class = $this->classModel->getClass($id);
        if (null === $class) {
            throw new \Exception('class not found');
        }
        $form = new ClassForm($this->classModel, $class);
        if ($request->getMethod() === Request::POST) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $this->classModel->edit($form->getData(), $id);
                return new RedirectResponse('/app.php/classes');
            }
        }
        $path = __DIR__ . '/../../app/views/Class/create.php';
        return new Response(new TemplateResource($path, ['form' => $form, 'class' => $class]));
    }

    public function delete(Request $request)
    {
        $id = $request->get('id');
        if (!$this->classModel->getClass($id)){
            throw new \Exception('Class not exist');
        }
        $this->classModel->delete($id);
        return new RedirectResponse('/app.php/classes');
    }

}