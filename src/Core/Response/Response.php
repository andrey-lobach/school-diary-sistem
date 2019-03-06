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
    const SWITCHING_PROTOCOLS = 101;
    const OK = 200;
    const CREATED = 201;
    const ACCEPTED = 202;
    const NONAUTHORITATIVE_INFORMATION = 203;
    const NO_CONTENT = 204;
    const RESET_CONTENT = 205;
    const PARTIAL_CONTENT = 206;
    const MULTIPLE_CHOICES = 300;
    const MOVED_PERMANENTLY = 301;
    const MOVED_TEMPORARILY = 302;
    const SEE_OTHER = 303;
    const NOT_MODIFIED = 304;
    const USE_PROXY = 305;
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const PAYMENT_REQUIRED = 402;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const METHOD_NOT_ALLOWED = 405;
    const NOT_ACCEPTABLE = 406;
    const PROXY_AUTHENTICATION_REQUIRED = 407;
    const REQUEST_TIMEOUT = 408;
    const CONFLICT = 408;
    const GONE = 410;
    const LENGTH_REQUIRED = 411;
    const PRECONDITION_FAILED = 412;
    const REQUEST_ENTITY_TOO_LARGE = 413;
    const REQUESTURI_TOO_LARGE = 414;
    const UNSUPPORTED_MEDIA_TYPE = 415;
    const REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const EXPECTATION_FAILED = 417;
    const IM_A_TEAPOT = 418;
    const INTERNAL_SERVER_ERROR = 500;
    const NOT_IMPLEMENTED = 501;
    const BAD_GATEWAY = 502;
    const SERVICE_UNAVAILABLE = 503;
    const GATEWAY_TIMEOUT = 504;
    const HTTP_VERSION_NOT_SUPPORTED = 505;
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
    public function __construct(ResourceInterface $resource, int $code = self::OK, array $headers = [])
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

    /**
     * @param int $code
     *
     * @return mixed|string
     */
    private function getMessage(int $code)
    {
        $messages = [
            self::SWITCHING_PROTOCOLS => 'SWITCHING PROTOCOLS',
            self::OK => 'OK',
            self::CREATED => 'CREATED',
            self::ACCEPTED => 'ACCEPTED',
            self::NONAUTHORITATIVE_INFORMATION => 'NONAUTHORITATIVE INFORMATION',
            self::NO_CONTENT => 'NO CONTENT',
            self::RESET_CONTENT => 'RESET CONTENT',
            self::PARTIAL_CONTENT => 'PARTIAL CONTENT',
            self::MULTIPLE_CHOICES => 'MULTIPLE CHOICES',
            self::MOVED_PERMANENTLY => 'MOVED PERMANENTLY',
            self::SEE_OTHER => 'SEE OTHER',
            self::NOT_MODIFIED => 'NOT MODIFIED',
            self::USE_PROXY => 'USE PROXY',
            self::BAD_REQUEST => 'BAD REQUEST',
            self::UNAUTHORIZED => 'UNAUTHORIZED',
            self::PAYMENT_REQUIRED => 'PAYMENT REQUIRED',
            self::FORBIDDEN => 'FORBIDDEN',
            self::NOT_FOUND => 'NOT FOUND',
            self::METHOD_NOT_ALLOWED => 'METHOD NOT ALLOWED',
            self::NOT_ACCEPTABLE => 'NOT ACCEPTABLE',
            self::PROXY_AUTHENTICATION_REQUIRED => 'PROXY AUTHENTICATION REQUIRED',
            self::REQUEST_TIMEOUT => 'REQUEST TIMEOUT',
            self::CONFLICT => 'CONFLICT',
            self::GONE => 'GONE',
            self::LENGTH_REQUIRED => 'LENGTH REQUIRED',
            self::PRECONDITION_FAILED => 'PRECONDITION FAILED',
            self::REQUEST_ENTITY_TOO_LARGE => 'REQUEST ENTITY TOO LARGE',
            self::REQUESTURI_TOO_LARGE => 'REQUESTURI TOO LARGE',
            self::UNSUPPORTED_MEDIA_TYPE => 'UNSUPPORTED MEDIA TYPE',
            self::REQUESTED_RANGE_NOT_SATISFIABLE => 'REQUESTED RANGE NOT SATISFIABLE',
            self::EXPECTATION_FAILED => 'EXPECTATION FAILED',
            self::IM_A_TEAPOT => 'IM A TEAPOT',
            self::INTERNAL_SERVER_ERROR => 'INTERNAL SERVER ERROR',
            self::NOT_IMPLEMENTED => 'NOT IMPLEMENTED',
            self::BAD_GATEWAY => 'BAD GATEWAY',
            self::SERVICE_UNAVAILABLE => 'SERVICE UNAVAILABLE',
            self::GATEWAY_TIMEOUT => 'GATEWAY TIMEOUT',
            self::HTTP_VERSION_NOT_SUPPORTED => 'HTTP VERSION NOT SUPPORTED'
        ];
        return $messages[$code] ?? '';
    }

}