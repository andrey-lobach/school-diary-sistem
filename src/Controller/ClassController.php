<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 12.12.18
 * Time: 2.28
 */

namespace Controller;

use Core\Template\Renderer;
use Model\ClassModel;
use Core\Response\RedirectResponse;
use Core\Response\Response;
use Core\Request\Request;
use Core\Response\TemplateResource;
use Form\ClassForm;

class ClassController
{
    private $classModel;

    /**
     * @var Renderer
     */
    private $renderer;

    /**
     * ClassController constructor.
     *
     * @param ClassModel $classModel
     * @param Renderer   $renderer
     */
    public function __construct(ClassModel $classModel, Renderer $renderer)
    {
        $this->classModel = $classModel;
        $this->renderer = $renderer;
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function list(): Response
    {
        $classes = $this->classModel->getList();
        $path = 'Class/list.php';

        return new Response($this->renderer->render($path, ['classes' => $classes]));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $form = new ClassForm($this->classModel);
        if ($request->getMethod() === Request::POST) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $this->classModel->create($form->getData());

                return new RedirectResponse('/classes');
            }
        }
        $path = 'Class/create.php';

        return new Response($this->renderer->render($path, ['form' => $form]));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function edit(Request $request)
    {
        $id = $request->get('id');
        $class = $this->classModel->getClass($id);
        if (null === $class) {
            throw new \RuntimeException('class not found');
        }
        $form = new ClassForm($this->classModel, $class);
        if ($request->getMethod() === Request::POST) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $this->classModel->edit($form->getData(), $id);

                return new RedirectResponse('/classes');
            }
        }
        $path = 'Class/create.php';

        return new Response($this->renderer->render($path, ['form' => $form, 'class' => $class]));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function delete(Request $request): RedirectResponse
    {
        $id = $request->get('id');
        if (!$this->classModel->getClass($id)) {
            throw new \RuntimeException('Class not exist');
        }
        $this->classModel->delete($id);

        return new RedirectResponse('/classes');
    }
}