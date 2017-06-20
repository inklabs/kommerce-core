<?php
namespace inklabs\kommerce\Lib\Query;

use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
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

    public function execute(QueryInterface $query): ResponseInterface
    {
        $handler = $this->mapper->getQueryHandler($query);
        $handler->verifyAuthorization($this->authorizationContext);
        return $handler->handle();
    }
}
