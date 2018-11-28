<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 28.11.18
 * Time: 17.25
 */

namespace Core\Response;


class TemplateResource implements ResourceInterface
{
    /**
     * @var string
     */
    private $template;
    /**
     * @var array
     */
    private $data;

    public function __construct(string $template, array $data = [])
    {
        $this->template = $template;
        $this->data = $data;
    }

    public function getContent()
    {
        ob_start();
        require $this->template;
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

}