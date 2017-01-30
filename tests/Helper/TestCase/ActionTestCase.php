<?php
namespace inklabs\kommerce\tests\Helper\TestCase;

use inklabs\kommerce\Lib\Command\CommandBus;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Mapper;
use inklabs\kommerce\Lib\Query\QueryBus;
use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\tests\Helper\Lib\Authorization\AlwaysAuthorizedForTestingAuthorizationContext;

abstract class ActionTestCase extends ServiceTestCase
{
    protected function dispatchCommand(CommandInterface $command)
    {
        $this->getCommandBus()->execute($command);
    }

    protected function dispatchQuery(QueryInterface $query)
    {
        $this->getQueryBus()->execute($query);
    }

    private function getCommandBus()
    {
        return new CommandBus(
            $this->getAuthorizationContext(),
            $this->getMapper(),
            $this->getEventDispatcher()
        );
    }

    private function getQueryBus()
    {
        return new QueryBus($this->getMapper());
    }

    protected function getMapper()
    {
        return new Mapper(
            $this->getRepositoryFactory(),
            $this->getServiceFactory(),
            $this->getPricing(),
            $this->getDTOBuilderFactory()
        );
    }

    private function getAuthorizationContext()
    {
        return $this->getAlwaysAuthorizedForTestingAuthorizationContext();
    }

    protected function getAlwaysAuthorizedForTestingAuthorizationContext()
    {
        return new AlwaysAuthorizedForTestingAuthorizationContext();
    }
}
