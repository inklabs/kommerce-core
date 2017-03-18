<?php
namespace inklabs\kommerce\Lib\Query;

use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\HandlerInterface;
use inklabs\kommerce\Lib\MapperInterface;

class QueryBus implements QueryBusInterface
{
    /** @var AuthorizationContextInterface */
    private $authorizationContext;

    /** @var MapperInterface */
    private $mapper;

    public function __construct(
        AuthorizationContextInterface $authorizationContext,
        MapperInterface $mapper
    ) {
        $this->authorizationContext = $authorizationContext;
        $this->mapper = $mapper;
    }

    /**
     * @param QueryInterface $query
     * @return ResponseInterface
     */
    public function execute(QueryInterface $query)
    {
        $handler = $this->mapper->getQueryHandler($query);
        $handler->verifyAuthorization($this->authorizationContext);
        return $handler->handle();
    }
}
