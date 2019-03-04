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

    protected function getOrderLink(
        string $url,
        string $currentField = null,
        string $lastDir = null,
        int $limit = null,
        int $offset = null
    ) {
        $query = [];
        $lastField = null;
        $urlParts = parse_url($url);
        if (array_key_exists('query', $urlParts)) {
            parse_str($urlParts['query'], $query);
            $lastField = $query['order_by'] ?? null;
        }
        if ($currentField) {
            $query['order_by'] = $currentField;
            $query['order_dir'] = (strtolower($lastDir) === 'asc' && $lastField === $currentField) ? 'desc' : 'asc';
        }
        if ($limit) {
            if ($limit > 200) {
                $limit = 200;
            }
            $query['limit'] = $limit;
        }
        $query['offset'] = $offset;
    }
}