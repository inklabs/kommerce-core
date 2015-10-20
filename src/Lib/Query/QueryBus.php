<?php
namespace inklabs\kommerce\Lib\Query;

use inklabs\kommerce\Lib\Mapper;

class QueryBus implements QueryBusInterface
{
    /** @var Mapper */
    private $mapper;

    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function execute(RequestInterface $request, ResponseInterface & $response)
    {
        $handler = $this->mapper->getQueryHandler($request);
        $handler->handle($request, $response);
    }
}
