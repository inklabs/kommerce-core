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

    public function execute(QueryInterface $query)
    {
        $handler = $this->mapper->getQueryHandler($query);
        $handler->handle($query);
    }
}
