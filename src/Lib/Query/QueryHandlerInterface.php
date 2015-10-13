<?php
namespace inklabs\kommerce\Lib\Query;

interface QueryHandlerInterface
{
    /**
     * @param RequestInterface $request
     * @param ResponseInterface & $response
     * @return void
     */
    public function handle(RequestInterface $request, ResponseInterface & $response);
}
