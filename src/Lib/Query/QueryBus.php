<?php
namespace inklabs\kommerce\Lib\Query;

use inklabs\kommerce\Lib\MapperInterface;

class QueryBus implements QueryBusInterface
{
    /** @var MapperInterface */
    private $mapper;

    public function __construct(MapperInterface $mapper)
    {
        $this->mapper = $mapper;
    }

    public function execute(RequestInterface $request, ResponseInterface & $response)
    {
        $handler = $this->mapper->getQueryHandler($request);
        $handler->handle($request, $response);
    }
}
