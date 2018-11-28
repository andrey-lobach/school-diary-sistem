<?php
/**
 * Created by PhpStorm.
 * UserModel: andrei
 * Date: 14.11.18
 * Time: 17.58
 */

namespace Core\Response;


class Response
{
    const NOT_FOUND = 404;
    const REDIRECT_FOUND = 302;
    const SUCCESS = 200;
    /**
     * @var ResourceInterface
     */
    protected $resource;
    /**
     * @var array
     */
    protected $headers;

    /**
     * Response constructor.
     * @param ResourceInterface $resource
     * @param int $code
     * @param array $headers
     */
    public function __construct(ResourceInterface $resource, int $code = self::SUCCESS, array $headers = [])
    {
        $this->resource = $resource;
        array_unshift($headers, sprintf('HTTP/1.0 %d %s', $code, $this->getMessage($code)));
        $this->headers = $headers;
    }

    public function send()
    {
        foreach ($this->headers as $key => $value) {
            if (is_numeric($key)) {
                $header = $value;
            } else {
                $header = sprintf('%s: %s', $key, $value);
            }
            header($header);
        }
        echo $this->resource->getContent();
    }

    private function getMessage(int $code)
    {
        $messages = [
            self::NOT_FOUND => 'NOT FOUND',
        ];
        //TODO fill messages
        return $messages[$code] ?? '';
    }

}