<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 30.1.19
 * Time: 18.02
 */

namespace Core\Template;

use Core\MessageBag;
use Core\Response\TemplateResource;

class Renderer
{
    /**
     * @var string
     */
    private $viewDir;

    /**
     * @var MenuBuilder
     */
    private $menuBuilder;

    /**
     * @var MessageBag
     */
    private $messageBag;

    /**
     * Renderer constructor.
     *
     * @param string      $viewDir
     * @param MenuBuilder $menuBuilder
     * @param MessageBag  $messageBag
     */
    public function __construct(string $viewDir, MenuBuilder $menuBuilder, MessageBag $messageBag)
    {
        $this->viewDir = $viewDir;
        $this->menuBuilder = $menuBuilder;
        $this->messageBag = $messageBag;
    }

    /**
     * @param string $path
     * @param array  $params
     *
     * @return TemplateResource
     * @throws \Exception
     */
    public function render(string $path, array $params): TemplateResource
    {
        $params['menu'] = $this->menuBuilder->createMenu();
        $params['flash'] = ['errors' => $this->messageBag->pullErrors(), 'messages' => $this->messageBag->pullMessages()];

        return new TemplateResource($this->getRealPath($path), $params);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    private function getRealPath(string $path): string
    {
        $realPath = $this->viewDir.'/'.$path;
        if (!file_exists($realPath)) {
            throw new \RuntimeException(sprintf('Template %s not exists', $path));
        }

        return $realPath;
    }
}