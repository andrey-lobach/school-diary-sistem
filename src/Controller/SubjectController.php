<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 12.12.18
 * Time: 1.20
 */

namespace Controller;

use Core\Template\Renderer;
use Model\SubjectModel;
use Core\Response\RedirectResponse;
use Core\Response\Response;
use Core\Request\Request;
use Form\SubjectForm;

class SubjectController
{
    private $subjectModel;

    /**
     * @var Renderer
     */
    private $renderer;

    /**
     * SubjectController constructor.
     *
     * @param SubjectModel $subjectModel
     * @param Renderer     $renderer
     */
    public function __construct(SubjectModel $subjectModel, Renderer $renderer)
    {
        $this->subjectModel = $subjectModel;
        $this->renderer = $renderer;
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function list(): Response
    {
        $subjects = $this->subjectModel->getList();
        $path = 'Subject/list.php';

        return new Response($this->renderer->render($path, ['subjects' => $subjects]));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     * @throws \Exception
     */
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
        $path = 'Subject/create.php';

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
        $subject = $this->subjectModel->getSubject($id);
        if (null === $subject) {
            throw new \RuntimeException('subject not found');
        }
        $form = new SubjectForm($this->subjectModel, $subject);
        if ($request->getMethod() === Request::POST) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $this->subjectModel->edit($form->getData(), $id);

                return new RedirectResponse('/subjects');
            }
        }
        $path = 'Subject/create.php';

        return new Response($this->renderer->render($path, ['form' => $form, 'subject' => $subject]));
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
        if (!$this->subjectModel->getSubject($id)) {
            throw new \RuntimeException('Subject not exist');
        }
        $this->subjectModel->delete($id);

        return new RedirectResponse('/subjects');
    }

    /**
     * @param SubjectModel $subjectModel
     *
     * @return SubjectController
     */
    public function setSubjectModel(SubjectModel $subjectModel): SubjectController
    {
        $this->subjectModel = $subjectModel;

        return $this;
    }
}