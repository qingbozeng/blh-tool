<?php
// +----------------------------------------------------------------------
// | Do what we can do
// +----------------------------------------------------------------------
// | Date  : 2020/4/1 - 1:41 下午
// +----------------------------------------------------------------------
// | Author: seebyyu <seebyyu@gmail.com> :)
// +----------------------------------------------------------------------

namespace Blh\Kernel\Exceptions;


use Psr\Http\Message\ResponseInterface;

class HttpException extends \Exception
{
    /**
     * @var \Psr\Http\Message\ResponseInterface|null
     */
    public $response;

    /**
     * HttpException constructor.
     *
     * @param string                                   $message
     * @param \Psr\Http\Message\ResponseInterface|null $response
     * @param int|null                                 $code
     */
    public function __construct($message, ResponseInterface $response = null, $code = null)
    {
        parent::__construct($message, $code);

        $this->response = $response;

        if ($response) {
            $response->getBody()->rewind();
        }
    }
}